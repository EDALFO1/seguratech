<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">Nombre</label>

        <input
        type="text"
        name="nombre"
        class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre',$documento->nombre ?? '') }}"
        required
        >

        @error('nombre')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>


    <div class="col-md-3 mb-3">

        <label class="form-label">Código</label>

        <input
        type="text"
        name="codigo"
        class="form-control @error('codigo') is-invalid @enderror"
        value="{{ old('codigo',$documento->codigo ?? '') }}"
        required
        >

        @error('codigo')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

</div>