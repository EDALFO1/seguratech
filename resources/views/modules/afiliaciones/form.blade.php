{{-- ERRORES GENERALES --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>⚠️ Hay errores en el formulario:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">

@php
$isEdit = isset($afiliacion) && $afiliacion->id;
@endphp

{{-- ========================================= --}}
{{-- 👤 AFILIADO --}}
{{-- ========================================= --}}

@if(!$isEdit)

<div class="col-md-6 mb-3">
    <label>Buscar Afiliado</label>
    <div class="col-md-6 mb-3">
        <input type="text" id="buscar_afiliado" class="form-control" placeholder="Documento o nombre">
        <button type="button" class="btn btn-primary" id="btnBuscarAfiliado">Buscar</button>
    </div>
</div>

<div class="col-md-6 mb-3">
    <label>Resultados</label>
    <div id="lista_afiliados" class="list-group"></div>
</div>

<div class="col-md-12 mb-3">
    <div id="info_afiliado" class="alert alert-info d-none"></div>
</div>

<input type="hidden" name="afiliado_id" id="afiliado_id">

@error('afiliado_id')
    <small class="text-danger">{{ $message }}</small>
@enderror

@else

<div class="col-md-6 mb-3">
    <label>Afiliado</label>
    <div class="alert alert-info">
        <strong>
            {{ $afiliacion->afiliado->primer_nombre }}
            {{ $afiliacion->afiliado->primer_apellido }}
        </strong><br>
        Documento: {{ $afiliacion->afiliado->numero_documento }}
    </div>

    <input type="hidden" name="afiliado_id" value="{{ $afiliacion->afiliado_id }}">
</div>

@endif

{{-- ========================================= --}}
{{-- EPS --}}
{{-- ========================================= --}}
<div class="col-md-4 mb-3">
    <label>EPS</label>
    <select name="eps_id" class="form-control campo-form">
        <option value="">Seleccione</option>
        @foreach($eps as $e)
            <option value="{{ $e->id }}"
                {{ old('eps_id', $afiliacion->eps_id ?? '') == $e->id ? 'selected' : '' }}>
                {{ $e->nombre }}
            </option>
        @endforeach
    </select>
    @error('eps_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{-- ARL (CORREGIDO) --}}
<div class="col-md-4 mb-3">
    <label>ARL</label>
    <select name="arl_id" class="form-control campo-form">
        <option value="">Seleccione</option>
        @foreach($arls as $a)
            <option value="{{ $a->id }}"
                {{ old('arl_id', $afiliacion->arl_id ?? '') == $a->id ? 'selected' : '' }}>
                {{ $a->nombre }}
            </option>
        @endforeach
    </select>
    
</div>

{{-- NIVEL ARL --}}
<div class="col-md-4 mb-3">
    <label>Nivel ARL</label>
    <select name="nivel_arl" class="form-control campo-form">
        <option value="">Seleccione</option>
        @for($i=1; $i<=5; $i++)
            <option value="{{ $i }}"
                {{ old('nivel_arl', $afiliacion->nivel_arl ?? '') == $i ? 'selected' : '' }}>
                Nivel {{ $i }}
            </option>
        @endfor
    </select>
    @error('nivel_arl')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{-- PENSIÓN --}}
<div class="col-md-4 mb-3">
    <label>Pensión</label>
    <select name="pension_id" class="form-control campo-form">
        <option value="">Seleccione</option>
        @foreach($pensions as $p)
            <option value="{{ $p->id }}"
                {{ old('pension_id', $afiliacion->pension_id ?? '') == $p->id ? 'selected' : '' }}>
                {{ $p->nombre }}
            </option>
        @endforeach
    </select>
    @error('pension_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{-- CAJA --}}
<div class="col-md-4 mb-3">
    <label>Caja</label>
    <select name="caja_id" class="form-control campo-form">
        <option value="">Seleccione</option>
        @foreach($cajas as $c)
            <option value="{{ $c->id }}"
                {{ old('caja_id', $afiliacion->caja_id ?? '') == $c->id ? 'selected' : '' }}>
                {{ $c->nombre }}
            </option>
        @endforeach
    </select>
    @error('caja_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{-- TIPO IBC --}}
<div class="col-md-4 mb-3">
    <label>Tipo IBC</label>
    <select name="tipo_ibc" id="tipo_ibc" class="form-control campo-form">
        <option value="SMMLV"
            {{ old('tipo_ibc', $afiliacion->tipo_ibc ?? '') == 'SMMLV' ? 'selected' : '' }}>
            SMMLV
        </option>
        <option value="FIJO"
            {{ old('tipo_ibc', $afiliacion->tipo_ibc ?? '') == 'FIJO' ? 'selected' : '' }}>
            FIJO
        </option>
    </select>
    @error('tipo_ibc')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{-- IBC --}}
<div class="col-md-4 mb-3">
    <label>IBC</label>
    <input type="number"
           name="ibc"
           id="ibc"
           class="form-control campo-form"
           value="{{ old('ibc', $afiliacion->ibc ?? '') }}">
    @error('ibc')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{-- FECHA --}}
<div class="col-md-4 mb-3">
    <label>Fecha Afiliación</label>
    <input type="date"
           name="fecha_afiliacion"
           class="form-control campo-form"
           value="{{ old('fecha_afiliacion', $afiliacion->fecha_afiliacion ?? '') }}">
    @error('fecha_afiliacion')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

{{-- RETIRO --}}
<div class="col-md-4 mb-3">
    <label>Fecha Retiro</label>
    <input type="date"
           name="fecha_retiro"
           class="form-control campo-form"
           value="{{ old('fecha_retiro', $afiliacion->fecha_retiro ?? '') }}">
</div>

</div>