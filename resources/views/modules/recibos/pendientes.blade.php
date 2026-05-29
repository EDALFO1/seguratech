@extends('layouts.main')

@section('titulo','No se puede cerrar periodo')

@section('contenido')

<div class="pagetitle">
    <h1>❌ No se puede cerrar periodo</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body pt-4">

<div class="alert alert-danger">
    Hay afiliados sin recibo. Debes generarlos antes de cerrar el periodo.
</div>

<table class="table table-bordered">
<thead>
<tr>
<th>Documento</th>
<th>Nombre</th>
</tr>
</thead>

<tbody>
@foreach($afiliados as $a)
<tr>
<td>{{ $a->numero_documento }}</td>
<td>{{ $a->primer_nombre }} {{ $a->primer_apellido }}</td>
</tr>
@endforeach
</tbody>

</table>

<a href="{{ route('recibos.sin_recibo') }}" class="btn btn-primary">
    Ir a generar recibos
</a>

</div>
</div>

</section>

@endsection