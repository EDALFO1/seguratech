<?php

namespace App\Http\Controllers;

use App\Models\Incapacidad;
use App\Models\Afiliado;
use App\Models\EmpresaLaboral;
use App\Models\Eps;
use App\Models\Arl;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IncapacidadController extends Controller
{
    public function index()
    {
        $incapacidades = Incapacidad::with([
            'afiliado',
            'empresaLaboral',
            'eps',
            'arl'
        ])
        ->latest()
        ->paginate(20);

        return view('modules.incapacidades.index', compact('incapacidades'));
    }

    public function create()
    {
        $afiliados = Afiliado::orderBy('primer_apellido')->get();
        $empresasLaborales = EmpresaLaboral::orderBy('nombre')->get();

        $eps = Eps::orderBy('nombre')->get();
        $arls = Arl::orderBy('nombre')->get();

        return view('modules.incapacidades.create', compact(
            'afiliados',
            'empresasLaborales',
            'eps',
            'arls'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'afiliado_id' => 'nullable|exists:afiliados,id',
            'empresa_laboral_id' => 'nullable|exists:empresas_laborales,id',

            'documento' => 'required|string|max:50',
            'nombre' => 'required|string|max:255',

            'entidad_tipo' => ['required', Rule::in(['EPS','ARL'])],

            'eps_id' => 'nullable|exists:eps,id',
            'arl_id' => 'nullable|exists:arls,id',

            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',

            'dias_solicitados' => 'required|integer|min:1',

            'estado' => 'nullable|string',
        ]);

        $data = $request->except('empresa_id');

        Incapacidad::create($data);

        return redirect()->route('incapacidades.index')
            ->with('success','Incapacidad registrada');
    }

    public function show(Incapacidad $incapacidad)
    {
        return view('modules.incapacidades.show', compact('incapacidad'));
    }

    public function edit(Incapacidad $incapacidad)
    {
        $afiliados = Afiliado::orderBy('primer_apellido')->get();
        $empresasLaborales = EmpresaLaboral::orderBy('nombre')->get();

        $eps = Eps::orderBy('nombre')->get();
        $arls = Arl::orderBy('nombre')->get();

        return view('modules.incapacidades.edit', compact(
            'incapacidad',
            'afiliados',
            'empresasLaborales',
            'eps',
            'arls'
        ));
    }

    public function update(Request $request, Incapacidad $incapacidad)
    {
        $request->validate([
            'afiliado_id' => 'nullable|exists:afiliados,id',
            'empresa_laboral_id' => 'nullable|exists:empresas_laborales,id',

            'documento' => 'required|string|max:50',
            'nombre' => 'required|string|max:255',

            'entidad_tipo' => ['required', Rule::in(['EPS','ARL'])],

            'eps_id' => 'nullable|exists:eps,id',
            'arl_id' => 'nullable|exists:arls,id',

            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',

            'dias_solicitados' => 'required|integer|min:1',
        ]);

        $data = $request->except('empresa_id');

        $incapacidad->update($data);

        return redirect()->route('incapacidades.index')
            ->with('success','Incapacidad actualizada');
    }

    public function destroy(Incapacidad $incapacidad)
    {
        $incapacidad->delete();

        return back()->with('success','Incapacidad eliminada');
    }
}