@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')



<div class="pagetitle">
<h1>ARL</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">
<a href="{{ route('arls.create') }}" class="btn btn-primary">
Crear ARL
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
<th>Nivel</th>
<th>Porcentaje</th>
<th>Actividad</th>
<th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($arls as $arl)

<tr>

<td>{{ $arl->id }}</td>
<td>{{ $arl->nombre }}</td>
<td>{{ $arl->codigo }}</td>
<td>{{ $arl->nivel }}</td>
<td>{{ $arl->porcentaje }}%</td>
<td>{{ $arl->actividad_economica }}</td>

<td>

<a href="{{ route('arls.edit',$arl) }}"
class="btn btn-warning btn-sm">
Editar
</a>

<form
action="{{ route('arls.destroy',$arl) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('¿Eliminar ARL?')"
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