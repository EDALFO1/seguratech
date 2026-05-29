@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Subtipos de Cotizantes</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('subtipo_cotizantes.create') }}" class="btn btn-primary">
Crear Subtipo
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
<th>Código</th>
<th>Nombre</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($subtipos as $subtipo)

<tr>

<td>{{ $subtipo->id }}</td>
<td>{{ $subtipo->codigo }}</td>
<td>{{ $subtipo->nombre }}</td>

<td>

<a href="{{ route('subtipo_cotizantes.edit',$subtipo) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('subtipo_cotizantes.destroy',$subtipo) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('¿Eliminar subtipo?')"
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

</div>
</div>

</section>


@endsection