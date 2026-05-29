@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
    <h1>Afiliados</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body">

{{-- 🔥 NUEVO HEADER DE ACCIONES --}}
<div class="card mb-3 shadow-sm border-0 mt-3">
    <div class="card-body p-3">

        <div class="row g-2 align-items-center">

            {{-- 🔵 IZQUIERDA --}}
            <div class="col-lg-5 d-flex flex-wrap gap-2">

                <a href="{{ route('afiliados.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                    <i class="bi bi-person-plus"></i>
                    Crear
                </a>

                <form action="{{ route('afiliados.importar') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                    @csrf

                    <input type="file" name="archivo" class="form-control form-control-sm" style="max-width: 180px;" required>

                    <button class="btn btn-success d-flex align-items-center gap-1">
                        <i class="bi bi-upload"></i>
                        Importar
                    </button>
                </form>

            </div>

            {{-- 🟡 CENTRO (FILTROS + EXPORTAR) --}}
            <div class="col-lg-4">
                <form method="GET" action="{{ route('export.afiliados.exportar') }}" class="d-flex gap-2">

                    

                    <select name="estado" class="form-select form-select-sm" style="max-width: 120px;">
                        <option value="">Todos</option>
                        <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Activos</option>
                        <option value="0" {{ request('estado') == '0' ? 'selected' : '' }}>Inactivos</option>
                    </select>

                    <button class="btn btn-success d-flex align-items-center gap-1">
                        <i class="bi bi-file-earmark-excel"></i>
                        Exportar
                    </button>

                </form>
            </div>

            {{-- 🟢 DERECHA --}}
            <div class="col-lg-3 d-flex justify-content-end gap-2">

                <a href="{{ route('afiliados.plantilla') }}" 
                   class="btn btn-outline-success d-flex align-items-center gap-1">
                    <i class="bi bi-download"></i>
                    Plantilla
                </a>

            </div>

        </div>

    </div>
</div>

{{-- 🔍 BUSCADOR EN TIEMPO REAL --}}
<div class="d-flex gap-2 mb-3">

    <input 
        type="text" 
        id="buscador"
        class="form-control"
        placeholder="🔍 Buscar afiliado..."
        onkeyup="buscarEnTiempoReal()"
    >

</div>

{{-- 🔥 MENSAJES --}}
<div class="d-flex flex-wrap gap-3 mb-3">

    @if(session('success'))
    <div class="alert alert-success p-2 px-3 mb-0">
        {{ session('success') }}
    </div>
    @endif

</div>

<div class="mb-2 text-muted">
    Mostrando {{ $afiliados->firstItem() }} a {{ $afiliados->lastItem() }} 
    de {{ $afiliados->total() }} registros
</div>

{{-- TABLA --}}
<table class="table table-striped">
<thead>
<tr>
    <th>Documento</th>
    <th>Nombre</th>
    <th>Teléfono</th>
    <th>Empresa Laboral</th>
    <th>Estado</th>
    <th width="150">Acciones</th>
</tr>
</thead>

<tbody id="tabla-afiliados">
@forelse($afiliados as $a)
<tr>
    <td>
        {{ $a->documento?->nombre ?? '' }}
        {{ $a->numero_documento }}
    </td>
    <td>
        {{ $a->primer_nombre }}
        {{ $a->segundo_nombre }}
        {{ $a->primer_apellido }}
        {{ $a->segundo_apellido }}
    </td>
    <td>{{ $a->telefono }}</td>
    <td>{{ $a->empresaLaboral?->nombre ?? '' }}</td>
    <td>
        @if($a->estado)
            <span class="badge bg-success">Activo</span>
        @else
            <span class="badge bg-danger">Inactivo</span>
        @endif
    </td>
    <td>
        <a href="{{ route('afiliados.edit',$a) }}" class="btn btn-warning btn-sm">
            Editar
        </a>

        <form action="{{ route('afiliados.destroy',$a) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar afiliado?')">
                Eliminar
            </button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">No hay afiliados registrados</td>
</tr>
@endforelse
</tbody>
</table>

<div class="mt-3">
    {{ $afiliados->links('pagination::bootstrap-5') }}
</div>

</div>
</div>
</div>
</div>

</section>

@endsection

{{-- 🔥 BUSCADOR --}}
<script>
let delayTimer;

function buscarEnTiempoReal() {

    clearTimeout(delayTimer);

    delayTimer = setTimeout(() => {

        let input = document.getElementById('buscador');
        let query = input.value.trim();

        if (query === '') {
            location.reload();
            return;
        }

        fetch("{{ route('afiliados.buscar') }}?buscar=" + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {

                let html = '';

                if (data.length === 0) {
                    html = `<tr>
                                <td colspan="6" class="text-center text-muted">
                                    Sin resultados
                                </td>
                            </tr>`;
                }

                data.forEach(a => {

                    html += `
                        <tr>
                            <td>${a.documento?.nombre ?? ''} ${a.numero_documento}</td>
                            <td>${a.primer_nombre} ${a.primer_apellido}</td>
                            <td>${a.telefono ?? ''}</td>
                            <td>${a.empresa_laboral?.nombre ?? ''}</td>
                            <td>
                                ${a.estado 
                                    ? '<span class="badge bg-success">Activo</span>' 
                                    : '<span class="badge bg-danger">Inactivo</span>'}
                            </td>
                            <td>
                                <a href="/afiliados/${a.id}/edit" class="btn btn-warning btn-sm">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    `;
                });

                document.getElementById('tabla-afiliados').innerHTML = html;

            });

    }, 400);
}
</script>