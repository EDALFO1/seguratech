<div class="row">

    {{-- 🔥 EMPRESA (SOLO VISUAL) --}}
    <div class="col-md-3 mb-3">
        <label class="form-label">Empresa</label>
        <input type="text"
               class="form-control bg-light"
               value="{{ session('empresa_nombre') }}"
               disabled>
    </div>

    {{-- 🔹 AFILIADO --}}
    <div class="col-md-4 mb-3">

        <label class="form-label">Afiliado</label>

        <select name="afiliado_id"
                class="form-control @error('afiliado_id') is-invalid @enderror"
                required>

            <option value="">Seleccione</option>

            @foreach($afiliados as $af)
            <option value="{{ $af->id }}"
            {{ old('afiliado_id',$afiliado_servicio->afiliado_id ?? '') == $af->id ? 'selected' : '' }}>
                {{ $af->primer_nombre }} {{ $af->primer_apellido }}
                ({{ $af->numero_documento }})
            </option>
            @endforeach

        </select>

        @error('afiliado_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>


    {{-- 🔹 SERVICIO --}}
    <div class="col-md-3 mb-3">

        <label class="form-label">Servicio</label>

        <select name="servicio_id"
                class="form-control @error('servicio_id') is-invalid @enderror"
                required>

            <option value="">Seleccione</option>

            @foreach($servicios as $s)
            <option value="{{ $s->id }}"
            {{ old('servicio_id',$afiliado_servicio->servicio_id ?? '') == $s->id ? 'selected' : '' }}>
                {{ $s->nombre }}
            </option>
            @endforeach

        </select>

        @error('servicio_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>


    {{-- 🔹 VALOR --}}
    <div class="col-md-2 mb-3">

        <label class="form-label">Valor</label>

        <input
        type="number"
        step="0.01"
        name="valor"
        class="form-control @error('valor') is-invalid @enderror"
        value="{{ old('valor',$afiliado_servicio->valor ?? 0) }}">

        @error('valor')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>


    {{-- 🔹 ESTADO --}}
    <div class="col-md-2 mb-3">

        <label class="form-label">Estado</label>

        <select name="estado"
                class="form-control @error('estado') is-invalid @enderror">

            <option value="1"
            {{ old('estado',$afiliado_servicio->estado ?? 1) == 1 ? 'selected' : '' }}>
            Activo
            </option>

            <option value="0"
            {{ old('estado',$afiliado_servicio->estado ?? 1) == 0 ? 'selected' : '' }}>
            Inactivo
            </option>

        </select>

        @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

</div>