@extends('layouts.main')
@section('titulo', $titulo)
@section('contenido')

<div class="pagetitle d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h1 class="mb-0"><i class="bi bi-person-check me-2"></i>Afiliaciones</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Afiliaciones</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('afiliaciones.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nuevo
    </a>
</div>

<section class="section mt-3">

@if($afiliados->isEmpty())
<div class="alert alert-warning d-flex align-items-center justify-content-between flex-wrap gap-2">
    <span><i class="bi bi-exclamation-triangle me-2"></i>No hay afiliados registrados.</span>
    <a href="{{ route('afiliados.create') }}" class="btn btn-sm btn-primary">Crear Afiliado</a>
</div>
@endif

{{-- FILTROS --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('afiliaciones.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar afiliado o documento" value="{{ request('buscar') }}">
            </div>
            <div class="col-md-7 d-flex gap-2">
                <button class="btn btn-primary"><i class="bi bi-search me-1"></i>Buscar</button>
                <a href="{{ route('afiliaciones.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="px-3 pt-3 text-muted small">
            Total afiliaciones: {{ $afiliaciones->total() }}
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Doc.</th>
                        <th>Afiliado</th>
                        <th>EPS</th>
                        <th>ARL</th>
                        <th>Pensión</th>
                        <th>Caja</th>
                        <th>Fecha Afiliación</th>
                        <th>Estado</th>
                        <th class="text-center" style="width:120px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($afiliaciones as $a)
                    <tr>
                        <td class="ps-3">{{ optional($a->afiliado)->numero_documento ?? 'N/A' }}</td>
                        <td>{{ optional($a->afiliado)->primer_nombre ?? 'Sin afiliado' }} {{ optional($a->afiliado)->primer_apellido ?? '' }}</td>
                        <td>{{ optional($a->eps)->nombre ?? '-' }}</td>
                        <td>{{ $a->nivel_arl ? 'N'.$a->nivel_arl : '' }}</td>
                        <td>{{ optional($a->pension)->nombre ?? '-' }}</td>
                        <td>{{ optional($a->caja)->nombre ?? '-' }}</td>
                        <td>{{ $a->fecha_afiliacion }}</td>
                        <td>
                            @if($a->estado)
                            <span class="badge bg-success">Activo</span>
                            @else
                            <span class="badge bg-danger">Retirado</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('afiliaciones.edit', $a) }}" class="btn btn-outline-warning btn-sm" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('afiliaciones.destroy', $a) }}" method="POST" class="d-inline form-delete" data-nombre="{{ optional($a->afiliado)->primer_nombre }} {{ optional($a->afiliado)->primer_apellido }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                            No hay afiliaciones registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $afiliaciones->links() }}
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
        const nombre = ($(this).data('nombre') || '').toString().trim() || 'esta afiliación';
        Swal.fire({
            title: '¿Eliminar afiliación?',
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
