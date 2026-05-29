@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Crear Remisión</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<div class="alert alert-info">
El número de remisión se generará automáticamente.
</div>

<form action="{{ route('remisiones.store') }}" method="POST">
@csrf

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
value="{{ date('Y-m-d') }}">
</div>

{{-- PERIODO --}}
<div class="col-md-4 mb-3">
<label>Periodo</label>
<input type="text" id="periodo" class="form-control" readonly>
</div>

{{-- BUSCADOR --}}
<div class="col-md-6 mb-3 position-relative">

<label>Afiliado</label>

<input type="text" id="buscar_afiliado"
class="form-control"
placeholder="Buscar por documento o nombre">

<input type="hidden" name="afiliado_id" id="afiliado_id">

<div id="resultados_afiliado" class="list-group"></div>

</div>

{{-- FECHA AFILIACION --}}
<div class="col-md-3 mb-3">
<label>Fecha afiliación</label>
<input type="text" id="fecha_afiliacion" class="form-control" readonly>
</div>

{{-- DIAS --}}
<div class="col-md-3 mb-3">
<label>Días</label>
<input type="number" name="dias_liquidar" id="dias_liquidar"
class="form-control" readonly>
</div>

{{-- TOTAL --}}
<div class="col-md-3 mb-3">
<label>Total</label>
<input type="number" name="total" id="total"
class="form-control" readonly>
</div>

{{-- 🔥 MENSAJERIA --}}
<div class="col-md-3 mb-3">
<label>Mensajería</label>
<input type="number" step="0.01" name="mensajeria" id="mensajeria"
class="form-control" value="0">
</div>

{{-- 🔥 INTERESES --}}
<div class="col-md-3 mb-3">
<label>Intereses</label>
<input type="number" step="0.01" name="intereses" id="intereses"
class="form-control" value="0">
</div>

{{-- 🔥 CARGOS DINAMICOS --}}
<div class="col-12 mt-3">
<label><strong>Cargos adicionales</strong></label>

<div id="contenedor_cargos"></div>

<button type="button" class="btn btn-sm btn-success mt-2"
onclick="agregarCargo()">
+ Agregar cargo
</button>
</div>

</div> {{-- FIN ROW --}}

<button class="btn btn-primary">Guardar</button>

<a href="{{ route('remisiones.index') }}" class="btn btn-secondary">
Cancelar
</a>

</form>

</div>
</div>

{{-- PREVIEW --}}
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
let TOTAL_BASE = 0;
let contadorCargos = 0;

document.addEventListener("DOMContentLoaded", function(){

    calcularPeriodo();

    document.getElementById("fecha").addEventListener("change", function(){
        calcularPeriodo();
        cargarPreview();
    });

    const input = document.getElementById("buscar_afiliado");
    const resultados = document.getElementById("resultados_afiliado");

    let timeout = null;

    input.addEventListener("keyup", function(){

        clearTimeout(timeout);

        let texto = this.value.trim();

        if(texto.length < 2){
            resultados.innerHTML = "";
            return;
        }

        timeout = setTimeout(() => {

            fetch(`/buscar-afiliados?q=${texto}`)
            .then(res => res.json())
            .then(data => {

                resultados.innerHTML = "";

                if(!data.length){
                    resultados.innerHTML = `<div class="list-group-item">Sin resultados</div>`;
                    return;
                }

                if(data.length === 1){
                    seleccionarAfiliado(data[0]);
                    return;
                }

                data.forEach(a => {

                    let item = document.createElement("a");
                    item.classList.add("list-group-item","list-group-item-action");

                    item.innerText = `${a.primer_nombre} ${a.primer_apellido} - ${a.numero_documento}`;

                    item.onclick = function(){
                        seleccionarAfiliado(a);
                    };

                    resultados.appendChild(item);

                });

            });

        }, 300);

    });

    function seleccionarAfiliado(a){
        document.getElementById("buscar_afiliado").value =
            `${a.primer_nombre} ${a.primer_apellido} - ${a.numero_documento}`;

        document.getElementById("afiliado_id").value = a.id;
        resultados.innerHTML = "";

        cargarPreview();
    }

    // eventos manuales
    ["mensajeria","intereses"].forEach(id => {
        let el = document.getElementById(id);
        if(el){
            el.addEventListener("input", recalcularTotal);
        }
    });

});

