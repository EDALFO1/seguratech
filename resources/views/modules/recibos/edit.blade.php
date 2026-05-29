@extends('layouts.main')

@section('titulo','Editar Recibo')

@section('contenido')

<div class="pagetitle">
    <h1>Editar Recibo</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

<form action="{{ route('recibos.update',$recibo->id) }}" method="POST">
@csrf
@method('PUT')

<div class="row">

{{-- FECHA --}}
<div class="col-md-4 mb-3">
<label>Fecha</label>
<input type="date" name="fecha" id="fecha"
class="form-control"
value="{{ $recibo->fecha }}">
</div>

{{-- PERIODO --}}
<div class="col-md-4 mb-3">
<label>Periodo</label>
<input type="text" id="periodo" class="form-control" readonly>
</div>

{{-- AFILIADO (BLOQUEADO 🔒) --}}
<div class="col-md-6 mb-3">
<label>Afiliado</label>
<input type="text" class="form-control"
value="{{ optional($recibo->afiliado)->primer_nombre }} {{ optional($recibo->afiliado)->primer_apellido }} - {{ optional($recibo->afiliado)->numero_documento }}"
readonly>

<input type="hidden" id="afiliado_id" name="afiliado_id"
value="{{ $recibo->afiliado_id }}">
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
<input type="number" id="total" name="total"
class="form-control" readonly>
</div>

{{-- NOVEDAD --}}
<div class="col-md-3 mb-3">
<label>Novedad</label>
<select name="novedad" id="novedad" class="form-control">
<option value="">Sin novedad</option>
<option value="Ingreso" {{ $recibo->novedad=='Ingreso'?'selected':'' }}>Ingreso</option>
<option value="Retiro" {{ $recibo->novedad=='Retiro'?'selected':'' }}>Retiro</option>
</select>
</div>

{{-- FECHA RETIRO --}}
<div class="col-md-3 mb-3" id="campo_retiro"
style="{{ $recibo->novedad=='Retiro'?'':'display:none;' }}">
<label>Fecha Retiro</label>
<input type="date" name="fecha_retiro"
class="form-control"
value="{{ $recibo->fecha_retiro }}">
</div>

</div>

<button class="btn btn-primary">Actualizar</button>

<a href="{{ route('recibos.index') }}" class="btn btn-secondary">
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

let RECIBO_ID = {{ $recibo->id }};
let TOTAL_BASE = 0;

document.addEventListener("DOMContentLoaded", function(){

    calcularPeriodo();
    cargarPreview();

    document.getElementById("fecha").addEventListener("change", function(){
        calcularPeriodo();
        cargarPreview();
    });

    // 🔥 manejar novedad
    const novedad = document.getElementById('novedad');
    const retiro = document.getElementById('campo_retiro');

    function toggleRetiro(){
        retiro.style.display = (novedad.value === 'Retiro') ? 'block' : 'none';
    }

    novedad.addEventListener('change', toggleRetiro);
    toggleRetiro();

});

// 🔥 PERIODO
function calcularPeriodo(){
    let fecha = document.getElementById("fecha").value;
    if(!fecha) return;

    let f = new Date(fecha);
    document.getElementById("periodo").value =
        f.getFullYear() + "-" + (f.getMonth()+1).toString().padStart(2,'0');
}

// 🔥 PREVIEW
function cargarPreview(){

    let afiliado = document.getElementById("afiliado_id").value;
    let fecha = document.getElementById("fecha").value;

    if(!afiliado || !fecha) return;

    fetch("{{ route('recibos.preview') }}",{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({
            afiliado_id: afiliado,
            fecha: fecha,
            recibo_id: RECIBO_ID
        })
    })
    .then(res => res.json())
    .then(data => {

        if(!data){
            alert("No se puede recalcular el recibo");
            return;
        }

        TOTAL_BASE = Number(data.total || 0);

        document.getElementById("dias_liquidar").value = data.dias || 0;
        document.getElementById("ibc").value = data.ibc || 0;

        let tbody = document.getElementById("detalle_recibo");
        tbody.innerHTML = "";

        data.detalles.forEach(d => {
            tbody.innerHTML += `<tr>
                <td>${d.concepto}</td>
                <td>${Number(d.valor).toLocaleString()}</td>
            </tr>`;
        });

        document.getElementById("total").value = TOTAL_BASE;
        document.getElementById("total_recibo").innerHTML = TOTAL_BASE.toLocaleString();
    });

}

</script>

@endsection