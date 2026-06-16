@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Editar Plan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('planes.index') }}">Planes</a></li>
                <li class="breadcrumb-item active">{{ $plan->nombre }}</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('planes.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<section class="section mt-3">
<div class="row justify-content-center">
<div class="col-xl-10">

<div class="card shadow-sm border-0">
    <div class="card-header py-3">
        <h5 class="mb-0 fw-semibold">{{ $plan->nombre }}</h5>
        <p class="text-muted small mb-0 mt-1">
            Los cambios de porcentaje se reflejarán en los cálculos de todos los años.
        </p>
    </div>
    <div class="card-body pt-4">
        <form action="{{ route('planes.update', $plan) }}" method="POST">
            @csrf @method('PUT')
            @include('modules.planes.form')
            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Actualizar Plan
                </button>
                <a href="{{ route('planes.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
                <form action="{{ route('planes.destroy', $plan) }}"
                      method="POST"
                      class="ms-auto form-delete"
                      data-nombre="{{ $plan->nombre }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash me-1"></i>Eliminar plan
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
        const form   = this;
        const nombre = $(this).data('nombre');
        Swal.fire({
            title: '¿Eliminar plan?',
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
