<?php

namespace App\Exports;

use App\Models\EmpresaLaboral;
use App\Models\Asesor;
use App\Models\Documento;
use App\Models\SubtipoCotizante;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\FromArray;

class AfiliadosTemplateExport implements WithHeadings, WithEvents, FromArray
{
    public function headings(): array
    {
        return [
            'empresa_laboral',
            'asesor',
            'tipo_documento',
            'subtipo_cotizante',
            'numero_documento',
            'primer_nombre',
            'segundo_nombre',
            'primer_apellido',
            'segundo_apellido',
            'fecha_nacimiento',
            'sexo',
            'correo',
            'telefono',
            'direccion',
            'ciudad'
        ];
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function($event) {

                $spreadsheet = $event->sheet->getDelegate()->getParent();
                $sheet = $event->sheet->getDelegate();

                $empresaId = session('empresa_id');

                // 🔥 SOLO DATOS DE LA EMPRESA ACTIVA
                $empresasLaborales = EmpresaLaboral::where('empresa_id', $empresaId)
                    ->pluck('nombre')
                    ->toArray();

                $asesores = Asesor::where('empresa_id', $empresaId)
                    ->pluck('nombre')
                    ->toArray();

                $documentos = Documento::pluck('nombre')->toArray();
                $subtipos = SubtipoCotizante::pluck('nombre')->toArray();
                $sexo = ['M','F','Otro'];

                // 🔹 HOJA OCULTA
                $listasSheet = new Worksheet($spreadsheet, 'Listas');
                $spreadsheet->addSheet($listasSheet);

                $fillColumn = function($col, $data) use ($listasSheet) {
                    foreach ($data as $i => $value) {
                        $listasSheet->setCellValue($col . ($i + 1), $value);
                    }
                };

                $fillColumn('A', $empresasLaborales);
                $fillColumn('B', $asesores);
                $fillColumn('C', $documentos);
                $fillColumn('D', $subtipos);
                $fillColumn('E', $sexo);

                $listasSheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);

                $setDropdown = function($column, $range) use ($sheet) {
                    for ($row = 2; $row <= 500; $row++) {
                        $validation = $sheet->getCell($column.$row)->getDataValidation();
                        $validation->setType(DataValidation::TYPE_LIST);
                        $validation->setAllowBlank(true);
                        $validation->setShowDropDown(true);
                        $validation->setFormula1($range);
                    }
                };

                // 🔥 NUEVO MAPEO (SIN EMPRESA)
                $setDropdown('A', '=Listas!$A$1:$A$'.count($empresasLaborales));
                $setDropdown('B', '=Listas!$B$1:$B$'.count($asesores));
                $setDropdown('C', '=Listas!$C$1:$C$'.count($documentos));
                $setDropdown('D', '=Listas!$D$1:$D$'.count($subtipos));
                $setDropdown('K', '=Listas!$E$1:$E$'.count($sexo)); // sexo
            }
        ];
    }
    public function array(): array
{
    return [
        [
            'Empresa Demo SAS',
            'Juan Pérez',
            'CC',
            'DEPENDIENTE',
            '123456789',
            'Carlos',
            'Andrés',
            'García',
            'López',
            '1990-05-15',
            'M',
            'correo@demo.com',
            '3001234567',
            'Calle 123 #45-67',
            'Cali'
        ]
    ];
}
}