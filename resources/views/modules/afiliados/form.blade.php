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

{{-- EMPRESA --}}
<div class="col-md-3 mb-3">
    <label>Empresa</label>
    <input type="text" class="form-control"
           value="{{ session('empresa_nombre') }}" disabled>
</div>

{{-- EMPRESA LABORAL --}}
<div class="col-md-3 mb-3">
    <label>Empresa Laboral</label>
    <select name="empresa_laboral_id" class="form-control @error('empresa_laboral_id') is-invalid @enderror" required>
        <option value="">Seleccione</option>
        @foreach($empresasLaborales as $el)
        <option value="{{ $el->id }}"
        {{ old('empresa_laboral_id',$afiliado->empresa_laboral_id ?? '') == $el->id ? 'selected' : '' }}>
            {{ $el->nombre }}
        </option>
        @endforeach
    </select>
    @error('empresa_laboral_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ASESOR --}}
<div class="col-md-3 mb-3">
    <label>Asesor</label>
    <select name="asesor_id" class="form-control @error('asesor_id') is-invalid @enderror">
        <option value="">Seleccione</option>
        @foreach($asesores as $a)
        <option value="{{ $a->id }}"
        {{ old('asesor_id',$afiliado->asesor_id ?? '') == $a->id ? 'selected' : '' }}>
            {{ $a->nombre }}
        </option>
        @endforeach
    </select>
    @error('asesor_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- DOCUMENTO --}}
<div class="col-md-3 mb-3">
    <label>Tipo Documento</label>
    <select name="documento_id" class="form-control @error('documento_id') is-invalid @enderror" required>
        @foreach($documentos as $doc)
        <option value="{{ $doc->id }}"
        {{ old('documento_id',$afiliado->documento_id ?? '') == $doc->id ? 'selected' : '' }}>
            {{ $doc->nombre }}
        </option>
        @endforeach
    </select>
    @error('documento_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- SUBTIPO --}}
<div class="col-md-3 mb-3">
    <label>Subtipo Cotizante</label>
    <select name="subtipo_cotizante_id" class="form-control @error('subtipo_cotizante_id') is-invalid @enderror" required>
        @foreach($subtipos as $s)
        <option value="{{ $s->id }}"
        {{ old('subtipo_cotizante_id',$afiliado->subtipo_cotizante_id ?? '') == $s->id ? 'selected' : '' }}>
            {{ $s->nombre }}
        </option>
        @endforeach
    </select>
    @error('subtipo_cotizante_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- NUMERO --}}
<div class="col-md-3 mb-3">
    <label>Número Documento</label>
    <input type="text" name="numero_documento"
    class="form-control @error('numero_documento') is-invalid @enderror"
    value="{{ old('numero_documento',$afiliado->numero_documento ?? '') }}" required>

    @error('numero_documento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- NOMBRES --}}
<div class="col-md-3 mb-3">
    <label>Primer Nombre</label>
    <input type="text" name="primer_nombre"
    class="form-control @error('primer_nombre') is-invalid @enderror"
    value="{{ old('primer_nombre',$afiliado->primer_nombre ?? '') }}" required>

    @error('primer_nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3 mb-3">
    <label>Segundo Nombre</label>
    <input type="text" name="segundo_nombre"
    class="form-control @error('segundo_nombre') is-invalid @enderror"
    value="{{ old('segundo_nombre',$afiliado->segundo_nombre ?? '') }}">

    @error('segundo_nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- APELLIDOS --}}
<div class="col-md-3 mb-3">
    <label>Primer Apellido</label>
    <input type="text" name="primer_apellido"
    class="form-control @error('primer_apellido') is-invalid @enderror"
    value="{{ old('primer_apellido',$afiliado->primer_apellido ?? '') }}" required>

    @error('primer_apellido')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3 mb-3">
    <label>Segundo Apellido</label>
    <input type="text" name="segundo_apellido"
    class="form-control @error('segundo_apellido') is-invalid @enderror"
    value="{{ old('segundo_apellido',$afiliado->segundo_apellido ?? '') }}">

    @error('segundo_apellido')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- FECHA --}}
<div class="col-md-3 mb-3">
    <label>Fecha Nacimiento</label>
    <input type="date" name="fecha_nacimiento"
    class="form-control @error('fecha_nacimiento') is-invalid @enderror"
    value="{{ old('fecha_nacimiento', $afiliado->fecha_nacimiento?->format('Y-m-d')) }}" required>

    @error('fecha_nacimiento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- SEXO --}}
<div class="col-md-3 mb-3">
    <label>Sexo</label>
    <select name="sexo" class="form-control @error('sexo') is-invalid @enderror" required>
        <option value="M" {{ old('sexo',$afiliado->sexo ?? '') == 'M' ? 'selected' : '' }}>Masculino</option>
        <option value="F" {{ old('sexo',$afiliado->sexo ?? '') == 'F' ? 'selected' : '' }}>Femenino</option>
        <option value="Otro" {{ old('sexo',$afiliado->sexo ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
    </select>

    @error('sexo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- CONTACTO --}}
<div class="col-md-3 mb-3">
    <label>Correo</label>
    <input type="email" name="correo"
    class="form-control @error('correo') is-invalid @enderror"
    value="{{ old('correo',$afiliado->correo ?? '') }}">

    @error('correo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3 mb-3">
    <label>Teléfono</label>
    <input type="text" name="telefono"
    class="form-control @error('telefono') is-invalid @enderror"
    value="{{ old('telefono',$afiliado->telefono ?? '') }}">

    @error('telefono')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3 mb-3">
    <label>Dirección</label>
    <input type="text" name="direccion"
    class="form-control @error('direccion') is-invalid @enderror"
    value="{{ old('direccion',$afiliado->direccion ?? '') }}">

    @error('direccion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3 mb-3">
    <label>Ciudad</label>
    <input type="text" name="ciudad"
    class="form-control @error('ciudad') is-invalid @enderror"
    value="{{ old('ciudad',$afiliado->ciudad ?? '') }}">

    @error('ciudad')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- ESTADO --}}
<div class="col-md-3 mb-3">
    <label>Estado</label>
    <select name="estado" class="form-control @error('estado') is-invalid @enderror">
        <option value="1" {{ old('estado',$afiliado->estado ?? '') == '1' ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ old('estado',$afiliado->estado ?? '') == '0' ? 'selected' : '' }}>Inactivo</option>
    </select>

    @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



</div>