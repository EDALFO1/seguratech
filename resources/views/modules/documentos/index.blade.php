@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Tipos de Documento</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('documentos.create') }}" class="btn btn-primary">
Crear Documento
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
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($documentos as $documento)

<tr>

<td>{{ $documento->id }}</td>
<td>{{ $documento->nombre }}</td>
<td>{{ $documento->codigo }}</td>

<td>

<a href="{{ route('documentos.edit',$documento) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form
action="{{ route('documentos.destroy',$documento) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('¿Eliminar documento?')"
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