<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

{{-- ================= DASHBOARD ================= --}}
<li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
    </a>
</li>

{{-- ================= OPERATIVO (ADMIN + OPERARIO) ================= --}}
@if(in_array(auth()->user()->rol_id, [1,2]))

<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#operativo-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-briefcase"></i><span>Operativo</span>
    <i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="operativo-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

    <li>
      <a href="{{ route('remisiones.index') }}">
        <i class="bi bi-book"></i><span>Crear Remisiones</span>
      </a>
    </li>

    <li>
      <a href="{{ route('recibos.index') }}">
        <i class="bi bi-receipt"></i><span>Crear Recibos</span>
      </a>
    </li>

  </ul>
</li>


<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#administrativo-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-briefcase"></i><span>Administrativo</span>
    <i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="administrativo-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

    <li>
      <a href="{{ route('afiliados.index') }}">
        <i class="bi bi-person"></i><span>Afiliados</span>
      </a>
    </li>

    <li>
      <a href="{{ route('afiliaciones.index') }}">
        <i class="bi bi-person-check"></i><span>Afiliaciones</span>
      </a>
    </li>

    <li>
      <a href="{{ route('parametros_anuales.index') }}">
        <i class="bi bi-cash"></i><span>Valor Anual</span>
      </a>
    </li>

    <li>
      <a href="{{ route('empresas_laborales.index') }}">
        <i class="bi bi-building"></i><span>Empresa Laboral</span>
      </a>
    </li>

    <li>
      <a href="{{ route('asesores.index') }}">
        <i class="bi bi-people"></i><span>Asesores</span>
      </a>
    </li>

    <li>
      <a href="{{ route('servicios.index') }}">
        <i class="bi bi-gear"></i><span>Servicios</span>
      </a>
    </li>

    <li>
      <a href="{{ route('afiliado_servicios.index') }}">
        <i class="bi bi-diagram-3"></i><span>Afiliado Servicios</span>
      </a>
    </li>

  </ul>
</li>

@endif


{{-- ================= SOLO ADMIN ================= --}}
@if(auth()->user()->rol_id == 1)

{{-- EMPRESAS --}}
<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#empresas-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-building"></i><span>Empresas</span>
    <i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="empresas-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
    <li>
      <a href="{{ route('empresas.index') }}">
        <i class="bi bi-buildings"></i><span>Empresa</span>
      </a>
    </li>
  </ul>
</li>

{{-- LIBRERÍA --}}
<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#libreria-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-book"></i><span>Librería</span>
    <i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="libreria-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

    <li><a href="{{ route('arls.index') }}"><i class="bi bi-dot"></i><span>ARL</span></a></li>
    <li><a href="{{ route('eps.index') }}"><i class="bi bi-dot"></i><span>EPS</span></a></li>
    <li><a href="{{ route('pensions.index') }}"><i class="bi bi-dot"></i><span>Pensión</span></a></li>
    <li><a href="{{ route('cajas.index') }}"><i class="bi bi-dot"></i><span>Caja</span></a></li>
    <li><a href="{{ route('documentos.index') }}"><i class="bi bi-dot"></i><span>Documentos</span></a></li>
    <li><a href="{{ route('subtipo_cotizantes.index') }}"><i class="bi bi-dot"></i><span>Subtipos</span></a></li>

  </ul>
</li>

{{-- ADMINISTRACIÓN --}}
<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-people"></i><span>Administración</span>
    <i class="bi bi-chevron-down ms-auto"></i>
  </a>

  <ul id="admin-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

    <li>
      <a href="{{ route('usuarios.index') }}">
        <i class="bi bi-person"></i><span>Usuarios</span>
      </a>
    </li>

    <li>
      <a href="{{ route('roles.index') }}">
        <i class="bi bi-shield-lock"></i><span>Roles</span>
      </a>
    </li>

  </ul>
</li>

@endif

</ul>

</aside>