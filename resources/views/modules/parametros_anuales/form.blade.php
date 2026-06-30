<div class="row g-3">
    <div class="col-md-3">
        <label class="form-label fw-semibold">Año <span class="text-danger">*</span></label>
        <input type="number" name="anio" class="form-control @error('anio') is-invalid @enderror" value="{{ old('anio', $parametro_anual->anio ?? date('Y')) }}" required>
        @error('anio') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Salario Mínimo <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="salario_minimo" class="form-control @error('salario_minimo') is-invalid @enderror" value="{{ old('salario_minimo', $parametro_anual->salario_minimo ?? '') }}" required>
        @error('salario_minimo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Administración <span class="text-danger">*</span></label>
        <input type="number" step="0.01" name="administracion" class="form-control @error('administracion') is-invalid @enderror" value="{{ old('administracion', $parametro_anual->administracion ?? '') }}" required>
        @error('administracion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-12 border-top pt-3 mt-2">
        <h6 class="text-muted mb-3">
            <i class="bi bi-gear-fill me-2"></i>Configuración adicional
        </h6>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Admin. Solo ARL</label>
        <input type="number" step="0.01" name="valor_admin_solo_arl" class="form-control @error('valor_admin_solo_arl') is-invalid @enderror" value="{{ old('valor_admin_solo_arl', $parametro_anual->valor_admin_solo_arl ?? '') }}">
        <small class="text-muted d-block mt-1">
            Valor de administración para afiliados exclusivos de ARL. Se usa como valor por defecto al crear nuevos afiliados.
        </small>
        @error('valor_admin_solo_arl') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
