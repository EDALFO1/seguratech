<?php

namespace App\Imports;

use App\Models\Afiliado;
use App\Models\EmpresaLaboral;
use App\Models\Asesor;
use App\Models\Documento;
use App\Models\SubtipoCotizante;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AfiliadosImport implements
    ToModel,
    WithHeadingRow,
    SkipsEmptyRows
{
    protected $empresaId;
    public $duplicados = [];
    public $errores = [];
    public $creados = 0;
    public $total = 0;

    public function __construct($empresaId)
    {
        $this->empresaId = $empresaId;
    }

    public function model(array $row)
    {
        // 🔥 NORMALIZAR HEADERS
        $row = collect($row)->mapWithKeys(function ($value, $key) {
            $key = strtolower(trim($key));
            $key = str_replace([' ', '-'], '_', $key);
            return [$key => $value];
        })->toArray();

        // 🔥 FILA VACÍA REAL
        $filaVacia = collect($row)
            ->filter(fn($value) => !is_null($value) && trim($value) !== '')
            ->isEmpty();

        if ($filaVacia) return null;

        // 🔥 NÚMERO DE DOCUMENTO
        $numero = trim($row['numero_documento'] ?? '');

        // 🔥 ignorar filas vacías
        if ($numero === '') {
            return null;
        }

        $erroresFila = [];

        // ✅ documento
        if (empty($numero)) {
            $erroresFila[] = "Documento requerido";
        } elseif (!preg_match('/^[0-9]+$/', $numero)) {
            $erroresFila[] = "Documento debe contener solo números";
        }

        // ✅ nombre
        $primerNombre = trim($row['primer_nombre'] ?? '');
        if (empty($primerNombre)) {
            $erroresFila[] = "Primer nombre requerido";
        } elseif (preg_match('/[0-9]/', $primerNombre)) {
            $erroresFila[] = "Primer nombre no puede contener números";
        } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $primerNombre)) {
            $erroresFila[] = "Primer nombre contiene caracteres especiales no permitidos";
        }

        // ✅ segundo nombre
        $segundoNombre = trim($row['segundo_nombre'] ?? '');
        if (!empty($segundoNombre)) {
            if (preg_match('/[0-9]/', $segundoNombre)) {
                $erroresFila[] = "Segundo nombre no puede contener números";
            } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $segundoNombre)) {
                $erroresFila[] = "Segundo nombre contiene caracteres especiales no permitidos";
            }
        }

        // ✅ primer apellido
        $primerApellido = trim($row['primer_apellido'] ?? '');
        if (empty($primerApellido)) {
            $erroresFila[] = "Primer apellido requerido";
        } elseif (preg_match('/[0-9]/', $primerApellido)) {
            $erroresFila[] = "Primer apellido no puede contener números";
        } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $primerApellido)) {
            $erroresFila[] = "Primer apellido contiene caracteres especiales no permitidos";
        }

        // ✅ segundo apellido
        $segundoApellido = trim($row['segundo_apellido'] ?? '');
        if (!empty($segundoApellido)) {
            if (preg_match('/[0-9]/', $segundoApellido)) {
                $erroresFila[] = "Segundo apellido no puede contener números";
            } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $segundoApellido)) {
                $erroresFila[] = "Segundo apellido contiene caracteres especiales no permitidos";
            }
        }

        // ✅ fecha nacimiento
        $fecha = $row['fecha_nacimiento'] ?? null;
        if (empty($fecha)) {
            $erroresFila[] = "Fecha de nacimiento requerida";
        } else {
            try {
                if (is_numeric($fecha)) {
                    Date::excelToDateTimeObject($fecha)->format('Y-m-d');
                } else {
                    \DateTime::createFromFormat('Y-m-d', trim((string)$fecha));
                }
            } catch (\Exception $e) {
                $erroresFila[] = "Fecha de nacimiento inválida (usar YYYY-MM-DD)";
            }
        }

        // ✅ sexo
        $sexo = trim($row['sexo'] ?? '');
        if (!empty($sexo) && !in_array($sexo, ['M', 'F', 'Otro'])) {
            $erroresFila[] = "Sexo debe ser M, F u Otro";
        }

        // ✅ teléfono
        if (!empty($row['telefono']) && !preg_match('/^[0-9]+$/', $row['telefono'])) {
            $erroresFila[] = "Teléfono debe contener solo números";
        }

        // ✅ correo
        $correo = trim($row['correo'] ?? '');
        if (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $erroresFila[] = "Correo inválido";
        }

        // Contar total de filas procesadas
        $this->total++;

        // 🔥 SI HAY ERRORES DE FORMATO → GUARDAR Y RETORNAR
        if (!empty($erroresFila)) {
            $this->errores[] = "Documento {$numero}: " . implode(', ', $erroresFila);
            return null;
        }

        // 🔥 DUPLICADOS
        if (Afiliado::where('empresa_id', $this->empresaId)
            ->where('numero_documento', $numero)
            ->exists()) {

            $this->duplicados[] = $numero;
            return null;
        }

        // 🔥 VALIDAR RELACIONES
        $erroresRelaciones = [];

        $empresaLaboral = EmpresaLaboral::where('empresa_id', $this->empresaId)
            ->whereRaw('LOWER(TRIM(nombre)) = ?', [strtolower(trim($row['empresa_laboral'] ?? ''))])
            ->first();

        if (!$empresaLaboral) {
            $erroresRelaciones[] = "Empresa laboral «{$row['empresa_laboral']}» no encontrada";
        }

        $asesor = null;
        if (!empty($row['asesor'])) {
            $asesor = Asesor::where('empresa_id', $this->empresaId)
                ->whereRaw('LOWER(TRIM(nombre)) = ?', [strtolower(trim($row['asesor']))])
                ->first();

            if (!$asesor) {
                $erroresRelaciones[] = "Asesor «{$row['asesor']}» no encontrado";
            }
        }

        $documento = Documento::where(function($q) use ($row) {
            $tipo = strtolower(trim($row['tipo_documento'] ?? ''));
            $q->whereRaw('LOWER(TRIM(nombre)) = ?', [$tipo])
              ->orWhereRaw('LOWER(TRIM(codigo)) = ?', [$tipo]);
        })->first();

        if (!$documento) {
            $erroresRelaciones[] = "Tipo documento «{$row['tipo_documento']}» no encontrado";
        }

        $subtipo = SubtipoCotizante::whereRaw(
            'LOWER(TRIM(nombre)) = ?',
            [strtolower(trim($row['subtipo_cotizante'] ?? ''))]
        )->first();

        if (!$subtipo) {
            $erroresRelaciones[] = "Subtipo cotizante «{$row['subtipo_cotizante']}» no encontrado";
        }

        if (!empty($erroresRelaciones)) {
            $this->errores[] = "Documento {$numero}: " . implode(', ', $erroresRelaciones);
            return null;
        }

        // 🔥 PROCESAR FECHA
        if (is_numeric($fecha)) {
            $fecha = Date::excelToDateTimeObject($fecha)->format('Y-m-d');
        }

        // 🔥 CREAR AFILIADO
        $this->creados++;

        return Afiliado::create([
            'empresa_id' => $this->empresaId,
            'empresa_laboral_id' => $empresaLaboral->id,
            'asesor_id' => $asesor?->id,
            'documento_id' => $documento->id,
            'subtipo_cotizante_id' => $subtipo->id,

            'numero_documento' => $numero,
            'primer_nombre' => trim($row['primer_nombre']),
            'segundo_nombre' => trim($row['segundo_nombre'] ?? ''),
            'primer_apellido' => trim($row['primer_apellido']),
            'segundo_apellido' => trim($row['segundo_apellido'] ?? ''),

            'fecha_nacimiento' => $fecha,
            'sexo' => trim($row['sexo'] ?? ''),

            'correo' => trim($row['correo'] ?? ''),
            'telefono' => trim($row['telefono'] ?? ''),
            'direccion' => trim($row['direccion'] ?? ''),
            'ciudad' => trim($row['ciudad'] ?? ''),
            'observacion' => trim($row['observacion'] ?? ''),

            'estado' => true,
        ]);
    }
}