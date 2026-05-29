<div class="row">

    <div class="col-md-4 mb-3">

        <label class="form-label">Código</label>

        <input
        type="text"
        name="codigo"
        class="form-control @error('codigo') is-invalid @enderror"
        value="{{ old('codigo',$subtipo_cotizante->codigo ?? '') }}"
        required>

        @error('codigo')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>


    <div class="col-md-8 mb-3">

        <label class="form-label">Nombre</label>

        <input
        type="text"
        name="nombre"
        class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre',$subtipo_cotizante->nombre ?? '') }}"
        required>

        @error('nombre')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

</div>