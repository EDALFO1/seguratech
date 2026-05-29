<?php

namespace App\Exports;

use App\Models\Afiliado;
use App\Models\Recibo;
use App\Models\Afiliacion;
use App\Http\Controllers\ReciboController;
use Maatwebsite\Excel\Concerns\FromCollection;

class AfiliadosVigentesExport implements FromCollection
{
    public function collection()
    {
        $empresaId = session('empresa_id');

        $periodoFecha = now()->subMonth();

        // =========================
        // 🔥 AFILIADOS CON RECIBO MES ANTERIOR
        // =========================
        $idsRecibo = Recibo::where('empresa_id', $empresaId)
            ->whereNull('fecha_retiro')
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->pluck('afiliado_id');

        // =========================
        // 🔥 AFILIADOS NUEVOS DEL MES ANTERIOR
        // =========================
        $idsIngreso = Afiliado::where('empresa_id', $empresaId)
            ->where('estado', 1)
            ->whereMonth('created_at', $periodoFecha->month)
            ->whereYear('created_at', $periodoFecha->year)
            ->pluck('id');

        // =========================
        // 🔥 UNIFICAR
        // =========================
        $ids = $idsRecibo->merge($idsIngreso)->unique();

        // =========================
        // 🔥 TRAER AFILIADOS ACTIVOS
        // =========================
        $afiliados = Afiliado::with([
                'empresa',
                'subtipoCotizante',
                'empresaLaboral'
            ])
            ->whereIn('id', $ids)
            ->where('estado', 1)
            ->get();

        // =========================
        // 🔥 CONTROLADOR PARA CALCULO
        // =========================
        $reciboController = new ReciboController();

        // =========================
        // 🔥 MAPEO FINAL
        // =========================
        return $afiliados->map(function ($a) use ($reciboController) {

            // 🔥 CALCULO REAL (SIN RECIBO)
            $data = $reciboController->calcularRecibo(
                $a->id,
                now()
            );

            $total = $data['total'] ?? 0;

            // 🔥 AFILIACION
            $afiliacion = Afiliacion::with(['eps','caja'])
                ->where('afiliado_id', $a->id)
                ->where('estado', 1)
                ->first();

            // 🔥 NOMBRE COMPLETO
            $nombre = trim(
                ($a->primer_nombre ?? '') . ' ' .
                ($a->segundo_nombre ?? '') . ' ' .
                ($a->primer_apellido ?? '') . ' ' .
                ($a->segundo_apellido ?? '')
            );

            return [
                'Empresa' => $a->empresa->nombre ?? '',
                'Documento' => $a->numero_documento,
                'Nombre completo' => $nombre,
                'Telefono' => $a->telefono,

                // 🔥 VALOR REAL
                'Total Pagar' => $total,

                'Subtipo Cotizante' => $a->subtipoCotizante->nombre ?? '',
                'EPS' => $afiliacion->eps->nombre ?? '',
                'Nivel ARL' => $afiliacion->nivel_arl ?? '',
                'Caja' => $afiliacion->caja->nombre ?? '',
                'Fecha Ingreso' => $afiliacion->fecha_afiliacion ?? '',
                'Empresa Laboral' => $a->empresaLaboral->nombre ?? '',
            ];
        });
    }
}