@extends('layouts.main')

@section('titulo',$titulo)

@section('contenido')

<div class="pagetitle">
<h1>Crear Afiliación</h1>
</div>

<section class="section">

<div class="row">
<div class="col-lg-12">

<div class="card">
<div class="card-body pt-4">

@if($afiliados->isEmpty())
<div class="alert alert-danger">
⚠️ No hay afiliados registrados.
<a href="{{ route('afiliados.create') }}" class="btn btn-primary btn-sm">
Crear Afiliado
</a>
</div>
@else

<form id="formAfiliacion"  action="{{ route('afiliaciones.store') }}" method="POST">
    @csrf

    @include('modules.afiliaciones.form')

    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('afiliaciones.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@endif

</div>
</div>

</div>
</div>

</section>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    const salarios = @json($parametros);

    function bloquearFormulario() {
        $('.campo-form').prop('disabled', true);
    }

    function desbloquearFormulario() {
        $('.campo-form').prop('disabled', false);
    }

    bloquearFormulario();

    // 🔥 FUNCIÓN CENTRAL (VALIDA TODO)
    function seleccionarAfiliado(af) {

    let estado = Number(af.estado) === 1;

    let tiene_afiliacion =
        af.tiene_afiliacion_activa == true ||
        af.tiene_afiliacion_activa == 1 ||
        af.tiene_afiliacion_activa == '1';

    let nombre = af.primer_nombre + ' ' + af.primer_apellido;
    let doc = af.numero_documento;

    // ❌ INACTIVO
    if (!estado) {

        alert('❌ Este afiliado está inactivo y no puede ser afiliado.');

        bloquearFormulario();

        $('#afiliado_id').val('');

        $('#info_afiliado').removeClass('d-none').html(`
            <strong>${nombre}</strong><br>
            Documento: ${doc}<br>
            <span class="text-danger">AFILIADO INACTIVO</span>
        `);

        return;
    }

    // ❌ YA TIENE AFILIACIÓN
    if (tiene_afiliacion) {

        alert('❌ Este afiliado ya tiene una afiliación activa.');

        bloquearFormulario();

        $('#afiliado_id').val('');

        $('#info_afiliado').removeClass('d-none').html(`
            <strong>${nombre}</strong><br>
            Documento: ${doc}<br>
            <span class="text-danger">YA TIENE AFILIACIÓN ACTIVA</span>
        `);

        return;
    }

    // ✅ VÁLIDO
    $('#afiliado_id').val(af.id);

    $('#info_afiliado').removeClass('d-none').html(`
        <strong>${nombre}</strong><br>
        Documento: ${doc}<br>
        <span class="text-success">AFILIADO DISPONIBLE</span>
    `);

    desbloquearFormulario();
}

    // 🔍 BUSCAR AFILIADO
    $('#btnBuscarAfiliado').click(function () {

        let buscar = $('#buscar_afiliado').val();

        if (!buscar) {
            alert('Escribe algo para buscar');
            return;
        }

        bloquearFormulario();
        $('#afiliado_id').val('');
        $('#info_afiliado').addClass('d-none').html('');

        axios.get("{{ route('afiliados.buscar') }}", {
            params: { buscar: buscar }
        })
        .then(function (response) {

            let lista = $('#lista_afiliados');
            lista.empty();

            if (response.data.length === 0) {

                alert('❌ No se encontró ningún afiliado');

                $('#info_afiliado').removeClass('d-none').html(`
                    <span class="text-success">AFILIADO DISPONIBLE</span>
                `);

                return;
            }

            // 🔥 AUTOSELECCIONAR SI SOLO HAY UNO
            if (response.data.length === 1) {
                seleccionarAfiliado(response.data[0]);
                return;
            }

            // 🔘 MOSTRAR LISTA
            response.data.forEach(function (af) {

                lista.append(`
                    <a href="#" class="list-group-item afiliado-item"
                       data-id="${af.id}"
                       data-primer_nombre="${af.primer_nombre}"
                       data-primer_apellido="${af.primer_apellido}"
                       data-doc="${af.numero_documento}"
                       data-estado="${af.estado}"
                       data-tiene_afiliacion="${af.tiene_afiliacion_activa ? '1' : '0'}">
                       
                       <strong>${af.primer_nombre} ${af.primer_apellido}</strong><br>
                       Documento: ${af.numero_documento}
                    </a>
                `);

            });

        });

    });

    // 🔘 CLICK EN RESULTADO
    $(document).on('click', '.afiliado-item', function (e) {
        e.preventDefault();

        seleccionarAfiliado({
            id: $(this).data('id'),
            primer_nombre: $(this).data('primer_nombre'),
            primer_apellido: $(this).data('primer_apellido'),
            numero_documento: $(this).data('doc'),
            estado: $(this).attr('data-estado'),
            tiene_afiliacion_activa: $(this).attr('data-tiene_afiliacion') === '1'
        });

        $('#lista_afiliados').empty();
    });

    // 🔥 IBC DINÁMICO
    function actualizarIBC() {

        let tipo = $('#tipo_ibc').val();
        let fecha = $('#fecha_afiliacion').val();

        if (tipo === 'SMMLV') {

            if (!fecha) {
                $('#ibc').val('').prop('readonly', true);
                return;
            }

            let anio = new Date(fecha).getFullYear();
            let salario = salarios[anio] ?? 0;

            $('#ibc').val(salario).prop('readonly', true);

        } else {
            $('#ibc').val('').prop('readonly', false);
        }
    }

    $('#tipo_ibc').on('change', actualizarIBC);
    $('#fecha_afiliacion').on('change', actualizarIBC);

    actualizarIBC();

    // 🚫 VALIDACIÓN FINAL
    $('#formAfiliacion').submit(function (e) {
        if (!$('#afiliado_id').val()) {
            e.preventDefault();
            alert('Debes seleccionar un afiliado válido');
        }
    });

});
</script>
@endpush