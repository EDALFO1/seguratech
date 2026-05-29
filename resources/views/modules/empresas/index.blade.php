@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Empresas</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('empresas.create') }}" class="btn btn-primary">
Crear Empresa
</a>
</div>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-striped">

<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>NIT</th>
<th>Teléfono</th>
<th>Email</th>
<th>Estado</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($empresas as $empresa)

<tr>

<td>{{ $empresa->id }}</td>
<td>{{ $empresa->nombre }}</td>
<td>{{ $empresa->nit }}</td>
<td>{{ $empresa->telefono }}</td>
<td>{{ $empresa->email }}</td>

<td>
@if($empresa->estado)
<span class="badge bg-success">Activo</span>
@else
<span class="badge bg-danger">Inactivo</span>
@endif
</td>

<td>

<a href="{{ route('empresas.edit',$empresa) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form
action="{{ route('empresas.destroy',$empresa) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('¿Eliminar empresa?')"
class="btn btn-danger btn-sm">
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

</section>



@endsection