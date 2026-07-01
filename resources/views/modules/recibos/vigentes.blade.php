@extends('layouts.main')

@section('titulo','Afiliados Vigentes')

@section('contenido')

<div class="pagetitle d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h1 class="mb-0"><i class="bi bi-people-fill me-2"></i>Afiliados Vigentes - Período Actual</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('recibos.index') }}">Recibos</a></li>
                <li class="breadcrumb-item active">Afiliados Vigentes</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('recibos.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<section class="section mt-3">

{{-- FILTROS --}}
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" id="buscador" class="form-control" placeholder="Buscar por documento, nombre, teléfono..." onkeyup="filtrarTabla()">
                </div>
            </div>
            <div class="col-md-4">
                <select id="filtroEstadoPago" class="form-select" onchange="filtrarTabla()">
                    <option value="">Todos los estados</option>
                    <option value="pagado">Pagados</option>
                    <option value="pendiente">Pendientes</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- TABLA --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="px-3 pt-3 text-muted small">
            Mostrando {{ $afiliados->firstItem() }} a {{ $afiliados->lastItem() }} de {{ $afiliados->total() }} registros
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tablaDatos">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Documento</th>
                        <th>Nombre Completo</th>
                        <th>Teléfono</th>
                        <th class="text-end">Valor</th>
                        <th>Subtipo Cotizante</th>
                        <th>EPS</th>
                        <th>Nivel ARL</th>
                        <th>Pensión</th>
                        <th>Caja</th>
                        <th>Empresa Laboral</th>
                        <th class="text-center">Estado de Pago</th>
                        <th class="text-center" style="width:120px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($afiliados as $item)
                    <tr>
                        <td class="ps-3 fw-semibold">{{ $item['numero_documento'] }}</td>
                        <td>{{ $item['nombre_completo'] }}</td>
                        <td>{{ $item['telefono'] }}</td>
                        <td class="text-end">
                            <span class="fw-bold text-primary">
                                ${{ number_format($item['valor'], 0, ',', '.') }}
                            </span>
                        </td>
                        <td>{{ $item['subtipo_cotizante'] }}</td>
                        <td>{{ $item['eps'] }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $item['nivel_arl'] }}</span></td>
                        <td>{{ $item['pension'] }}</td>
                        <td>{{ $item['caja'] }}</td>
                        <td>{{ $item['empresa_laboral'] }}</td>
                        <td class="text-center">
                            @if($item['pagado'])
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>PAGADO
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-clock me-1"></i>PENDIENTE
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(!$item['pagado'])
                                <a href="{{ route('recibos.create') }}?afiliado_id={{ $item['id'] }}" class="btn btn-success btn-sm" title="Crear Recibo">
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                            No hay afiliados vigentes para el período actual.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $afiliados->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

</section>

@endsection

@push('scripts')
<script>
function filtrarTabla() {
    const inputBuscador = document.getElementById('buscador');
    const filtroBuscador = inputBuscador.value.toLowerCase();
    const filtroEstadoPago = document.getElementById('filtroEstadoPago').value.toLowerCase();
    const tabla = document.getElementById('tablaDatos');
    const filas = tabla.getElementsByTagName('tr');

    for (let i = 1; i < filas.length; i++) {
        const fila = filas[i];
        const celdas = fila.getElementsByTagName('td');
        let coincideBuscador = false;
        let coincideEstadoPago = true;

        // Buscar en documento, nombre y teléfono
        const documento = celdas[0]?.textContent?.toLowerCase() || '';
        const nombre = celdas[1]?.textContent?.toLowerCase() || '';
        const telefono = celdas[2]?.textContent?.toLowerCase() || '';

        if (documento.includes(filtroBuscador) || nombre.includes(filtroBuscador) || telefono.includes(filtroBuscador)) {
            coincideBuscador = true;
        }

        // Filtrar por estado de pago
        if (filtroEstadoPago) {
            const estadoPago = celdas[10]?.textContent?.toLowerCase() || '';
            if (filtroEstadoPago === 'pagado') {
                coincideEstadoPago = estadoPago.includes('pagado');
            } else if (filtroEstadoPago === 'pendiente') {
                coincideEstadoPago = estadoPago.includes('pendiente');
            }
        }

        fila.style.display = (coincideBuscador && coincideEstadoPago) ? '' : 'none';
    }
}
</script>
@endpush
