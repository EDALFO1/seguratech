{{-- ========================================= --}}
{{-- ARL --}}
{{-- ========================================= --}}

<div class="row">

    {{-- NOMBRE --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">Nombre</label>

        <input
            type="text"
            name="nombre"
            class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', $arl->nombre ?? '') }}"
            required
        >

        @error('nombre')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- CÓDIGO --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">Código</label>

        <input
            type="text"
            name="codigo"
            class="form-control @error('codigo') is-invalid @enderror"
            value="{{ old('codigo', $arl->codigo ?? '') }}"
            required
        >

        @error('codigo')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- NIVEL --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">Nivel</label>

        <select
            name="nivel"
            class="form-control @error('nivel') is-invalid @enderror"
            required
        >

            <option value="">Seleccione</option>

            @for($i=1; $i<=5; $i++)

                <option
                    value="{{ $i }}"
                    {{ old('nivel', $arl->nivel ?? '') == $i ? 'selected' : '' }}
                >

                    Nivel {{ $i }}

                </option>

            @endfor

        </select>

        @error('nivel')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- PORCENTAJE --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">Porcentaje</label>

        <input
            type="number"
            step="0.0001"
            name="porcentaje"
            class="form-control @error('porcentaje') is-invalid @enderror"
            value="{{ old('porcentaje', $arl->porcentaje ?? '') }}"
            required
        >

        @error('porcentaje')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- ACTIVIDAD ECONÓMICA --}}
    <div class="col-md-4 mb-3">

        <label class="form-label">
            Actividad Económica
        </label>

        <input
            type="text"
            name="actividad_economica"
            class="form-control @error('actividad_economica') is-invalid @enderror"
            value="{{ old('actividad_economica', $arl->actividad_economica ?? '') }}"
        >

        @error('actividad_economica')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>