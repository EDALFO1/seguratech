@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Editar Remisión</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('remisiones.update',$remision->id) }}" method="POST">
@csrf
@method('PUT')

<div class="row">

{{-- EMPRESA --}}
<div class="col-md-4 mb-3">
<label>Empresa</label>
<input type="text" class="form-control bg-light"
value="{{ session('empresa_nombre') }}" readonly>
</div>

{{-- NIT --}}
<div class="col-md-4 mb-3">
<label>NIT</label>
<input type="text" class="form-control bg-light"
value="{{ session('empresa_nit') }}" readonly>
</div>

{{-- FECHA --}}
<div class="col-md-4 mb-3">
<label>Fecha</label>
<input type="date" name="fecha" id="fecha"
class="form-control"
value="{{ $remision->fecha }}">
</div>

{{-- PERIODO --}}
<div class="col-md-4 mb-3">
<label>Periodo</label>
<input type="text" id="periodo" class="form-control" readonly>
</div>

{{-- AFILIADO --}}
<div class="col-md-6 mb-3">
<label>Afiliado</label>
<input type="text" class="form-control"
value="{{ $remision->afiliado->primer_nombre }} {{ $remision->afiliado->primer_apellido }} - {{ $remision->afiliado->numero_documento }}"
readonly>
</div>

{{-- FECHA AFILIACION --}}
<div class="col-md-3 mb-3">
<label>Fecha afiliación</label>
<input type="text" id="fecha_afiliacion"
class="form-control"
value="{{ $remision->afiliado->afiliacion->fecha_afiliacion ?? '' }}"
readonly>
</div>

{{-- DIAS --}}
<div class="col-md-3 mb-3">
<label>Días</label>
<input type="number" id="dias_liquidar"
class="form-control"
value="{{ $remision->dias_liquidar }}"
readonly>
</div>

{{-- TOTAL --}}
<div class="col-md-3 mb-3">
<label>Total</label>
<input type="number" id="total" name="total"
class="form-control"
value="{{ $remision->total }}">
</div>

{{-- MENSAJERIA --}}
<div class="col-md-3 mb-3">
<label>Mensajería</label>
<input type="number" id="mensajeria" name="mensajeria"
class="form-control"
value="{{ $remision->mensajeria }}">
</div>

{{-- INTERESES --}}
<div class="col-md-3 mb-3">
<label>Intereses</label>
<input type="number" id="intereses" name="intereses"
class="form-control"
value="{{ $remision->intereses }}">
</div>

{{-- CARGOS --}}
<div class="col-12 mt-3">
<label><strong>Cargos adicionales</strong></label>

<div id="contenedor_cargos"></div>

<button type="button" class="btn btn-success btn-sm"
onclick="agregarCargo()">
+ Agregar cargo
</button>
</div>

</div>

<button class="btn btn-primary mt-3">Actualizar</button>
<a href="{{ route('remisiones.index') }}" class="btn btn-secondary mt-3">Cancelar</a>

</form>

</div>
</div>

{{-- DETALLE --}}
<div class="card mt-4">
<div class="card-body">

<h5>Detalle de Remisión</h5>

<table class="table table-bordered">
<thead>
<tr>
<th>Concepto</th>
<th>Valor</th>
</tr>
</thead>

<tbody id="detalle_remision"></tbody>

<tfoot>
<tr>
<th>Total</th>
<th id="total_remision"></th>
</tr>
</tfoot>

</table>

</div>
</div>

</div>
</div>

</section>

<script>

// 🔥 SOLO BASE (SIN manuales)
let DETALLES = @json(
    $remision->detalles->whereNotIn('concepto',['Mensajería','Intereses'])
);

let contadorCargos = 0;

document.addEventListener("DOMContentLoaded", function(){

    recalcularTotal();

    ["mensajeria","intereses"].forEach(id => {
        document.getElementById(id)
        ?.addEventListener("input", recalcularTotal);
    });

});

// =========================
// 🔥 CARGOS
// =========================

function agregarCargo(nombre = '', valor = 0){

    contadorCargos++;

    let html = `
    <div class="row mt-2 cargo-item" data-id="${contadorCargos}">
        <div class="col-md-5">
            <input type="text" name="cargos[${contadorCargos}][concepto]"
                class="form-control"
                value="${nombre}">
        </div>

        <div class="col-md-3">
            <input type="number" step="0.01"
                name="cargos[${contadorCargos}][valor]"
                class="form-control valor-cargo"
                value="${valor}">
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-danger"
                onclick="eliminarCargo(${contadorCargos})">X</button>
        </div>
    </div>`;

    document.getElementById("contenedor_cargos")
        .insertAdjacentHTML('beforeend', html);

    recalcularTotal();
}

function eliminarCargo(id){
    document.querySelector(`[data-id='${id}']`)?.remove();
    recalcularTotal();
}

// =========================
// 🔥 TOTAL
// =========================

function recalcularTotal(){

    let totalFinal = 0;
    let tbody = document.getElementById("detalle_remision");

    tbody.innerHTML = "";

    DETALLES.forEach(d => {

        tbody.innerHTML += `
        <tr>
            <td>${d.concepto}</td>
            <td>${Number(d.valor).toLocaleString()}</td>
        </tr>`;

        totalFinal += Number(d.valor);
    });

    let mensajeria = Number(document.getElementById("mensajeria").value || 0);
    let intereses = Number(document.getElementById("intereses").value || 0);

    if(mensajeria > 0){
        tbody.innerHTML += `<tr><td>Mensajería</td><td>${mensajeria.toLocaleString()}</td></tr>`;
        totalFinal += mensajeria;
    }

    if(intereses > 0){
        tbody.innerHTML += `<tr><td>Intereses</td><td>${intereses.toLocaleString()}</td></tr>`;
        totalFinal += intereses;
    }

    document.querySelectorAll(".valor-cargo").forEach(input => {

        let valor = Number(input.value || 0);
        let concepto = input.closest('.cargo-item')
            .querySelector('input[type="text"]').value || 'Cargo';

        if(valor > 0){
            tbody.innerHTML += `<tr><td>${concepto}</td><td>${valor.toLocaleString()}</td></tr>`;
            totalFinal += valor;
        }
    });

    document.getElementById("total").value = totalFinal;
    document.getElementById("total_remision").innerHTML = totalFinal.toLocaleString();
}

document.addEventListener("input", function(e){
    if(e.target.classList.contains("valor-cargo")){
        recalcularTotal();
    }
});

</script>

@endsection