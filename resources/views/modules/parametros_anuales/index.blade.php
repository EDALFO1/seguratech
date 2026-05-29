@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Parámetros Anuales</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('parametros_anuales.create') }}"
class="btn btn-primary">
Crear Parámetro
</a>
</div>

<table class="table table-striped">

<thead>
<tr>
<th>ID</th>
<th>Año</th>
<th>Salario Mínimo</th>
<th>Administración</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($parametros as $parametro)

<tr>

<td>{{ $parametro->id }}</td>
<td>{{ $parametro->anio }}</td>
<td>{{ number_format($parametro->salario_minimo,2) }}</td>
<td>{{ number_format($parametro->administracion,2) }}</td>

<td>

<a href="{{ route('parametros_anuales.edit',$parametro) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('parametros_anuales.destroy',$parametro) }}"
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