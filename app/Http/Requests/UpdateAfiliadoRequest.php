<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAfiliadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $afiliadoId = $this->route('afiliado');

        return [
            'empresa_laboral_id' => 'required|exists:empresas_laborales,id',
            'asesor_id' => 'nullable|exists:asesores,id',
            'documento_id' => 'required|exists:documentos,id',
            'subtipo_cotizante_id' => 'required|exists:subtipo_cotizantes,id',

            'numero_documento' => [
                'required',
                'regex:/^[0-9]+$/',
                Rule::unique('afiliados')
                    ->ignore($afiliadoId)
                    ->where(function ($q) {
                        return $q->where('empresa_id', session('empresa_id'));
                    }),
            ],

            'primer_nombre' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|not_regex:/\d/',
            'segundo_nombre' => 'nullable|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|not_regex:/\d/',
            'primer_apellido' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|not_regex:/\d/',
            'segundo_apellido' => 'nullable|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|not_regex:/\d/',

            'fecha_nacimiento' => 'required|date',
            'sexo' => ['required', Rule::in(['M','F','Otro'])],

            // ✅ AQUÍ SE AGREGA
            'estado' => 'required|boolean',

            'correo' => 'nullable|email',
            'telefono' => 'nullable|regex:/^[0-9]+$/',

            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string',
            'observacion' => 'nullable|string',

            'google_drive_folder_id' => 'nullable|url|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'numero_documento.regex' => 'El documento solo puede contener números.',
            'numero_documento.unique' => 'Este documento ya está registrado en la empresa.',

            'primer_nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'primer_nombre.not_regex' => 'El nombre no puede contener números.',
            'segundo_nombre.regex' => 'El segundo nombre solo puede contener letras y espacios.',
            'segundo_nombre.not_regex' => 'El segundo nombre no puede contener números.',
            'primer_apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'primer_apellido.not_regex' => 'El apellido no puede contener números.',
            'segundo_apellido.regex' => 'El segundo apellido solo puede contener letras y espacios.',
            'segundo_apellido.not_regex' => 'El segundo apellido no puede contener números.',
        ];
    }
}