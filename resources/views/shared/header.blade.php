<header id="header" class="header fixed-top d-flex align-items-center gap-3">

    @php
        $hayEmpresa    = session()->has('empresa_id');
        $rolActual     = (int) auth()->user()->rol_id;
        $iniciales     = strtoupper(substr(auth()->user()->name, 0, 2));
        $empresaActiva = auth()->user()->empresas->where('id', session('empresa_id'))->first();
        $rolNombre     = match($rolActual) { 1 => 'Admin', 3 => 'Asesor', 4 => 'Invitado', 5 => 'Operador', default => 'Usuario' };
        $notasPend     = $hayEmpresa
            ? \App\Models\Nota::whereIn('estado', ['pendiente','en_proceso'])->count()
            : 0;
    @endphp

    {{-- LOGO + TOGGLE --}}
    <div class="d-flex align-items-center flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="logo">
            <div class="logo-icon">ST</div>
            <div>
                <div class="logo-text">SeguraTech</div>
                <div class="logo-sub"></div>
            </div>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    {{-- EMPRESA ACTIVA CENTRADA --}}
    @if($empresaActiva)
    <div class="d-none d-lg-flex align-items-center justify-content-center gap-2 flex-grow-1">
        <span class="st-empresa-chip">
            <i class="bi bi-building-fill"></i>
            {{ $empresaActiva->nombre }}
        </span>
        <a href="{{ route('seleccionar.empresa') }}" class="st-cambiar">
            <i class="bi bi-arrow-left-right me-1"></i>Cambiar
        </a>
    </div>
    @endif

    {{-- ACCIONES + PERFIL --}}
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center gap-2 mb-0 list-unstyled flex-wrap">

            {{-- NOTAS --}}
            @if($modulosPermitidos->contains('notas'))
            <li>
                <a href="{{ $hayEmpresa ? route('notas.index') : '#' }}"
                   class="st-pill notas {{ !$hayEmpresa ? 'disabled' : '' }}"
                   @if(!$hayEmpresa) title="Selecciona una empresa primero" @endif>
                    <i class="bi bi-stickies-fill"></i>
                    <span class="d-none d-md-inline">Notas</span>
                    @if($notasPend > 0)
                        <span class="badge-count">{{ $notasPend > 99 ? '99+' : $notasPend }}</span>
                    @endif
                </a>
            </li>
            @endif

            {{-- PLANES --}}
            @if($modulosPermitidos->contains('planes'))
            <li>
                <a href="{{ $hayEmpresa ? route('planes.index') : '#' }}"
                   class="st-pill planes {{ !$hayEmpresa ? 'disabled' : '' }}"
                   @if(!$hayEmpresa) title="Selecciona una empresa primero" @endif>
                    <i class="bi bi-layers-fill"></i>
                    <span class="d-none d-md-inline">Planes</span>
                </a>
            </li>
            @endif

            {{-- CLAVES --}}
            @if($modulosPermitidos->contains('empresa_claves'))
            <li>
                <a href="{{ route('empresa-claves.index') }}" class="st-pill claves">
                    <i class="bi bi-key-fill"></i>
                    <span class="d-none d-lg-inline">Claves</span>
                </a>
            </li>
            @endif

            {{-- SIMULADOR SS --}}
            <li>
                <button type="button" class="st-pill simulador" data-bs-toggle="modal" data-bs-target="#simuladorSSModal" title="Simulador de Seguridad Social">
                    <i class="bi bi-calculator-fill"></i>
                    <span class="d-none d-lg-inline">Simulador</span>
                </button>
            </li>

            {{-- SEPARADOR --}}
            <li class="d-none d-lg-flex"><div class="st-sep mx-1"></div></li>

            {{-- TOGGLE DARK MODE --}}
            <li>
                <button id="theme-toggle" class="st-pill theme-toggle" title="Cambiar tema">
                    <i class="bi bi-moon-fill"></i>
                </button>
            </li>

            {{-- SEPARADOR --}}
            <li class="d-none d-lg-flex"><div class="st-sep mx-1"></div></li>

            {{-- PERFIL --}}
            <li class="nav-item dropdown">
                <a href="#"
                   data-bs-toggle="dropdown"
                   class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="st-avatar">{{ $iniciales }}</div>
                    <div class="st-user-info d-none d-lg-block">
                        <div class="uname">{{ auth()->user()->name }}</div>
                        <div class="urole">{{ $rolNombre }}</div>
                    </div>
                    <i class="bi bi-chevron-down st-chevron d-none d-lg-inline"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-end st-profile mt-2">
                    <li class="dh">
                        <div class="dh-name">{{ auth()->user()->name }}</div>
                        <div class="dh-email">{{ auth()->user()->email }}</div>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>

                    @if($empresaActiva)
                    <li>
                        <a class="dropdown-item" href="{{ route('seleccionar.empresa') }}">
                            <i class="bi bi-arrow-left-right text-warning"></i>
                            Cambiar empresa
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    @endif

                    <li>
                        <a class="dropdown-item text-danger" href="#"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            Cerrar sesión
                        </a>
                    </li>
                </ul>

                <form id="logout-form"
                      action="{{ route('logout') }}"
                      method="POST"
                      class="d-none">
                    @csrf
                </form>
            </li>

        </ul>
    </nav>

