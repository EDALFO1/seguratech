@extends('layouts.main')

@section('titulo','Activos siguiente periodo')

@section('contenido')

<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Activos siguiente periodo</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('recibos.index') }}">Recibos</a></li>
                <li class="breadcrumb-item active">Activos siguiente periodo</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('recibos.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<section class="section mt-3">

{{-- ESTADÍSTICAS --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body">
                <h3 class="text-primary fw-bold mb-1">{{ $totalAfiliados }}</h3>
                <p class="text-muted small mb-0"><i class="bi bi-people-fill me-1"></i>Total de Afiliados</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body">
                <h3 class="text-success fw-bold mb-1">{{ $afiliadosNuevosCount }}</h3>
                <p class="text-muted small mb-0"><i class="bi bi-star-fill me-1"></i>Afiliados Nuevos</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body">
                <h3 class="text-info fw-bold mb-1">{{ $afiliadosContinuanCount }}</h3>
                <p class="text-muted small mb-0"><i class="bi bi-arrow-repeat me-1"></i>Que Continúan</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="alert alert-info d-flex gap-2">
            <span class="badge bg-primary text-white">CONTINÚA</span>
            Afiliados que vienen del período anterior
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert alert-success d-flex gap-2">
            <span class="badge bg-success text-white">NUEVO</span>
            Afiliados que ingresaron en este período
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Nombre</th>
                        <th>Documento</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($afiliados as $item)
                    <tr>
                        <td class="ps-3 fw-semibold">{{ $item['afiliado']->primer_nombre }} {{ $item['afiliado']->primer_apellido }}</td>
                        <td>{{ $item['afiliado']->numero_documento }}</td>
                        <td>
                            @if($item['es_nuevo'])
                                <span class="badge bg-success">
                                    <i class="bi bi-star-fill me-1"></i>NUEVO
                                </span>
                            @else
                                <span class="badge bg-primary">
                                    <i class="bi bi-arrow-repeat me-1"></i>CONTINÚA
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                            No hay afiliados activos sin recibo para el siguiente periodo.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</section>

@endsection
