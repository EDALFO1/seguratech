<div class="row">

<div class="col-md-4 mb-3">

<label>Nombre</label>

<input
type="text"
name="nombre"
class="form-control"
value="{{ old('nombre',$servicio->nombre ?? '') }}"
required>

</div>


<div class="col-md-3 mb-3">

<label>Tipo</label>

<input
type="text"
name="tipo"
class="form-control"
value="{{ old('tipo',$servicio->tipo ?? '') }}">

</div>


<div class="col-md-3 mb-3">

<label>Valor Base</label>

<input
type="number"
step="0.01"
name="valor_base"
class="form-control"
value="{{ old('valor_base',$servicio->valor_base ?? 0) }}">

</div>


<div class="col-md-2 mb-3">

<label>Estado</label>

<select name="estado" class="form-control">

<option value="1"
{{ old('estado',$servicio->estado ?? 1) == 1 ? 'selected' : '' }}>
Activo
</option>

<option value="0"
{{ old('estado',$servicio->estado ?? 1) == 0 ? 'selected' : '' }}>
Inactivo
</option>

</select>

</div>

</div>