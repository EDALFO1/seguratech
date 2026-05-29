@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Pensiones</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('pensions.create') }}" class="btn btn-primary">
Crear Pensión
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
<th>Código</th>
<th>Porcentaje</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($pensions as $pension)

<tr>

<td>{{ $pension->id }}</td>
<td>{{ $pension->nombre }}</td>
<td>{{ $pension->codigo }}</td>
<td>{{ $pension->porcentaje }}%</td>

<td>

<a href="{{ route('pensions.edit',$pension) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form
action="{{ route('pensions.destroy',$pension) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('¿Eliminar pensión?')"
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