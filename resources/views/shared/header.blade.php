<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">SeguraTech</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
     
      {{-- BOTÓN NOTAS --}}
      <li class="nav-item me-4">
        <a href="#" 
          class="btn d-flex align-items-center text-white px-3" 
          style="background: linear-gradient(90deg, #28a745, #5cd08d);">
          <i class="bi bi-stickies-fill me-2 fs-5"></i>
          <span>Notas</span>
        </a>
      </li>

      {{-- BOTÓN PLANES --}}
      <li class="nav-item me-4">
        <a href="#" 
          class="btn d-flex align-items-center text-white px-3" 
          style="background: linear-gradient(90deg, #0062E6, #33AEFF);">
          <i class="bi bi-layers-fill me-2 fs-5"></i>
          <span>Planes</span>
        </a>
      </li>

      {{-- BOTÓN CLAVES --}}
      <li class="nav-item me-4">
        <a href="{{ route('empresa-claves.index') }}"
          class="btn d-flex align-items-center text-white px-3" 
          style="background: linear-gradient(90deg, #ff7e5f, #feb47b);">
          <i class="bi bi-key me-2 fs-5"></i>
          <span>Claves por Empresa</span>
        </a>
      </li>


      {{-- Empresa Activa --}}
      @php
    $empresaActiva = auth()->user()->empresas
        ->where('id', session('empresa_id'))
        ->first();
@endphp

@if($empresaActiva)
<div class="d-flex align-items-center gap-2 me-3">

    <span class="badge bg-success text-truncate" style="max-width: 180px;">
        <i class="bi bi-building"></i>
        {{ $empresaActiva->nombre }}
    </span>

    <a href="{{ route('seleccionar.empresa') }}" 
       class="btn btn-sm btn-warning">
        Cambiar
    </a>

</div>
@endif

      {{-- PERFIL DEL USUARIO --}}
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <span class="d-none d-md-block dropdown-toggle ps-2">
            {{ Auth::check() ? Auth::user()->name : 'Invitado' }}
          </span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</h6>
          </li>

          <li><hr class="dropdown-divider"></li>

          @if(Auth::check())
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Salir</span>
              </a>
            </li>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          @endif

        </ul>
      </li>

    </ul>
  </nav>

</header>