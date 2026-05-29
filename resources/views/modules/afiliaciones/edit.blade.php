@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')



<div class="pagetitle">
<h1>Editar Afiliación</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('afiliaciones.update',$afiliacion) }}" method="POST">

@csrf
@method('PUT')

@include('modules.afiliaciones.form')

<button class="btn btn-primary">Actualizar</button>

<a href="{{ route('afiliaciones.index') }}" class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

</div>
</div>

</section>

@push('scripts')
<script>
$(document).ready(function () {

    const salarioMinimo = 0; // puedes pasarlo dinámico si quieres

    function manejarIBC() {
        let tipo = $('#tipo_ibc').val();

        if (tipo === 'SMMLV') {
            $('#ibc').prop('readonly', true);
        } else {
            $('#ibc').prop('readonly', false);
        }
    }

    manejarIBC();

    $('#tipo_ibc').on('change', function () {
        manejarIBC();
    });

});
</script>
@endpush



@endsection