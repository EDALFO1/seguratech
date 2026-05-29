<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">Nombre</label>

        <input
        type="text"
        name="nombre"
        class="form-control @error('nombre') is-invalid @enderror"
        value="{{ old('nombre',$role->nombre ?? '') }}"
        required>

        @error('nombre')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>


    <div class="col-md-6 mb-3">

        <label class="form-label">Descripción</label>

        <input
        type="text"
        name="descripcion"
        class="form-control @error('descripcion') is-invalid @enderror"
        value="{{ old('descripcion',$role->descripcion ?? '') }}">

        @error('descripcion')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

</div>