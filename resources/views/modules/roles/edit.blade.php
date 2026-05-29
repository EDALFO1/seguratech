@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Editar Rol</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('roles.update',$role) }}" method="POST">

@csrf
@method('PUT')

@include('modules.roles.form')

<button class="btn btn-primary">Actualizar</button>

<a href="{{ route('roles.index') }}"
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