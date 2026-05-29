@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Servicios por Afiliado</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">

<a href="{{ route('afiliado_servicios.create') }}"
class="btn btn-primary">
Asignar Servicio
</a>

</div>

<table class="table table-striped">

<thead>

<tr>
<th>ID</th>
<th>Afiliado</th>
<th>Servicio</th>
<th>Valor</th>
<th>Estado</th>
<th width="150">Acciones</th>
</tr>

</thead>

<tbody>

@foreach($registros as $r)

<tr>

<td>{{ $r->id }}</td>

<td>
{{ $r->afiliado->primer_nombre }}
{{ $r->afiliado->primer_apellido }}
</td>

<td>{{ $r->servicio->nombre }}</td>

<td>${{ number_format($r->valor,2) }}</td>

<td>

@if($r->estado)
<span class="badge bg-success">Activo</span>
@else
<span class="badge bg-danger">Inactivo</span>
@endif

</td>

<td>

<a href="{{ route('afiliado_servicios.edit',$r) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('afiliado_servicios.destroy',$r) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar registro?')">
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