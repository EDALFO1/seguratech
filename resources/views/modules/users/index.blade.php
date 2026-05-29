@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
    <h1>Usuarios</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card border-0">
<div class="card-body">

<div class="mt-3 mb-3">
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
        Crear Usuario
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<table class="table table-striped">

<thead>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Empresa</th>
    <th>Rol</th>
    <th>Estado</th>
    <th width="150">Acciones</th>
</tr>
</thead>

<tbody>

@foreach($users as $user)

<tr>

    <td>{{ $user->id }}</td>

    <td>{{ $user->name }}</td>

    <td>{{ $user->email }}</td>

    <td>
        {{ $user->empresas->first()?->nombre ?? 'Sin empresa' }}
    </td>

    <td>{{ $user->rol->nombre ?? '' }}</td>

    <td>
        @if($user->estado)
            <span class="badge bg-success">Activo</span>
        @else
            <span class="badge bg-danger">Inactivo</span>
        @endif
    </td>

    <td>

        <a href="{{ route('usuarios.edit',$user) }}"
        class="btn btn-warning btn-sm">
            Editar
        </a>

        <form action="{{ route('usuarios.destroy',$user) }}"
        method="POST"
        style="display:inline">

            @csrf
            @method('DELETE')

            <button
            onclick="return confirm('¿Eliminar usuario?')"
            class="btn btn-danger btn-sm">
                Eliminar
            </button>

        </form>

    </td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>

</div>
</div>

</section>

@endsection