@extends('layouts.main')
@section('titulo', $titulo)
@section('contenido')

<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Editar Afiliado</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('afiliados.index') }}">Afiliados</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('afiliados.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<section class="section mt-3">
<div class="row justify-content-center">
<div class="col-xl-10">
<div class="card border-0 shadow-sm">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-semibold">{{ trim(($afiliado->primer_nombre ?? '').' '.($afiliado->primer_apellido ?? '')) ?: 'Editar' }}</h5>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('afiliados.update', $afiliado) }}" method="POST">
            @csrf @method('PUT')
            @include('modules.afiliados.form')
            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Actualizar
                </button>
                <a href="{{ route('afiliados.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <form action="{{ route('afiliados.destroy', $afiliado) }}" method="POST" class="ms-auto form-delete" data-nombre="{{ trim(($afiliado->primer_nombre ?? '').' '.($afiliado->primer_apellido ?? '')) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash me-1"></i>Eliminar
                    </button>
                </form>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</section>

@push('scripts')
<script>
$(function () {
    $('.form-delete').on('submit', function (e) {
        e.preventDefault();
        const form = this;
        const nombre = $(this).data('nombre') || 'este registro';
        Swal.fire({
            title: '¿Eliminar afiliado?',
            text: `«${nombre}» será eliminado permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, eliminar',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endpush

@endsection
