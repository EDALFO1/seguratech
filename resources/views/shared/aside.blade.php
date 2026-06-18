<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">Principal</li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
           href="{{ route('dashboard') }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-heading">Operativo</li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('remisiones.*','recibos.*') ? '' : 'collapsed' }}"
           data-bs-target="#nav-facturacion"
           data-bs-toggle="collapse"
           href="#">
            <i class="bi bi-receipt"></i>
            <span>Facturación</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nav-facturacion"
            class="nav-content collapse {{ request()->routeIs('remisiones.*','recibos.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('remisiones.index') }}"
                   class="{{ request()->routeIs('remisiones.*') ? 'active' : '' }}">
                    <span>Crear Remisiones</span>
                </a>
            </li>
            @if($modulosPermitidos->contains('recibos'))
            <li>
                <a href="{{ route('recibos.index') }}"
                   class="{{ request()->routeIs('recibos.*') ? 'active' : '' }}">
                    <span>Crear Recibos</span>
                </a>
            </li>
            @endif
        </ul>
    </li>

    <li class="nav-heading">Gestión</li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('afiliados.*','afiliaciones.*','afiliado_servicios.*') ? '' : 'collapsed' }}"
           data-bs-target="#nav-afiliados"
           data-bs-toggle="collapse"
           href="#">
            <i class="bi bi-people-fill"></i>
            <span>Afiliados</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nav-afiliados"
            class="nav-content collapse {{ request()->routeIs('afiliados.*','afiliaciones.*','afiliado_servicios.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('afiliados.index') }}"
                   class="{{ request()->routeIs('afiliados.*') ? 'active' : '' }}">
                    <span>Afiliados</span>
                </a>
            </li>
            <li>
                <a href="{{ route('afiliaciones.index') }}"
                   class="{{ request()->routeIs('afiliaciones.*') ? 'active' : '' }}">
                    <span>Afiliaciones</span>
                </a>
            </li>
            <li>
                <a href="{{ route('afiliado_servicios.index') }}"
                   class="{{ request()->routeIs('afiliado_servicios.*') ? 'active' : '' }}">
                    <span>Servicios por Afiliado</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('empresas_laborales.*','asesores.*','servicios.*') ? '' : 'collapsed' }}"
           data-bs-target="#nav-empresas"
           data-bs-toggle="collapse"
           href="#">
            <i class="bi bi-building-fill"></i>
            <span>Empresas Laborales</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nav-empresas"
            class="nav-content collapse {{ request()->routeIs('empresas_laborales.*','asesores.*','servicios.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{ route('empresas_laborales.index') }}"
                   class="{{ request()->routeIs('empresas_laborales.*') ? 'active' : '' }}">
                    <span>Empresas Laborales</span>
                </a>
            </li>
            @if($modulosPermitidos->contains('asesores'))
            <li>
                <a href="{{ route('asesores.index') }}"
                   class="{{ request()->routeIs('asesores.*') ? 'active' : '' }}">
                    <span>Asesores</span>
                </a>
            </li>
            <li>
                <a href="{{ route('servicios.index') }}"
                   class="{{ request()->routeIs('servicios.*') ? 'active' : '' }}">
                    <span>Servicios</span>
                </a>
            </li>
            @endif
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('incapacidades.*') ? '' : 'collapsed' }}"
           href="{{ route('incapacidades.index') }}">
            <i class="bi bi-file-medical-fill"></i>
            <span>Incapacidades</span>
        </a>
    </li>

    @if($modulosPermitidos->contains('servicios_externos'))
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('servicios-externos.*') ? '' : 'collapsed' }}"
           href="{{ route('servicios-externos.index') }}">
            <i class="bi bi-globe2"></i>
            <span>Servicios Externos</span>
        </a>
    </li>
    @endif

    @if($modulosPermitidos->contains('arls') || $modulosPermitidos->contains('usuarios'))
    <li class="nav-divider"></li>
    <li class="nav-heading">Configuración</li>
    @endif

    @if($modulosPermitidos->contains('arls'))
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('arls.*','eps.*','pensions.*','cajas.*','documentos.*','subtipo_cotizantes.*','parametros_anuales.*') ? '' : 'collapsed' }}"
           data-bs-target="#nav-libreria"
           data-bs-toggle="collapse"
           href="#">
            <i class="bi bi-collection-fill"></i>
            <span>Librería</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nav-libreria"
            class="nav-content collapse {{ request()->routeIs('arls.*','eps.*','pensions.*','cajas.*','documentos.*','subtipo_cotizantes.*','parametros_anuales.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
            <li><a href="{{ route('arls.index') }}"               class="{{ request()->routeIs('arls.*') ? 'active' : '' }}"><span>ARL</span></a></li>
            <li><a href="{{ route('eps.index') }}"                class="{{ request()->routeIs('eps.*') ? 'active' : '' }}"><span>EPS</span></a></li>
            <li><a href="{{ route('pensions.index') }}"           class="{{ request()->routeIs('pensions.*') ? 'active' : '' }}"><span>Pensión</span></a></li>
            <li><a href="{{ route('cajas.index') }}"              class="{{ request()->routeIs('cajas.*') ? 'active' : '' }}"><span>Caja</span></a></li>
            <li><a href="{{ route('documentos.index') }}"         class="{{ request()->routeIs('documentos.*') ? 'active' : '' }}"><span>Documentos</span></a></li>
            <li><a href="{{ route('subtipo_cotizantes.index') }}" class="{{ request()->routeIs('subtipo_cotizantes.*') ? 'active' : '' }}"><span>Subtipos</span></a></li>
            <li><a href="{{ route('parametros_anuales.index') }}" class="{{ request()->routeIs('parametros_anuales.*') ? 'active' : '' }}"><span>Valor Anual</span></a></li>
        </ul>
    </li>
    @endif

    @if($modulosPermitidos->contains('usuarios'))
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('empresas.*','usuarios.*','roles.*','modulos-empresa.*','modulos-rol.*') ? '' : 'collapsed' }}"
           data-bs-target="#nav-sistema"
           data-bs-toggle="collapse"
           href="#">
            <i class="bi bi-shield-lock-fill"></i>
            <span>Sistema</span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="nav-sistema"
            class="nav-content collapse {{ request()->routeIs('empresas.*','usuarios.*','roles.*','modulos-empresa.*','modulos-rol.*') ? 'show' : '' }}"
            data-bs-parent="#sidebar-nav">
            @if($modulosPermitidos->contains('empresas'))
            <li><a href="{{ route('empresas.index') }}" class="{{ request()->routeIs('empresas.*') ? 'active' : '' }}"><span>Empresas</span></a></li>
            @endif
            <li><a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}"><span>Usuarios</span></a></li>
            <li><a href="{{ route('roles.index') }}"    class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"><span>Roles</span></a></li>
            @if($modulosPermitidos->contains('modulos_empresa'))
            <li><a href="{{ route('modulos-empresa.index') }}" class="{{ request()->routeIs('modulos-empresa.*') ? 'active' : '' }}"><span>Módulos por Empresa</span></a></li>
            @endif
            @if($modulosPermitidos->contains('modulos_rol'))
            <li><a href="{{ route('modulos-rol.index') }}" class="{{ request()->routeIs('modulos-rol.*') ? 'active' : '' }}"><span>Módulos por Rol</span></a></li>
            @endif
        </ul>
    </li>
    @endif

</ul>

</aside>
