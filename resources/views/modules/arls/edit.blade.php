@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<div class="pagetitle">
<h1>Editar ARL</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('arls.update',$arl) }}" method="POST">

@csrf
@method('PUT')

@include('modules.arls.form')

<button class="btn btn-primary">
Actualizar
</button>

<a href="{{ route('arls.index') }}"
class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

</section>

@endsection