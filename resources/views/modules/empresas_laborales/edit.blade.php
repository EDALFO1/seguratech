@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')


<div class="pagetitle">
<h1>Editar Empresa Laboral</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('empresas_laborales.update',$empresa_laboral) }}" method="POST">

@csrf
@method('PUT')

@include('modules.empresas_laborales.form')

<button class="btn btn-primary">Actualizar</button>

<a href="{{ route('empresas_laborales.index') }}"
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