@extends('layouts.main')

@section('titulo','Seleccionar Empresa')

@section('contenido')

<div class="pagetitle text-center">
  <h1>Seleccionar Empresa</h1>
</div>

<section class="section">

  <div class="d-flex justify-content-center">
    <div style="max-width:500px; width:100%;">

      <div class="card">
        <div class="card-body text-center pt-4">

          <h5 class="mb-3">
            Elige la empresa con la que deseas trabajar
          </h5>

          @if($empresas->isEmpty())

            <div class="alert alert-warning">
              No tienes empresas asignadas
            </div>

          @else

            @foreach($empresas as $empresa)

              <form action="{{ route('cambiar.empresa') }}" method="POST">
                @csrf
                <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">

                <button type="submit" class="btn btn-primary w-100 mb-2">
                  {{ $empresa->nombre }}
                </button>

              </form>

            @endforeach

          @endif

        </div>
      </div>

    </div>
  </div>

</section>

@endsection