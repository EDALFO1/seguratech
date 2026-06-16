@php
use Illuminate\Support\Facades\Crypt;
@endphp

@extends('layouts.main')

@section('titulo', 'Claves por Empresa')

@section('contenido')

<style>

    /* CONTENEDOR GENERAL */
    .claves-wrapper{
    padding-right: 10px;
}

    /* CARD PRINCIPAL */
    .claves-card{
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(0,0,0,.05);
    }

    /* TITULO */
    .claves-title{
        font-size: 30px;
        font-weight: 700;
        color: #0b3b8c;
        margin-bottom: 10px;
    }

    /* SUBTITULO */
    .claves-subtitle{
        font-size: 26px;
        font-weight: 600;
        color: #0b3b8c;
    }

    /* TABLA */
    .table-claves thead th{
        background: #f8fafc;
        border-bottom: 2px solid #e5e7eb;
        color: #374151;
        font-weight: 700;
        font-size: 14px;
        padding: 14px;
        white-space: nowrap;
    }

    .table-claves tbody td{
        vertical-align: middle;
        padding: 14px;
        font-size: 14px;
    }

    .table-claves tbody tr:hover{
        background: #f8fbff;
    }

    /* BADGE SERVICIO */
    .servicio-badge{
        background: linear-gradient(90deg,#2563eb,#1d4ed8);
        color: white;
        padding: 7px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    /* PASSWORD */
    .password-box{
        max-width: 230px;
    }

    .password-field{
        border-radius: 8px 0 0 8px !important;
        border-right: 0;
        font-size: 13px;
        letter-spacing: 1px;
    }

    .toggle-password,
    .copy-password{
        border-radius: 0 !important;
    }

    /* BOTONES */
    .btn-action{
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    /* URL BUTTON */
    .btn-url{
        border-radius: 10px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 600;
    }

    /* ALERT */
    .alert-success{
        border-radius: 12px;
        border: 1px solid #b7e4c7;
        background: #e9f9ee;
        color: #1b4332;
    }

</style>

<div class="container-fluid-fluid claves-wrapper">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h1 class="claves-title mb-0">
                🔐 Claves por Empresa
            </h1>

            <a href="{{ route('empresa-claves.create') }}"
               class="btn btn-primary px-4 py-2 rounded-3">

                <i class="bi bi-plus-circle"></i>
                Nueva Clave

            </a>

        </div>

        <div class="card claves-card mt-0">    

            <div class="card-body p-3">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h4 class="claves-subtitle mb-0">
                        Centro de Accesos
                    </h4>

                </div>

                {{-- MENSAJES --}}
                @if(session('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>

                @endif

                {{-- TABLA --}}
                <div class="table-responsive">

                    <table class="table table-hover align-middle table-claves">

                        <thead>

                            <tr>

                                <th width="220">
                                    Servicio
                                </th>

                                <th width="180">
                                    Usuario
                                </th>

                                <th>
                                    Correo
                                </th>

                                <th width="280">
                                    Contraseña
                                </th>

                                <th width="120">
                                    URL
                                </th>

                                <th width="120">
                                    Acciones
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($claves as $clave)

                                <tr>

                                    {{-- SERVICIO --}}
                                    <td>

                                        <span class="servicio-badge">

                                            {{ $clave->servicio->nombre ?? '—' }}

                                        </span>

                                    </td>

                                    {{-- USUARIO --}}
                                    <td>

                                        <strong>

                                            {{ $clave->usuario ?? '—' }}

                                        </strong>

                                    </td>

                                    {{-- CORREO --}}
                                    <td>

                                        {{ $clave->correo_registrado ?? '—' }}

                                    </td>

                                    {{-- PASSWORD --}}
                                    <td>

                                        <div class="input-group input-group-sm password-box">

                                            <input type="password"
                                                   readonly
                                                   class="form-control password-field"
                                                   value="{{ $clave->password ? Crypt::decryptString($clave->password) : '' }}">

                                            <button type="button"
                                                    class="btn btn-outline-secondary toggle-password"
                                                    title="Mostrar contraseña">

                                                <i class="fa-solid fa-eye"></i>

                                            </button>

                                            <button type="button"
                                                    class="btn btn-outline-secondary copy-password"
                                                    title="Copiar contraseña">

                                                <i class="fa-solid fa-copy"></i>

                                            </button>

                                        </div>

                                    </td>

                                    {{-- URL --}}
                                    <td>

                                        @if(!empty($clave->servicio->url))

                                            <a href="{{ $clave->servicio->url }}"
                                               target="_blank"
                                               class="btn btn-outline-primary btn-sm btn-url">

                                                <i class="fa-solid fa-up-right-from-square"></i>

                                            </a>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>

                                    {{-- ACCIONES --}}
                                    <td>

                                        <div class="d-flex gap-2">

                                            {{-- EDITAR --}}
                                            <a href="{{ route('empresa-claves.edit', $clave) }}"
                                               class="btn btn-warning btn-sm btn-action">

                                                <i class="bi bi-pencil-square"></i>

                                            </a>

                                            {{-- ELIMINAR --}}
                                            <form action="{{ route('empresa-claves.destroy', $clave) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Eliminar clave?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm btn-action">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="text-center text-muted py-5">

                                        <i class="bi bi-shield-lock fs-1"></i>

                                        <br><br>

                                        No hay claves registradas.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINACIÓN --}}
                <div class="mt-4">

                    {{ $claves->links() }}

                </div>

            </div>

        </div>

    </div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function() {

    // MOSTRAR / OCULTAR PASSWORD
    document.querySelectorAll('.toggle-password').forEach(btn => {

        btn.addEventListener('click', function() {

            const input = this.closest('.input-group')
                              .querySelector('.password-field');

            const icon = this.querySelector('i');

            if(input.type === 'password') {

                input.type = 'text';

                input.classList.add('bg-success-subtle');

                icon.classList.replace('fa-eye', 'fa-eye-slash');

            } else {

                input.type = 'password';

                input.classList.remove('bg-success-subtle');

                icon.classList.replace('fa-eye-slash', 'fa-eye');

            }

        });

    });

    // COPIAR PASSWORD
    document.querySelectorAll('.copy-password').forEach(btn => {

        btn.addEventListener('click', async function() {

            const input = this.closest('.input-group')
                              .querySelector('.password-field');

            const icon = this.querySelector('i');

            try {

                await navigator.clipboard.writeText(input.value);

                icon.classList.replace('fa-copy', 'fa-check');

                this.classList.remove('btn-outline-secondary');

                this.classList.add('btn-outline-success');

                setTimeout(() => {

                    icon.classList.replace('fa-check', 'fa-copy');

                    this.classList.remove('btn-outline-success');

                    this.classList.add('btn-outline-secondary');

                }, 1200);

            } catch (error) {

                alert('No se pudo copiar.');

            }

        });

    });

});

</script>

@endpush

