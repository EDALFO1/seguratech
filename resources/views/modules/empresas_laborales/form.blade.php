@if ($errors->any())
<div class="alert alert-danger">
    <strong>Ups... hay errores:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">

    {{-- 🔥 EMPRESA (SOLO VISUAL) --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Empresa</label>
        <input type="text"
               class="form-control bg-light"
               value="{{ session('empresa_nombre') }}"
               disabled>
    </div>

    {{-- 🔹 TIPO DOCUMENTO --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">Tipo Documento</label>

        <select name="documento_id"
                class="form-control @error('documento_id') is-invalid @enderror"
                required>

            <option value="">Seleccione</option>

            @foreach($documentos as $doc)
            <option value="{{ $doc->id }}"
            {{ old('documento_id',$empresa_laboral->documento_id ?? '') == $doc->id ? 'selected' : '' }}>
                {{ $doc->nombre }}
            </option>
            @endforeach

        </select>

        @error('documento_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    {{-- 🔹 NUMERO DOCUMENTO --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">Número Documento</label>

        <input type="text"
               name="numero_documento"
               class="form-control @error('numero_documento') is-invalid @enderror"
               value="{{ old('numero_documento',$empresa_laboral->numero_documento ?? '') }}"
               required>

        @error('numero_documento')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    {{-- 🔹 NOMBRE --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">Nombre</label>

        <input type="text"
               name="nombre"
               class="form-control @error('nombre') is-invalid @enderror"
               value="{{ old('nombre',$empresa_laboral->nombre ?? '') }}"
               required>

        @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    {{-- 🔹 TELÉFONO --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">Teléfono</label>

        <input type="text"
               name="telefono"
               class="form-control"
               value="{{ old('telefono',$empresa_laboral->telefono ?? '') }}">

    </div>

    {{-- 🔹 CONTACTO --}}
    <div class="col-md-3 mb-3">

    <label class="form-label">Contacto</label>

    <input type="text"
           name="contacto"
           class="form-control @error('contacto') is-invalid @enderror"
           value="{{ old('contacto',$empresa_laboral->contacto ?? '') }}"
           required>

    @error('contacto')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

    {{-- 🔹 EMAIL --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">Email</label>

        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email',$empresa_laboral->email ?? '') }}">

        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    {{-- 🔹 DIRECCIÓN --}}
    <div class="col-md-6 mb-3">

        <label class="form-label">Dirección</label>

        <input type="text"
               name="direccion"
               class="form-control"
               value="{{ old('direccion',$empresa_laboral->direccion ?? '') }}">

    </div>

    {{-- 🔹 ESTADO --}}
    <div class="col-md-2 mb-3">

        <label class="form-label">Estado</label>

        <select name="estado"
                class="form-control @error('estado') is-invalid @enderror">

            <option value="1"
            {{ old('estado',$empresa_laboral->estado ?? 1) == 1 ? 'selected' : '' }}>
                Activo
            </option>

            <option value="0"
            {{ old('estado',$empresa_laboral->estado ?? 1) == 0 ? 'selected' : '' }}>
                Inactivo
            </option>

        </select>

        @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

</div>