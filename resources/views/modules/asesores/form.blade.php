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
                {{ old('documento_id', $asesor->documento_id ?? '') == $doc->id ? 'selected' : '' }}>
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

        <input
            type="text"
            name="numero_documento"
            inputmode="numeric"
            pattern="[0-9]*"
            class="form-control @error('numero_documento') is-invalid @enderror"
            value="{{ old('numero_documento', $asesor->numero_documento ?? '') }}"
            required>

        @error('numero_documento')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- 🔹 NOMBRE --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre</label>

        <input
            type="text"
            name="nombre"
            class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', $asesor->nombre ?? '') }}"
            required>

        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- 🔹 TELÉFONO --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Teléfono</label>

        <input
            type="text"
            name="telefono"
            inputmode="numeric"
            pattern="[0-9]*"
            class="form-control @error('telefono') is-invalid @enderror"
            value="{{ old('telefono', $asesor->telefono ?? '') }}">

        @error('telefono')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- 🔹 EMAIL --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Email</label>

        <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $asesor->email ?? '') }}">

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- 🔹 DIRECCIÓN --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Dirección</label>

        <input
            type="text"
            name="direccion"
            class="form-control @error('direccion') is-invalid @enderror"
            value="{{ old('direccion', $asesor->direccion ?? '') }}">

        @error('direccion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>