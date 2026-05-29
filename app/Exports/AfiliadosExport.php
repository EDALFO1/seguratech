<?php

namespace App\Exports;

use App\Models\Afiliacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\ParametroAnual;
use Carbon\Carbon;

class AfiliadosExport implements FromCollection
{
    protected $filtros;

    public function __construct($filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function collection()
    {
        $query = Afiliacion::with([
            'afiliado.empresaLaboral',
            'afiliado.subtipoCotizante',
            'afiliado.documento',
            'eps',
            'arl',
            'pension',
            'caja'
        ])
        ->where('empresa_id', session('empresa_id'));

        // 🔥 FILTRO POR ESTADO
        if (($this->filtros['estado'] ?? '') !== '') {
            $query->where('estado', $this->filtros['estado']);
        }

        // 🔍 BUSCADOR
        if (!empty($this->filtros['buscar'])) {
            $buscar = $this->filtros['buscar'];

            $query->whereHas('afiliado', function ($q) use ($buscar) {
                $q->where('primer_nombre', 'like', "%$buscar%")
                  ->orWhere('primer_apellido', 'like', "%$buscar%")
                  ->orWhere('numero_documento', 'like', "%$buscar%");
            });
        }

        // 📅 AÑO ACTUAL
        $anioActual = Carbon::now()->year;

        // 📊 PARÁMETRO ANUAL (SMMLV)
        $parametroActual = ParametroAnual::where('empresa_id', session('empresa_id'))
            ->where('anio', $anioActual)
            ->first();

        // 🔐 EVITA ERRORES SI NO EXISTE
        $salarioMinimo = $parametroActual?->salario_minimo ?? 0;

        return $query->get()->map(function ($af) use ($salarioMinimo) {

            $a = $af->afiliado;

            $nombreCompleto = trim(
                $a->primer_nombre . ' ' .
                ($a->segundo_nombre ?? '') . ' ' .
                $a->primer_apellido . ' ' .
                ($a->segundo_apellido ?? '')
            );

            return [
                // 🔹 AFILIADO
                'Nombre' => $nombreCompleto,
                'Documento' => ($a->documento?->nombre ?? '') . ' ' . $a->numero_documento,
                'Dirección' => $a->direccion ?? '',
                'Teléfono' => $a->telefono ?? '',
                'Correo' => $a->correo ?? '',
                'Empresa Laboral' => $a->empresaLaboral?->nombre ?? '',
                'Subtipo Cotizante' => $a->subtipoCotizante?->nombre ?? '',

                // 🔹 AFILIACIÓN
                'EPS' => $af->eps?->nombre ?? '',
                'ARL' => $af->arl?->codigo ?? '',
                'Nivel ARL' => $af->nivel_arl ?? '',
                'Pensión' => $af->pension?->nombre ?? '',
                'Caja' => $af->caja?->nombre ?? '',

                // 🔥 IBC DINÁMICO
                'IBC' => $af->tipo_ibc === 'SMMLV'
                    ? $salarioMinimo
                    : $af->ibc,

                'Fecha Afiliación' => optional($af->fecha_afiliacion)->format('Y-m-d'),
                'Fecha Retiro' => optional($af->fecha_retiro)->format('Y-m-d'),
                'Estado Afiliación' => $af->estado ? 'Activa' : 'Inactiva',
            ];
        });
    }
}