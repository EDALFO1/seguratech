@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Empresas Laborales</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('empresas_laborales.create') }}"
class="btn btn-primary">
Crear Empresa Laboral
</a>
</div>

<table class="table table-striped">

<thead>
<tr>
<th>ID</th>
<th>Documento</th>
<th>N° Documento</th>
<th>Nombre</th>
<th>Teléfono</th>
<th>Estado</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($empresas as $empresa)

<tr>

<td>{{ $empresa->id }}</td>
<td>{{ $empresa->documento->nombre }}</td>
<td>{{ $empresa->numero_documento }}</td>
<td>{{ $empresa->nombre }}</td>
<td>{{ $empresa->telefono }}</td>

<td>
@if($empresa->estado)
<span class="badge bg-success">Activo</span>
@else
<span class="badge bg-danger">Inactivo</span>
@endif
</td>

<td>

<a href="{{ route('empresas_laborales.edit',$empresa) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('empresas_laborales.destroy',$empresa) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar empresa laboral?')">
Eliminar
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>

</div>
</div>

</section>

@endsection