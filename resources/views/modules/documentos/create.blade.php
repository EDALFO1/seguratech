@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Crear Documento</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('documentos.store') }}" method="POST">

@csrf

@include('modules.documentos.form')

<button class="btn btn-primary">
Guardar
</button>

<a href="{{ route('documentos.index') }}"
class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

</section>


@endsection