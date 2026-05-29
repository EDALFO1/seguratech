@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Remisiones</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

<div class="mt-3 mb-3">

<a href="{{ route('remisiones.create') }}" class="btn btn-primary">
Crear Remisión
</a>

</div>

<table class="table table-striped">

<thead>

<tr>
<th>ID</th>
<th>Número</th>
<th>Fecha</th>
<th>Afiliado</th>
<th>Días</th>
<th>Total</th>
<th width="150">Acciones</th>
</tr>

</thead>

<tbody>

@foreach($remisiones as $r)

<tr>

<td>{{ $r->afiliado->numero_documento }}</td>


<td>{{ $r->numero }}</td>

<td>{{ $r->fecha }}</td>

<td>
{{ $r->afiliado->primer_nombre }}
{{ $r->afiliado->primer_apellido }}
</td>

<td>{{ $r->dias_liquidar }}</td>

<td>${{ number_format($r->total,2) }}</td>

<td>

<a href="{{ route('remisiones.edit',$r->id) }}" class="btn btn-warning btn-sm">
Editar
</a>


<form action="{{ route('remisiones.destroy',$r->id) }}" method="POST" style="display:inline">    

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar remisión?')">
Eliminar
</button>

<a href="{{ route('remisiones.imprimir',$r->id) }}" 
class="btn btn-info btn-sm"
target="_blank">
Imprimir
</a>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="mt-3">
{{ $remisiones->links() }}
</div>

</div>
</div>

</div>
</div>

</section>


@endsection