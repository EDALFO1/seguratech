@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Editar Asesor</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('asesores.update',$asesor) }}" method="POST">

@csrf
@method('PUT')

@include('modules.asesores.form')

<button class="btn btn-primary">Actualizar</button>

<a href="{{ route('asesores.index') }}"
class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

</div>
</div>

</section>

@endsection