// =========================
// 🔥 CARGOS DINÁMICOS
// =========================

function agregarCargo(){

    contadorCargos++;

    let html = `
    <div class="row mt-2 cargo-item" data-id="${contadorCargos}">
        <div class="col-md-5">
            <input type="text" name="cargos[${contadorCargos}][concepto]"
                class="form-control"
                placeholder="Concepto">
        </div>

        <div class="col-md-3">
            <input type="number" step="0.01"
                name="cargos[${contadorCargos}][valor]"
                class="form-control valor-cargo">
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
    document.querySelector(`.cargo-item[data-id='${id}']`)?.remove();
    recalcularTotal();
}

// =========================
// 🔥 RECALCULO
// =========================

function recalcularTotal(){

    let totalFinal = TOTAL_BASE;
    let tbody = document.getElementById("detalle_remision");

    document.querySelectorAll(".manual-row, .cargo-row")
        .forEach(el => el.remove());

    let mensajeria = Number(document.getElementById("mensajeria").value || 0);
    let intereses = Number(document.getElementById("intereses").value || 0);

    if(mensajeria > 0){
        tbody.innerHTML += `<tr class="manual-row"><td>Mensajería</td><td>${mensajeria.toLocaleString()}</td></tr>`;
        totalFinal += mensajeria;
    }

    if(intereses > 0){
        tbody.innerHTML += `<tr class="manual-row"><td>Intereses</td><td>${intereses.toLocaleString()}</td></tr>`;
        totalFinal += intereses;
    }

    document.querySelectorAll(".valor-cargo").forEach(input => {

        let valor = Number(input.value || 0);
        let concepto = input.closest('.cargo-item')
            .querySelector('input[type="text"]').value || 'Cargo';

        if(valor > 0){
            tbody.innerHTML += `<tr class="cargo-row"><td>${concepto}</td><td>${valor.toLocaleString()}</td></tr>`;
            totalFinal += valor;
        }
    });

    document.getElementById("total").value = totalFinal;

    let totalRemision = document.getElementById("total_remision");
    if(totalRemision){
        totalRemision.innerHTML = totalFinal.toLocaleString();
    }
}

document.addEventListener("input", function(e){
    if(e.target.classList.contains("valor-cargo")){
        recalcularTotal();
    }
});

// =========================
// 🔥 OTROS
// =========================

function calcularPeriodo(){
    let fecha = document.getElementById("fecha").value;
    if(!fecha) return;

    let f = new Date(fecha);
    document.getElementById("periodo").value =
        f.getFullYear() + "-" + (f.getMonth()+1).toString().padStart(2,'0');
}

function cargarPreview(){

    let afiliado = document.getElementById("afiliado_id").value;
    let fecha = document.getElementById("fecha").value;

    if(!afiliado || !fecha) return;

    fetch("{{ route('remisiones.preview') }}",{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ afiliado_id:afiliado, fecha:fecha })
    })
    .then(res => res.json())
    .then(data => {

        TOTAL_BASE = Number(data.total || 0);

        document.getElementById("fecha_afiliacion").value = data.fecha_afiliacion || '';
        document.getElementById("dias_liquidar").value = data.dias || 0;

        let tbody = document.getElementById("detalle_remision");
        tbody.innerHTML = "";

        data.detalles.forEach(d => {
            tbody.innerHTML += `<tr><td>${d.concepto}</td><td>${Number(d.valor).toLocaleString()}</td></tr>`;
        });

        recalcularTotal();
    });

}
</script>

@endsection