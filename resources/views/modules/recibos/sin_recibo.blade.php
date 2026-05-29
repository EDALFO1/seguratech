@extends('layouts.main')

@section('titulo','Afiliados sin Recibo')

@section('contenido')

<div class="pagetitle">
    <h1>Afiliados sin Recibo</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('recibos.generar.todos') }}" method="POST">
@csrf
<button class="btn btn-success mb-3">
    Generar todos los recibos
</button>
</form>

<table class="table table-bordered">
<thead>
<tr>
<th>Documento</th>
<th>Nombre</th>
<th>Acción</th>
</tr>
</thead>

<tbody>
@forelse($afiliados as $a)
<tr>
<td>{{ $a->numero_documento }}</td>
<td>{{ $a->primer_nombre }} {{ $a->primer_apellido }}</td>

<td>
<form action="{{ route('recibos.generar.uno', $a->id) }}" method="POST">
@csrf
<button class="btn btn-primary btn-sm">
    Generar
</button>
</form>
</td>

</tr>
@empty
<tr>
<td colspan="3">Todos tienen recibo ✔</td>
</tr>
@endforelse
</tbody>

</table>

</div>
</div>

</section>

@endsection