</header>

{{-- MODAL SIMULADOR SS --}}
<div class="modal fade" id="simuladorSSModal" tabindex="-1" aria-labelledby="simuladorSSLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="simuladorSSLabel">
                    <i class="bi bi-calculator-fill me-2"></i>Simulador de Seguridad Social
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Valor Base (IBC)</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">$</span>
                            <input type="number" id="valorIBC" class="form-control" placeholder="Ingresa un valor superior al salario mínimo" min="0" step="1">
                        </div>
                        <small class="text-muted d-block mt-1">Valor mínimo requerido: Salario Mínimo Legal Vigente</small>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Selecciona los conceptos a liquidar:</label>

                        {{-- EPS (Valor fijo) --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkEps" onchange="calcularTotal()">
                                <label class="form-check-label" for="chkEps">
                                    EPS <span class="badge bg-info ms-2" id="badgeEps"></span>
                                </label>
                            </div>
                        </div>

                        {{-- ARL (Solo nivel) --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkArl" onchange="calcularTotal()">
                                <label class="form-check-label" for="chkArl">
                                    ARL
                                </label>
                            </div>
                            <div class="ms-4">
                                <select id="selectNivelArl" class="form-select form-select-sm" disabled onchange="calcularTotal()">
                                    <option value="">Selecciona Nivel</option>
                                    <option value="1">Nivel 1</option>
                                    <option value="2">Nivel 2</option>
                                    <option value="3">Nivel 3</option>
                                    <option value="4">Nivel 4</option>
                                    <option value="5">Nivel 5</option>
                                </select>
                            </div>
                            <div class="ms-4 mt-1 small text-muted" id="porcentajeArl"></div>
                        </div>

                        {{-- PENSIÓN (Valor fijo) --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkPension" onchange="calcularTotal()">
                                <label class="form-check-label" for="chkPension">
                                    Pensión <span class="badge bg-info ms-2" id="badgePension"></span>
                                </label>
                            </div>
                        </div>

                        {{-- CAJA (Valor fijo) --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkCaja" onchange="calcularTotal()">
                                <label class="form-check-label" for="chkCaja">
                                    Caja de Compensación <span class="badge bg-info ms-2" id="badgeCaja"></span>
                                </label>
                            </div>
                        </div>

                        {{-- ADMINISTRACIÓN --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chkAdmin" onchange="calcularTotal()">
                                <label class="form-check-label" for="chkAdmin">
                                    Administración <span class="badge bg-info ms-2" id="badgeAdmin"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="small text-muted">Total a pagar:</div>
                                        <div class="h4 text-primary fw-bold" id="totalPagar">$0</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="small text-muted">Porcentaje total:</div>
                                        <div class="h4 text-success fw-bold" id="porcentajeTotal">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let conceptosData = {};
let epsValor = null;
let pensionValor = null;
let cajaValor = null;
let arlPorNivel = {};

// Cargar datos del simulador
async function cargarConceptosSS() {
    try {
        const response = await axios.get("{{ route('recibos.conceptos-ss') }}");
        conceptosData = response.data;

        // Valores fijos (usar el primero de cada lista)
        epsValor = conceptosData.eps[0];
        pensionValor = conceptosData.pensions[0];
        cajaValor = conceptosData.cajas[0];

        // Mostrar valores fijos en badges
        document.getElementById('badgeEps').textContent = `${epsValor.porcentaje}%`;
        document.getElementById('badgePension').textContent = `${pensionValor.porcentaje}%`;
        document.getElementById('badgeCaja').textContent = `${cajaValor.porcentaje}%`;
        document.getElementById('badgeAdmin').textContent = `${conceptosData.administracion}%`;

        // Crear mapa de porcentajes por nivel de ARL (promedio)
        for (let nivel = 1; nivel <= 5; nivel++) {
            const arlDelNivel = conceptosData.arls.filter(a => a.nivel === nivel);
            if (arlDelNivel.length > 0) {
                const promedio = arlDelNivel.reduce((sum, a) => sum + parseFloat(a.porcentaje), 0) / arlDelNivel.length;
                arlPorNivel[nivel] = promedio;
            }
        }

    } catch (error) {
        console.error('Error cargando conceptos:', error);
    }
}

// Habilitar/deshabilitar selector de ARL
document.getElementById('chkArl').addEventListener('change', function() {
    document.getElementById('selectNivelArl').disabled = !this.checked;
    if (!this.checked) {
        document.getElementById('selectNivelArl').value = '';
    }
    calcularTotal();
});

// Calcular total
function calcularTotal() {
    const valorIBC = parseFloat(document.getElementById('valorIBC').value) || 0;
    let totalPago = 0;
    let totalPorcentaje = 0;
    let detalles = [];

    // EPS (valor fijo)
    if (document.getElementById('chkEps').checked && epsValor) {
        const aporte = valorIBC * (epsValor.porcentaje / 100);
        totalPago += aporte;
        totalPorcentaje += parseFloat(epsValor.porcentaje);
        detalles.push(`EPS: ${epsValor.porcentaje}%`);
    }

    // ARL (solo nivel)
    if (document.getElementById('chkArl').checked && document.getElementById('selectNivelArl').value) {
        const nivel = parseInt(document.getElementById('selectNivelArl').value);
        const porcentaje = arlPorNivel[nivel];
        if (porcentaje !== undefined) {
            const aporte = valorIBC * (porcentaje / 100);
            totalPago += aporte;
            totalPorcentaje += porcentaje;
            document.getElementById('porcentajeArl').textContent = `Nivel ${nivel}: ${porcentaje.toFixed(4)}%`;
            detalles.push(`Nivel ${nivel}: ${porcentaje.toFixed(4)}%`);
        }
    } else {
        document.getElementById('porcentajeArl').textContent = '';
    }

    // Pensión (valor fijo)
    if (document.getElementById('chkPension').checked && pensionValor) {
        const aporte = valorIBC * (pensionValor.porcentaje / 100);
        totalPago += aporte;
        totalPorcentaje += parseFloat(pensionValor.porcentaje);
        detalles.push(`Pensión: ${pensionValor.porcentaje}%`);
    }

    // Caja (valor fijo)
    if (document.getElementById('chkCaja').checked && cajaValor) {
        const aporte = valorIBC * (cajaValor.porcentaje / 100);
        totalPago += aporte;
        totalPorcentaje += parseFloat(cajaValor.porcentaje);
        detalles.push(`Caja: ${cajaValor.porcentaje}%`);
    }

    // Administración
    if (document.getElementById('chkAdmin').checked) {
        const aporte = valorIBC * (conceptosData.administracion / 100);
        totalPago += aporte;
        totalPorcentaje += parseFloat(conceptosData.administracion);
        detalles.push(`Administración: ${conceptosData.administracion}%`);
    }

    // Actualizar totales
    document.getElementById('totalPagar').textContent = `$${totalPago.toLocaleString('es-CO', {maximumFractionDigits: 0})}`;
    document.getElementById('porcentajeTotal').textContent = `${totalPorcentaje.toFixed(4)}%`;
}

// Recargar cuando cambia el valor del IBC
document.getElementById('valorIBC').addEventListener('input', calcularTotal);

// Recargar cuando cambia el nivel de ARL
document.getElementById('selectNivelArl').addEventListener('change', calcularTotal);

// Cargar datos cuando se abre el modal
document.getElementById('simuladorSSModal').addEventListener('show.bs.modal', cargarConceptosSS);
</script>
@endpush
