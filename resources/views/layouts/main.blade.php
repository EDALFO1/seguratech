<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>@yield('titulo')</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

<!-- Bootstrap -->
<link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- ✅ Bootstrap Icons (ÚNICO SISTEMA DE ICONOS) -->
<link href="{{ asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

<!-- ❌ Font Awesome ELIMINADO para evitar conflicto -->
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"> --}}

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.css">

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Template CSS -->
<link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet">

<!-- 🔥 FIX DEFINITIVO DEL BUG -->
<style>
.toggle-sidebar-btn {
    font-size: 22px !important;
    line-height: normal !important;
    transform: none !important;
}

.bi::before {
    font-size: inherit !important;
}

body {
    overflow-x: hidden;
}
</style>

</head>

<body>

@include('shared.header')
@include('shared.aside')

<main id="main" class="main">

    <section class="section">

        

        {{-- 🔥 CONTENIDO --}}
        @yield('contenido')

    </section>

</main>

@include('shared.footer')

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');
</script>

<!-- Template JS -->
<script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>

<script>
$(function(){

    // 📊 DataTables
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            language: {
                emptyTable: "No hay información",
                info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                lengthMenu: "Mostrar _MENU_ entradas",
                search: "Buscar:",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });
    }

    // ✅ Alertas
    @if(session('success'))
    Swal.fire({
        title:'Éxito',
        text:@json(session('success')),
        icon:'success'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        title:'Error',
        text:@json(session('error')),
        icon:'error'
    });
    @endif

});
</script>

@stack('scripts')

</body>
</html>