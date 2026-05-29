@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Afiliaciones</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('afiliaciones.create') }}" class="btn btn-primary">
Crear Afiliación
</a>
</div>

{{-- ALERTA SI NO HAY AFILIADOS --}}
@if($afiliados->isEmpty())
<div class="alert alert-danger">
⚠️ No hay afiliados registrados. 
<a href="{{ route('afiliados.create') }}" class="btn btn-sm btn-primary">
Crear Afiliado
</a>
</div>
@endif

{{-- FILTROS --}}
<div class="card mb-3">
<div class="card-body pt-3">

<form method="GET" action="{{ route('afiliaciones.index') }}">

<div class="row">

<div class="col-md-4">
<input type="text" name="buscar" class="form-control"
placeholder="Buscar afiliado o documento"
value="{{ request('buscar') }}">
</div>




<div class="col-md-4 d-flex justify-content-end gap-2">
    <button class="btn btn-primary">
        Buscar
    </button>

    <a href="{{ route('afiliaciones.index') }}" class="btn btn-secondary">
        Limpiar
    </a>
</div>

</div>
</form>

</div>
</div>

<div class="mb-2">
    Total afiliaciones: {{ $afiliaciones->total() }}
</div>
{{-- FIN FILTROS --}}

<table class="table data-table">

<thead>
<tr>
<th>Doc.</th>
<th>Afiliado</th>
<th>EPS</th>
<th>ARL</th>
<th>Pensión</th>
<th>Caja</th>
<th>Fecha Afiliación</th>
<th>Estado</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@forelse($afiliaciones as $a)

<tr>



<td>{{ optional($a->afiliado)->numero_documento ?? 'N/A' }}</td>

<td>
{{ optional($a->afiliado)->primer_nombre ?? 'Sin afiliado' }}
{{ optional($a->afiliado)->primer_apellido ?? '' }}
</td>

<td>{{ optional($a->eps)->nombre ?? '-' }}</td>

<td>
    {{ $a->nivel_arl ? 'N'.$a->nivel_arl : '' }}
</td>

<td>{{ optional($a->pension)->nombre ?? '-' }}</td>

<td>{{ optional($a->caja)->nombre ?? '-' }}</td>

<td>{{ $a->fecha_afiliacion }}</td>

<td>
@if($a->estado)
<span class="badge bg-success">Activo</span>
@else
<span class="badge bg-danger">Retirado</span>
@endif
</td>

<td>

<a href="{{ route('afiliaciones.edit',$a) }}" class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('afiliaciones.destroy',$a) }}" method="POST" style="display:inline">
@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar afiliación?')">
Eliminar
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="9" class="text-center">
No hay afiliaciones registradas
</td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">
{{ $afiliaciones->links() }}
</div>

</div>
</div>

</div>
</div>

</section>

@endsection