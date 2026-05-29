<div class="row mb-3">

    <div class="col-md-6">

        <label class="form-label">
            Nombre
        </label>

        <input
        type="text"
        name="nombre"
        class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre', $eps->nombre ?? '') }}"
        required
        >

        @error('nombre')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>


    <div class="col-md-3">

        <label class="form-label">
            Código
        </label>

        <input
        type="text"
        name="codigo"
        class="form-control @error('codigo') is-invalid @enderror"
        value="{{ old('codigo', $eps->codigo ?? '') }}"
        required
        >

        @error('codigo')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>


    <div class="col-md-3">

        <label class="form-label">
            Porcentaje
        </label>

        <input
        type="number"
        step="0.01"
        name="porcentaje"
        class="form-control @error('porcentaje') is-invalid @enderror"
        value="{{ old('porcentaje', $eps->porcentaje ?? 4) }}"
        required
        >

        @error('porcentaje')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

</div>