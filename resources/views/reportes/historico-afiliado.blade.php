@extends('layouts.main')

@section('contenido')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>📊 Histórico de Pagos por Afiliado</h2>
            <p class="text-muted">Ver mes a mes cómo se pagó cada afiliado según el operador</p>
        </div>
    </div>

    <!-- Búsqueda de Afiliado con Autocomplete -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" id="formBusqueda" class="row g-3">
                <div class="col-md-10">
                    <label for="busqueda" class="form-label">🔍 Buscar Afiliado</label>
                    <div class="position-relative">
                        <input
                            type="text"
                            class="form-control form-control-lg"
                            id="busqueda"
                            name="busqueda"
                            placeholder="Escribe nombre, apellido o documento..."
                            value="{{ $afiliado ? trim($afiliado->primer_nombre . ' ' . $afiliado->segundo_nombre . ' ' . $afiliado->primer_apellido . ' ' . $afiliado->segundo_apellido) . ' (' . $afiliado->numero_documento . ')' : $busqueda }}"
                            autofocus
                            autocomplete="off"
                        >
                        <!-- Lista de resultados autocomplete -->
                        <div id="resultadosAutocomplete" class="list-group position-absolute w-100" style="top: 100%; z-index: 1000; display: none;">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100" id="btnBuscar">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                    @if($busqueda)
                    <a href="{{ route('reportes.historico-afiliado') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Histórico -->
    @if($afiliado && $historicoAfiliado)
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-person-fill"></i>
                    {{ $afiliado->primer_nombre }} {{ $afiliado->primer_apellido }}
                    <small>({{ $afiliado->numero_documento }})</small>
                </h5>
            </div>
        </div>

        @if($historicoAfiliado->count() > 0)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📊 Histórico de Exportaciones</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Período</th>
                            <th>Mes</th>
                            <th>Operador de Pago</th>
                            <th class="text-center">Cantidad de Recibos</th>
                            <th class="text-end">Total Pagado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historicoAfiliado as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->periodo }}</strong>
                                </td>
                                <td>
                                    @php
                                        $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                                                 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                    @endphp
                                    {{ $meses[$item->mes] }} de {{ $item->ano }}
                                </td>
                                <td>
                                    @if($item->operador === 'APORTES EN LÍNEA')
                                        <span class="badge bg-info">{{ $item->operador }}</span>
                                    @elseif($item->operador === 'PAGO SIMPLE')
                                        <span class="badge bg-success">{{ $item->operador }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->operador }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">{{ $item->cantidad_recibos }}</span>
                                </td>
                                <td class="text-end">
                                    <strong>${{ number_format($item->total_pagado, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3"><strong>TOTAL</strong></td>
                            <td class="text-center">
                                <strong>{{ $historicoAfiliado->sum('cantidad_recibos') }}</strong>
                            </td>
                            <td class="text-end">
                                <strong>${{ number_format($historicoAfiliado->sum('total_pagado'), 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @else
        <div class="alert alert-warning">
            <i class="bi bi-info-circle"></i> Este afiliado no tiene histórico de pagos exportados.
        </div>
        @endif
    @elseif($busqueda)
        <div class="alert alert-warning">
            <i class="bi bi-search"></i> No se encontró ningún afiliado con esos datos.
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-search"></i> Escribe el nombre, apellido o documento de un afiliado para ver su histórico de pagos.
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputBusqueda = document.getElementById('busqueda');
    const resultadosDiv = document.getElementById('resultadosAutocomplete');
    const formBusqueda = document.getElementById('formBusqueda');

    // Buscar afiliados mientras se escribe
    inputBusqueda.addEventListener('input', async function() {
        const valor = this.value.trim();

        if (valor.length < 2) {
            resultadosDiv.style.display = 'none';
            return;
        }

        try {
            const response = await fetch(`{{ route('reportes.api-buscar-afiliados') }}?q=${encodeURIComponent(valor)}`);
            const afiliados = await response.json();

            resultadosDiv.innerHTML = '';

            if (afiliados.length === 0) {
                resultadosDiv.innerHTML = '<div class="list-group-item text-muted">No se encontraron afiliados</div>';
                resultadosDiv.style.display = 'block';
                return;
            }

            afiliados.forEach(afl => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'list-group-item list-group-item-action';
                item.innerHTML = `
                    <div class="fw-bold">${afl.nombre_completo}</div>
                    <small class="text-muted">Documento: ${afl.documento}</small>
                `;
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    // Redirigir directamente con el ID del afiliado
                    window.location.href = `?afiliado_id=${afl.id}`;
                });
                resultadosDiv.appendChild(item);
            });

            resultadosDiv.style.display = 'block';
        } catch (error) {
            console.error('Error en búsqueda:', error);
        }
    });

    // Cerrar autocomplete al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (e.target !== inputBusqueda) {
            resultadosDiv.style.display = 'none';
        }
    });

    // Mostrar autocomplete al hacer focus
    inputBusqueda.addEventListener('focus', function() {
        if (this.value.length >= 2) {
            resultadosDiv.style.display = 'block';
        }
    });
});
</script>
@endsection('contenido')
