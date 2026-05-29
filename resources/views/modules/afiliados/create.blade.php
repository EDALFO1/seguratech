@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Crear Afiliado</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('afiliados.store') }}" method="POST">

@csrf

@php
$afiliado = new \App\Models\Afiliado();
@endphp

@include('modules.afiliados.form')

<button class="btn btn-primary">Guardar</button>

<a href="{{ route('afiliados.index') }}" class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

</div>
</div>

</section>

@endsection