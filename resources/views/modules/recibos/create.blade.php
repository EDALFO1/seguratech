@extends('layouts.main')

@section('titulo','Crear Recibo')

@section('contenido')

<div class="pagetitle">
<h1>Crear Recibo</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('recibos.store') }}" method="POST">
@csrf

<div class="row">

{{-- FECHA --}}
<div class="col-md-4 mb-3">
<label>Fecha</label>
<input type="date" name="fecha" id="fecha"
class="form-control"
value="{{ date('Y-m-d') }}">
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

<div class="col-md-3 mb-3">
<label>Fecha afiliación</label>
<input type="date" id="fecha_afiliacion" class="form-control" readonly>
</div>


{{-- DIAS --}}
<div class="col-md-3 mb-3">
<label>Días</label>
<input type="number" id="dias_liquidar" class="form-control" readonly>
</div>

{{-- IBC --}}
<div class="col-md-3 mb-3">
<label>IBC</label>
<input type="number" id="ibc" class="form-control" readonly>
</div>

{{-- TOTAL --}}
<div class="col-md-3 mb-3">
<label>Total</label>
<input type="number" id="total" name="total" class="form-control" readonly>
</div>

<div class="row mt-2">

    <div class="col-md-4">
        <label>Novedad</label>
        <select name="novedad" id="novedad" class="form-control">
            <option value="">NINGUNA</option>
            <option value="Retiro">Retiro</option>
        </select>
    </div>

    <div class="col-md-4" id="div_fecha_retiro" style="display:none;">
        <label>Fecha retiro</label>
        <input type="date" name="fecha_retiro" id="fecha_retiro" class="form-control">
    </div>

</div>

{{-- CARGOS --}}
<div class="col-12 mt-3">
<label><strong>Cargos adicionales</strong></label>

<div id="contenedor_cargos"></div>

<button type="button" class="btn btn-success btn-sm mt-2"
onclick="agregarCargo()">
+ Agregar cargo
</button>
</div>

</div>

<button class="btn btn-primary mt-3">Guardar</button>

<a href="{{ route('recibos.index') }}" class="btn btn-secondary mt-3">
Cancelar
</a>

</form>

</div>
</div>

{{-- DETALLE --}}
<div class="card mt-4">
<div class="card-body">

<h5>Detalle del Recibo</h5>

<table class="table table-bordered">
<thead>
<tr>
<th>Concepto</th>
<th>Valor</th>
</tr>
</thead>

<tbody id="detalle_recibo"></tbody>

<tfoot>
<tr>
<th>Total</th>
<th id="total_recibo"></th>
</tr>
</tfoot>

</table>

</div>
</div>

</div>
</div>

</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById("buscar_afiliado");
    const resultados = document.getElementById("resultados_afiliado");
    const afiliado_id = document.getElementById("afiliado_id");

    const fecha = document.getElementById('fecha');
    const novedad = document.getElementById('novedad');
    const fechaRetiro = document.getElementById('fecha_retiro');
    const divFechaRetiro = document.getElementById('div_fecha_retiro');

    let timeout = null;

    // =========================
    // 🔥 YA NO LIMITAMOS EL CALENDARIO
    // =========================
    function limitarFechaRetiro(){
        // ❌ NO HACER NADA
        // dejamos seleccionar cualquier día (incluido el 1)
    }

    // =========================
    // 🔥 BUSCADOR AFILIADOS
    // =========================
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
        input.value = `${a.primer_nombre} ${a.primer_apellido} - ${a.numero_documento}`;
        afiliado_id.value = a.id;
        resultados.innerHTML = "";
        calcularPreview();
    }

    // =========================
    // 🔥 NOVEDAD RETIRO
    // =========================
    novedad.addEventListener('change', function () {

        if (this.value === 'Retiro') {
            divFechaRetiro.style.display = 'block';
        } else {
            divFechaRetiro.style.display = 'none';
            fechaRetiro.value = '';
        }

        calcularPreview();
    });

    // =========================
    // 🔥 EVENTOS
    // =========================
    fecha.addEventListener('change', calcularPreview);
    fechaRetiro.addEventListener('change', calcularPreview);

    // =========================
    // 🔥 VALIDAR RETIRO (CORREGIDO)
    // =========================
    function validarFechaRetiro(){

        if (novedad.value !== 'Retiro' || !fechaRetiro.value) return true;

        let [y, m, d] = fechaRetiro.value.split('-');
        let [yr, mr, dr] = fecha.value.split('-');

        let fechaSeleccionada = new Date(y, m-1, d);
        let fechaRecibo = new Date(yr, mr-1, dr);

        let mesAnterior = new Date(
            fechaRecibo.getFullYear(),
            fechaRecibo.getMonth() - 1,
            1
        );

        if (
            fechaSeleccionada.getMonth() !== mesAnterior.getMonth() ||
            fechaSeleccionada.getFullYear() !== mesAnterior.getFullYear()
        ) {
            alert("⚠ La fecha de retiro debe ser del mes anterior al recibo");
            fechaRetiro.value = '';
            return false;
        }

        return true;
    }

    // =========================
    // 🔥 PREVIEW
    // =========================
    function calcularPreview(){

        if(!afiliado_id.value || !fecha.value) return;

        if(!validarFechaRetiro()) return;

        fetch("{{ route('recibos.preview') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                afiliado_id: afiliado_id.value,
                fecha: fecha.value,
                novedad: novedad.value,
                fecha_retiro: fechaRetiro.value
            })
        })
        .then(res => res.json())
        .then(data => {

            if(!data) return;

            document.getElementById('dias_liquidar').value = data.dias || 0;
            document.getElementById('ibc').value = data.ibc || 0;
            document.getElementById('total').value = data.total || 0;
            document.getElementById('fecha_afiliacion').value = data.fecha_afiliacion ?? '';

            let tbody = document.getElementById('detalle_recibo');
            tbody.innerHTML = "";

            data.detalles.forEach(d => {
                tbody.innerHTML += `
                    <tr>
                        <td>${d.concepto}</td>
                        <td>${Number(d.valor).toLocaleString()}</td>
                    </tr>
                `;
            });

            document.getElementById('total_recibo').innerHTML =
                Number(data.total).toLocaleString();
        });
    }

});
</script>
@endsection