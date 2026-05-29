<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Nombre</label>

<input
type="text"
name="nombre"
class="form-control @error('nombre') is-invalid @enderror"
value="{{ old('nombre',$empresa->nombre ?? '') }}"
required>

@error('nombre')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>


<div class="col-md-3 mb-3">
<label class="form-label">NIT</label>

<input
type="text"
name="nit"
class="form-control @error('nit') is-invalid @enderror"
value="{{ old('nit',$empresa->nit ?? '') }}"
required>

@error('nit')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>


<div class="col-md-3 mb-3">
<label class="form-label">Teléfono</label>

<input
type="text"
name="telefono"
class="form-control @error('telefono') is-invalid @enderror"
value="{{ old('telefono',$empresa->telefono ?? '') }}">

@error('telefono')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>


<div class="col-md-6 mb-3">
<label class="form-label">Dirección</label>

<input
type="text"
name="direccion"
class="form-control"
value="{{ old('direccion',$empresa->direccion ?? '') }}">
</div>


<div class="col-md-4 mb-3">
<label class="form-label">Email</label>

<input
type="email"
name="email"
class="form-control @error('email') is-invalid @enderror"
value="{{ old('email',$empresa->email ?? '') }}">

@error('email')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>


<div class="col-md-2 mb-3">
<label class="form-label">Estado</label>

<select name="estado" class="form-control">
<option value="1" {{ old('estado',$empresa->estado ?? 1) == 1 ? 'selected' : '' }}>
Activo
</option>

<option value="0" {{ old('estado',$empresa->estado ?? 1) == 0 ? 'selected' : '' }}>
Inactivo
</option>
</select>
</div>

</div>