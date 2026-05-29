@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Editar Parámetro</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">


<form action="{{ route('parametros_anuales.update', $parametro_anual) }}" method="POST">
    
@csrf
@method('PUT')

@include('modules.parametros_anuales.form')

<button class="btn btn-primary">Actualizar</button>

<a href="{{ route('parametros_anuales.index') }}"
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