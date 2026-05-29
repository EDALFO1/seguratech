@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')



<div class="pagetitle">
<h1>Cajas de Compensación</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('cajas.create') }}" class="btn btn-primary">
Crear Caja
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

@foreach($cajas as $caja)

<tr>

<td>{{ $caja->id }}</td>
<td>{{ $caja->nombre }}</td>
<td>{{ $caja->codigo }}</td>
<td>{{ $caja->porcentaje }}%</td>

<td>

<a href="{{ route('cajas.edit',$caja) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form
action="{{ route('cajas.destroy',$caja) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('¿Eliminar caja?')"
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