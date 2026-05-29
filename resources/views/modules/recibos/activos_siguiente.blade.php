@extends('layouts.main')

@section('contenido')

<h3>Afiliados activos sin recibo siguiente periodo</h3>

<table class="table">
    <tr>
        <th>Nombre</th>
        <th>Documento</th>
    </tr>

    @foreach($afiliados as $a)
    <tr>
        <td>{{ $a->primer_nombre }} {{ $a->primer_apellido }}</td>
        <td>{{ $a->numero_documento }}</td>
    </tr>
    @endforeach

</table>

@endsection