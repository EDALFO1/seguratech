<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        $notas = Nota::latest()->paginate(20);

        return view('modules.notas.index', compact('notas'));
    }

    public function create()
    {
        return view('modules.notas.create');
    }

    public function store(Request $request)
    {
        Nota::create($request->all());

        return redirect()->route('notas.index');
    }

    public function show(Nota $nota)
    {
        return view('modules.notas.show', compact('nota'));
    }

    public function edit(Nota $nota)
    {
        return view('modules.notas.edit', compact('nota'));
    }

    public function update(Request $request, Nota $nota)
    {
        $nota->update($request->all());

        return redirect()->route('notas.index');
    }

    public function destroy(Nota $nota)
    {
        $nota->delete();

        return back();
    }
}