<?php

namespace App\Exports;

use App\Models\Empresa;
use App\Models\Recibo;
use App\Helpers\PagoSimpleCodigos;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PagoSimpleExport
{
    protected $empresaId;
    protected $periodo;
    protected $recibos;
    protected $tipoCaja;

    public function __construct($empresaId, $periodo, $recibos = null, $tipoCaja = 'OTROS')
    {
        $this->empresaId = $empresaId;
        $this->periodo = $periodo;
        $this->recibos = $recibos;
        $this->tipoCaja = $tipoCaja; // 'COMFIAR' o 'OTROS'
    }

    public function exportar($rutaCustom = null)
    {
        $spreadsheet = IOFactory::load(
            storage_path('app/templates/ejemplo.xlsx')
        );

        $sheet = $spreadsheet->getActiveSheet();

        $empresa = Empresa::findOrFail($this->empresaId);

        $dt = Carbon::createFromFormat('Y-m', $this->periodo);

        // =====================================================
        // DATOS DE EMPRESA (reemplazar template)
        // =====================================================
        $sheet->setCellValue('D2', strtoupper($empresa->nombre));
        $sheet->setCellValue('F2', $empresa->nit);
        $sheet->setCellValue('K2', 'S');
        $sheet->setCellValue('L2', '0001');
        $sheet->setCellValue('M2', 'PRINCIPAL');

        // =====================================================
        // FILA 2: PERIODOS (Una sola vez)
        // =====================================================
        $sheet->setCellValue("O2", $dt->copy()->subMonthNoOverflow()->format('Y-m'));
        $sheet->setCellValue("P2", $dt->format('Y-m'));
        $sheet->setCellValue("Q2", '');

        if ($this->recibos) {
            $recibos = $this->recibos;
        } else {
            $recibos = Recibo::with([
                'afiliado',
                'afiliado.documento',
                'afiliado.subtipoCotizante',
                'afiliado.afiliaciones.eps',
                'afiliado.afiliaciones.arl',
                'afiliado.afiliaciones.pension',
                'afiliado.afiliaciones.caja',
            ])
                ->where('empresa_id', $this->empresaId)
                ->whereYear('fecha', $dt->year)
                ->whereMonth('fecha', $dt->month)
                ->orderBy('id')
                ->get();
        }

        $fila = 4;
        $contador = 1;
        $primeraArlSeteada = false;

        foreach ($recibos as $r) {

            $a = $r->afiliado;

            if (!$a) {
                continue;
            }

            $afiliacion = $a->afiliaciones
                ->where('estado', 1)
                ->first();

            if (!$afiliacion) {
                continue;
            }

            // =====================================================
            // ARL PARA FILA 2 (primera vez)
            // =====================================================
            if (!$primeraArlSeteada && $afiliacion->arl) {
                $sheet->setCellValue('N2', trim($afiliacion->arl->codigo ?? ''));
                $primeraArlSeteada = true;
            }

            // =====================================================
            // BÁSICOS
            // =====================================================

            $dias = (int) ($r->dias_liquidar ?? 30);
            if ($dias <= 0) $dias = 30;

            $ibc = (float) $r->ibc;

            // =====================================================
            // IBC PROPORCIONAL A DÍAS
            // =====================================================

            $factorDias = $dias / 30;
            $ibcProporcional = ceil(($ibc * $factorDias) / 100) * 100;

            // =====================================================
            // VALIDAR PENSIÓN Y CAJA
            // =====================================================

            $tienePension = $afiliacion->pension &&
                strtoupper(trim($afiliacion->pension->nombre ?? '')) !== 'NINGUNA';

            $tieneCaja = $afiliacion->caja &&
                strtoupper(trim($afiliacion->caja->nombre ?? '')) !== 'NINGUNA';

            // =====================================================
            // LÓGICA DE CAJA: COMFIAR siempre con IBC=1000
            // =====================================================

            $nombreCaja = strtoupper(trim($afiliacion->caja?->nombre ?? ''));

            // COMFIAR (sin caja o COMFIAR explícita) → IBC=1000
            if (!$tieneCaja || str_contains($nombreCaja, 'COMFIAR')) {
                $codigoCajaPagoSimple = 'CCF67';
                $ibcCajaPagoSimple = 1000;
            } else {
                // Otras cajas → IBC completo
                $codigoCajaPagoSimple = PagoSimpleCodigos::obtenerCodigoCaja($nombreCaja);
                $ibcCajaPagoSimple = $ibc;
            }

            // =====================================================
            // LLENAR DATOS
            // =====================================================

            $sheet->setCellValue("A{$fila}", 2);
            $sheet->setCellValue("B{$fila}", $contador);
            $sheet->setCellValueExplicit("C{$fila}", strtoupper($a->documento->nombre ?? 'CC'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$fila}", $a->numero_documento, DataType::TYPE_STRING);
            $sheet->setCellValue("E{$fila}", 1);

            // F: Subtipo de cotizante (código, no id)
            $subtipo = (int) ($a->subtipoCotizante?->codigo ?? 5);
            $sheet->setCellValue("F{$fila}", $subtipo);

            $sheet->setCellValue("G{$fila}", '');
            $sheet->setCellValue("H{$fila}", '');

            // Departamento y municipio según tipo de caja
            $codigoDepartamento = PagoSimpleCodigos::obtenerCodigoDepartamentoPorCaja($this->tipoCaja);
            $sheet->setCellValue("I{$fila}", (float) $codigoDepartamento);
            $sheet->setCellValue("J{$fila}", 1);

            $sheet->setCellValue("K{$fila}", strtoupper($a->primer_apellido ?? ''));
            $sheet->setCellValue("L{$fila}", strtoupper($a->segundo_apellido ?? ''));
            $sheet->setCellValue("M{$fila}", strtoupper($a->primer_nombre ?? ''));
            $sheet->setCellValue("N{$fila}", strtoupper($a->segundo_nombre ?? ''));

            // =====================================================
            // NOVEDADES: Marcar en columnas correctas
            // =====================================================

            // O: Ingreso (solo si es nuevo en el mes anterior)
            $fechaAfiliacion = Carbon::parse($afiliacion->fecha_afiliacion);
            $mesAnterior = $dt->copy()->subMonthNoOverflow();

            if ($fechaAfiliacion->year == $mesAnterior->year &&
                $fechaAfiliacion->month == $mesAnterior->month) {
                $sheet->setCellValue("O{$fila}", 'X');
            } else {
                $sheet->setCellValue("O{$fila}", '');
            }

            // P: Retiro (SOLO si novedad es RETIRO)
            if (strtoupper(trim($r->novedad ?? '')) === 'RETIRO') {
                $sheet->setCellValue("P{$fila}", 'X');
            } else {
                $sheet->setCellValue("P{$fila}", '');
            }

            // Q-AF: Vacíos (campos de traslados y otros)
            for ($col = 'Q'; $col <= 'AF'; $col++) {
                $sheet->setCellValue("{$col}{$fila}", '');
            }

            // =====================================================
            // COTIZACIONES
            // =====================================================

            $codigoEps = PagoSimpleCodigos::obtenerCodigoEps($afiliacion->eps?->nombre ?? '');
            $sheet->setCellValue("AG{$fila}", $codigoEps);

            // AI: CCF/Caja (siempre, usa COMFIAR si no tiene caja)
            $sheet->setCellValue("AI{$fila}", $codigoCajaPagoSimple);

            // AJ: Días AFP (solo si tiene pensión)
            $sheet->setCellValue("AJ{$fila}", $tienePension ? $dias : 0);

            $sheet->setCellValue("AK{$fila}", $dias);
            $sheet->setCellValue("AL{$fila}", $dias);

            // AM: Días CCF (siempre)
            $sheet->setCellValue("AM{$fila}", $dias);

            $sheet->setCellValue("AN{$fila}", $ibc);
            $sheet->setCellValue("AO{$fila}", 'F');

            // AP: IBC AFP (proporcional, solo si tiene pensión)
            $sheet->setCellValue("AP{$fila}", $tienePension ? $ibcProporcional : 0);

            // AQ-AS: IBC (proporcional)
            $sheet->setCellValue("AQ{$fila}", $ibcProporcional);
            $sheet->setCellValue("AR{$fila}", $ibcProporcional);
            // AS: IBC CCF (1000 para COMFIAR, proporcional para otras)
            if (!$tieneCaja || str_contains($nombreCaja, 'COMFIAR')) {
                $sheet->setCellValue("AS{$fila}", 1000);
            } else {
                $sheet->setCellValue("AS{$fila}", $ibcProporcional);
            }

            // AFP: Solo si tiene pensión
            if ($tienePension) {
                $tarifaPension = (float) ($afiliacion->pension?->porcentaje ?? 16);
                $codigoAfp = $afiliacion->pension?->codigo ?? '';
                $cotizacionAfp = ceil(($ibcProporcional * ($tarifaPension / 100)) / 100) * 100;

                $sheet->setCellValue("AE{$fila}", $codigoAfp);
                $sheet->setCellValue("AT{$fila}", ($tarifaPension / 100));
                $sheet->setCellValue("AU{$fila}", $cotizacionAfp);
                $sheet->setCellValue("AV{$fila}", 0);
                $sheet->setCellValue("AW{$fila}", 0);
                $sheet->setCellValue("AX{$fila}", 0);
            } else {
                $sheet->setCellValue("AE{$fila}", '');
                $sheet->setCellValue("AT{$fila}", 0);
                $sheet->setCellValue("AU{$fila}", 0);
                $sheet->setCellValue("AV{$fila}", 0);
                $sheet->setCellValue("AW{$fila}", 0);
                $sheet->setCellValue("AX{$fila}", 0);
            }

            $sheet->setCellValue("AY{$fila}", 0);
            $sheet->setCellValue("AZ{$fila}", 0);
            $sheet->setCellValue("BA{$fila}", 0);

            // EPS: 4% (proporcional a días)
            $sheet->setCellValue("BB{$fila}", 0.04);
            $cotizacionEps = ceil(($ibcProporcional * 0.04) / 100) * 100;
            $sheet->setCellValue("BC{$fila}", $cotizacionEps);

            // Otros valores (0)
            for ($col = 'BD'; $col <= 'BH'; $col++) {
                $sheet->setCellValue("{$col}{$fila}", 0);
            }

            // ARL: Tarifa validada (proporcional a días)
            $tarifaArl = 0.0696;
            if ($afiliacion->arl && $afiliacion->arl->porcentaje) {
                $tarifaArlBd = (float) $afiliacion->arl->porcentaje / 100;
                $tarifasValidas = [0.00522, 0.01044, 0.02436, 0.0435, 0.0696];
                if (in_array($tarifaArlBd, $tarifasValidas)) {
                    $tarifaArl = $tarifaArlBd;
                }
            }

            $sheet->setCellValue("BI{$fila}", $tarifaArl);
            $sheet->setCellValue("BJ{$fila}", 0);
            $cotizacionArl = ceil(($ibcProporcional * $tarifaArl) / 100) * 100;
            $sheet->setCellValue("BK{$fila}", $cotizacionArl);

            // CCF: 4% (proporcional a días)
            $sheet->setCellValue("BL{$fila}", 0.04);
            // Si es COMFIAR, usar 1000 proporcionalizado; si no, usar ibcProporcional
            $ibcCajaProporcional = (!$tieneCaja || str_contains($nombreCaja, 'COMFIAR'))
                ? ceil((1000 * $factorDias) / 100) * 100
                : $ibcProporcional;
            $cotizacionCcf = ceil(($ibcCajaProporcional * 0.04) / 100) * 100;
            $sheet->setCellValue("BM{$fila}", $cotizacionCcf);

            // Parafiscales (0)
            for ($col = 'BN'; $col <= 'BU'; $col++) {
                $sheet->setCellValue("{$col}{$fila}", 0);
            }

            $sheet->setCellValue("BV{$fila}", '');
            $sheet->setCellValue("BW{$fila}", '');

            $sheet->setCellValue("BX{$fila}", 'S');

            // BY: ARL código
            $codigoArl = '';
            if ($afiliacion->arl) {
                if (!empty($afiliacion->arl->codigo)) {
                    $codigoArl = trim($afiliacion->arl->codigo);
                }
            }
            $sheet->setCellValue("BY{$fila}", $codigoArl);

            $sheet->setCellValue("BZ{$fila}", 5);

            // CA: Vacío
            $sheet->setCellValue("CA{$fila}", '');

            // CB: Fecha de ingreso (si es nuevo en ese mes)
            if ($fechaAfiliacion->year == $mesAnterior->year &&
                $fechaAfiliacion->month == $mesAnterior->month) {
                $sheet->setCellValue("CB{$fila}", $fechaAfiliacion->format('Y-m-d'));
            } else {
                $sheet->setCellValue("CB{$fila}", '');
            }

            // CC: Fecha de retiro (SOLO si novedad es RETIRO)
            if (strtoupper(trim($r->novedad ?? '')) === 'RETIRO') {
                $sheet->setCellValue("CC{$fila}", Carbon::parse($r->fecha_retiro)->format('Y-m-d'));
            } else {
                $sheet->setCellValue("CC{$fila}", '');
            }

            // CD-CS: Fechas y datos adicionales (vacíos)
            for ($col = 'CD'; $col <= 'CS'; $col++) {
                $sheet->setCellValue("{$col}{$fila}", '');
            }

            // CT: Actividad económica (vacío)
            $sheet->setCellValue("CT{$fila}", '');

            $fila++;
            $contador++;
        }

        // =====================================================
        // GUARDAR
        // =====================================================

        if ($rutaCustom) {
            $ruta = $rutaCustom;
        } else {
            $nombreArchivo = 'PagoSimple_' . $dt->format('m_Y') . '.xlsx';
            $ruta = storage_path('app/temp/' . $nombreArchivo);
        }

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($ruta);

        return $ruta;
    }
}
