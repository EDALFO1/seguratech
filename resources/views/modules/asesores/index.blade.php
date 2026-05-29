@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Asesores</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('asesores.create') }}"
class="btn btn-primary">
Crear Asesor
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
<th>Email</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($asesores as $asesor)

<tr>
<td>{{ $asesor->id }}</td>
<td>{{ $asesor->documento->nombre }}</td>
<td>{{ $asesor->numero_documento }}</td>
<td>{{ $asesor->nombre }}</td>
<td>{{ $asesor->telefono }}</td>
<td>{{ $asesor->email }}</td>

<td>

<a href="{{ route('asesores.edit',$asesor) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('asesores.destroy',$asesor) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar asesor?')">
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