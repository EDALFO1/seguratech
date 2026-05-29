{{-- Mostrar todos los errores --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Empresas</label>

        <select name="empresa_id[]" class="form-control @error('empresa_id') is-invalid @enderror" multiple>
            @foreach($empresas as $empresa)
                <option value="{{ $empresa->id }}"
                    {{ isset($usuario) && $usuario->empresas->pluck('id')->contains($empresa->id) ? 'selected' : '' }}>
                    {{ $empresa->nombre }}
                </option>
            @endforeach
        </select>

        @error('empresa_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

        <small class="text-muted">Puedes seleccionar varias empresas</small>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Rol</label>

        <select name="rol_id" class="form-control @error('rol_id') is-invalid @enderror">
            @foreach($roles as $rol)
                <option value="{{ $rol->id }}"
                    {{ old('rol_id',$usuario->rol_id ?? '') == $rol->id ? 'selected' : '' }}>
                    {{ $rol->nombre }}
                </option>
            @endforeach
        </select>

        @error('rol_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Nombre</label>

        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name',$usuario->name ?? '') }}"
            required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Email</label>

        <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email',$usuario->email ?? '') }}"
            required>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Password</label>

        <input
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror">

        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Estado</label>

        <select name="estado" class="form-control @error('estado') is-invalid @enderror">
            <option value="1"
                {{ old('estado',$usuario->estado ?? 1) == 1 ? 'selected' : '' }}>
                Activo
            </option>

            <option value="0"
                {{ old('estado',$usuario->estado ?? 1) == 0 ? 'selected' : '' }}>
                Inactivo
            </option>
        </select>

        @error('estado')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

</div>