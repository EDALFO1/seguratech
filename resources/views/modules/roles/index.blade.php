@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Roles</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('roles.create') }}" class="btn btn-primary">
Crear Rol
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
<th>Descripción</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($roles as $role)

<tr>
<td>{{ $role->id }}</td>
<td>{{ $role->nombre }}</td>
<td>{{ $role->descripcion }}</td>

<td>

<a href="{{ route('roles.edit',$role) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form action="{{ route('roles.destroy',$role) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('¿Eliminar rol?')"
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