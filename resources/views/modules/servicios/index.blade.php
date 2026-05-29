@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Servicios</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">

<a href="{{ route('servicios.create') }}"
class="btn btn-primary">
Crear Servicio
</a>

</div>

<table class="table table-striped">

<thead>

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Tipo</th>
<th>Valor Base</th>
<th>Estado</th>
<th width="150">Acciones</th>
</tr>

</thead>

<tbody>

@foreach($servicios as $servicio)

<tr>

<td>{{ $servicio->id }}</td>

<td>{{ $servicio->nombre }}</td>

<td>{{ $servicio->tipo }}</td>

<td>${{ number_format($servicio->valor_base,2) }}</td>

<td>

@if($servicio->estado)
<span class="badge bg-success">Activo</span>
@else
<span class="badge bg-danger">Inactivo</span>
@endif

</td>

<td>

<a href="{{ route('servicios.edit',$servicio) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('servicios.destroy',$servicio) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar servicio?')">
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