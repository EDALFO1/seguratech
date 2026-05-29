@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Crear Usuario</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('usuarios.store') }}" method="POST">

@csrf

@include('modules.users.form')

<button class="btn btn-primary">Guardar</button>

<a href="{{ route('usuarios.index') }}"
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