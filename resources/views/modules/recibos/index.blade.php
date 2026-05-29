@extends('layouts.main')

@section('titulo','Recibos')

@section('contenido')

<div class="container-fluid">

<div class="pagetitle">
    <h1>Recibos</h1>
</div>

<section class="section">

<div class="card">
<div class="card-body">

{{-- 🔔 MENSAJES --}}
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {!! session('error') !!}
</div>
@endif


{{-- 🔘 BOTONES --}}
<div class="mt-3 mb-3 d-flex gap-2 flex-wrap align-items-center">

    <a href="{{ route('recibos.create') }}" class="btn btn-primary">
        Crear Recibo
    </a>

    <a href="{{ route('recibos.sin_recibo') }}" class="btn btn-warning">
        Usuarios sin recibo
    </a>

    
    {{-- EXPORTAR --}}
<a href="{{ route('export.pila.excel') }}"
   class="btn btn-success {{ $pendientes == 0 ? 'disabled' : '' }}"
   {{ $pendientes == 0 ? 'onclick=return false;' : '' }}>
    
    Exportar PILA Excel
    <span class="badge bg-dark">{{ $pendientes }}</span>
</a>

    <a href="{{ route('export.index') }}" class="btn btn-info">
        Ver Lotes
    </a>

    {{-- CERRAR PERIODO --}}
    <form action="{{ route('recibos.cerrar_periodo') }}" method="POST">
@csrf
<button class="btn btn-danger">
    Cerrar periodo
</button>
</form>
    <a href="{{ route('recibos.activos') }}" class="btn btn-dark">
Activos siguiente periodo
</a>

<a href="{{ route('recibos.exportar.vigentes') }}" class="btn btn-success">
    Exportar afiliados vigentes
</a>

</div>


{{-- 📊 TABLA --}}
<table class="table table-striped align-middle">
<thead>
<tr>
    <th>#</th>
    <th>Fecha</th>
    <th>Afiliado</th>
    <th>IBC</th>
    <th>Total</th>
    <th>Novedad</th>
    <th width="160">Acciones</th>
</tr>
</thead>

<tbody>

@forelse($recibos as $r)
<tr>

<td>{{ $r->numero }}</td>

<td>{{ $r->fecha }}</td>

<td>
{{ $r->afiliado->primer_nombre }}
{{ $r->afiliado->primer_apellido }}
</td>

<td>${{ number_format($r->ibc,0) }}</td>

<td><strong>${{ number_format($r->total,0) }}</strong></td>

<td>
@if($r->novedad)
<span class="badge bg-warning">{{ $r->novedad }}</span>
@else
<span class="badge bg-success">Normal</span>
@endif
</td>

<td>

@if(!$r->export_batch_id)
<a href="{{ route('recibos.edit',$r) }}" class="btn btn-warning btn-sm">
Editar
</a>
@else
<button class="btn btn-secondary btn-sm" disabled>
Bloqueado
</button>
@endif

<form action="{{ route('recibos.destroy',$r) }}" method="POST" style="display:inline">
@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar recibo?')">
Eliminar
</button>
</form>

</td>

</tr>

@empty
<tr>
<td colspan="7" class="text-center">
    No hay recibos registrados
</td>
</tr>
@endforelse

</tbody>
</table>

{{-- 📄 PAGINACIÓN --}}
<div class="mt-3">
{{ $recibos->links() }}
</div>

</div>
</div>

</section>
</div>


@endsection