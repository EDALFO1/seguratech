@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')


<div class="pagetitle">
<h1>Editar EPS</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('eps.update',$eps->id) }}" method="POST">

@csrf
@method('PUT')

@include('modules.eps.form')

<button class="btn btn-primary">
Actualizar
</button>

<a href="{{ route('eps.index') }}"
class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

</section>


@endsection