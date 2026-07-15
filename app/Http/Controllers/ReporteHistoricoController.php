<?php

namespace App\Http\Controllers;

use App\Models\Afiliado;
use App\Models\Recibo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteHistoricoController extends Controller
{
    public function index(Request $request)
    {
        $empresaId = session('empresa_id');
        $historicoAfiliado = null;
        $afiliado = null;
        $busqueda = $request->get('busqueda', '');

        // Primero intentar buscar por ID directo
        if ($request->filled('afiliado_id')) {
            $afiliado = Afiliado::find($request->afiliado_id);
        }
        // Luego buscar por texto
        elseif (!empty($busqueda)) {
            $afiliado = Afiliado::where(function ($q) use ($busqueda) {
                $q->where('primer_nombre', 'LIKE', "%{$busqueda}%")
                  ->orWhere('segundo_nombre', 'LIKE', "%{$busqueda}%")
                  ->orWhere('primer_apellido', 'LIKE', "%{$busqueda}%")
                  ->orWhere('segundo_apellido', 'LIKE', "%{$busqueda}%")
                  ->orWhere('numero_documento', 'LIKE', "%{$busqueda}%");
            })->first();
        }

        // Si se encontró afiliado, cargar histórico
        if ($afiliado) {
            $historicoAfiliado = Recibo::select(
                DB::raw('YEAR(fecha) as ano'),
                DB::raw('MONTH(fecha) as mes'),
                DB::raw('DATE_FORMAT(fecha, "%Y-%m") as periodo'),
                'export_batch_id',
                DB::raw('COUNT(*) as cantidad_recibos'),
                DB::raw('SUM(total) as total_pagado')
            )
                ->where('empresa_id', $empresaId)
                ->where('afiliado_id', $afiliado->id)
                ->whereNotNull('export_batch_id')
                ->groupBy('ano', 'mes', 'periodo', 'export_batch_id')
                ->orderBy('ano', 'desc')
                ->orderBy('mes', 'desc')
                ->with('exportBatch')
                ->get();

            // Obtener nombre del operador de cada lote
            $historicoAfiliado->each(function ($item) {
                if ($item->exportBatch) {
                    $codigo = $item->exportBatch->codigo;
                    if (str_contains($codigo, 'PILA')) {
                        $item->operador = 'APORTES EN LÍNEA';
                    } elseif (str_contains($codigo, 'SIMPLE')) {
                        $item->operador = 'PAGO SIMPLE';
                    } else {
                        $item->operador = strtoupper(explode('-', $codigo)[0] ?? 'DESCONOCIDO');
                    }
                } else {
                    $item->operador = 'SIN EXPORTAR';
                }
            });
        }

        return view('reportes.historico-afiliado', compact('afiliado', 'historicoAfiliado', 'busqueda'));
    }

    public function buscarAfiliados(Request $request)
    {
        $busqueda = $request->get('q', '');

        if (strlen($busqueda) < 2) {
            return response()->json([]);
        }

        $afiliados = Afiliado::where(function ($q) use ($busqueda) {
            $q->where('primer_nombre', 'LIKE', "%{$busqueda}%")
              ->orWhere('segundo_nombre', 'LIKE', "%{$busqueda}%")
              ->orWhere('primer_apellido', 'LIKE', "%{$busqueda}%")
              ->orWhere('segundo_apellido', 'LIKE', "%{$busqueda}%")
              ->orWhere('numero_documento', 'LIKE', "%{$busqueda}%");
        })
        ->select('id', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'numero_documento')
        ->limit(10)
        ->get();

        return response()->json($afiliados->map(function ($afl) {
            return [
                'id' => $afl->id,
                'nombre_completo' => trim("{$afl->primer_nombre} {$afl->segundo_nombre} {$afl->primer_apellido} {$afl->segundo_apellido}"),
                'documento' => $afl->numero_documento,
                'display' => trim("{$afl->primer_nombre} {$afl->segundo_nombre} {$afl->primer_apellido} {$afl->segundo_apellido}") . " ({$afl->numero_documento})"
            ];
        }));
    }
}
