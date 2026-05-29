@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<div class="pagetitle">
    <h1>EPS</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body">

<div class="d-flex justify-content-between mb-3 mt-3">

<a href="{{ route('eps.create') }}" class="btn btn-primary">
    Crear EPS
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

@foreach($eps as $item)

<tr>
<td>{{ $item->id }}</td>
<td>{{ $item->nombre }}</td>
<td>{{ $item->codigo }}</td>
<td>{{ $item->porcentaje }}%</td>

<td>

<a href="{{ route('eps.edit',$item->id) }}"
class="btn btn-sm btn-warning">
Editar
</a>

<form action="{{ route('eps.destroy',$item->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('¿Eliminar EPS?')"
class="btn btn-sm btn-danger">
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