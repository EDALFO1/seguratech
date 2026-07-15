<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AnalyzePagoSimpleTemplate extends Command
{
    protected $signature = 'pago-simple:analyze {template=ejemplo.xlsx}';
    protected $description = 'Analiza la estructura del template PAGO SIMPLE';

    public function handle()
    {
        $template = $this->argument('template');
        $path = storage_path("app/templates/{$template}");

        if (!file_exists($path)) {
            $this->error("Archivo no encontrado: {$path}");
            return 1;
        }

        $this->info("📊 Analizando: {$template}\n");

        try {
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();

            $this->line("📋 Información General:");
            $this->line("  Nombre hoja: " . $sheet->getTitle() . "\n");

            // Detectar filas de encabezado
            $this->line("📍 Primeras 5 filas (búsqueda de encabezados):\n");
            for ($row = 1; $row <= 5; $row++) {
                $this->line("Fila {$row}:");
                $rowData = [];
                for ($col = 'A'; $col <= 'CF'; $col++) {
                    $cell = $sheet->getCell("{$col}{$row}");
                    $value = $cell->getValue();
                    if (!empty($value)) {
                        $rowData[] = "{$col}: {$value}";
                    }
                }
                if (!empty($rowData)) {
                    $this->line("  " . implode(" | ", $rowData));
                } else {
                    $this->line("  (fila vacía)");
                }
                $this->line("");
            }

            // Mapeo de todas las columnas usadas
            $this->line("🗂️ Mapeo de Columnas Encabezados:\n");

            $cols = [];
            // Generar todas las columnas de A a CV
            for ($i = 0; $i < 100; $i++) {
                $cols[] = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
            }

            $this->line("COL | Fila 1 | Fila 2 | Fila 3");
            $this->line(str_repeat("-", 100));

            foreach ($cols as $col) {
                $val1 = $sheet->getCell("{$col}1")->getValue() ?? '';
                $val2 = $sheet->getCell("{$col}2")->getValue() ?? '';
                $val3 = $sheet->getCell("{$col}3")->getValue() ?? '';

                if (!empty($val1) || !empty($val2) || !empty($val3)) {
                    $this->line(sprintf(
                        "%s   | %-30s | %-30s | %-30s",
                        $col,
                        substr($val1, 0, 28),
                        substr($val2, 0, 28),
                        substr($val3, 0, 28)
                    ));
                }
            }

            // Detectar donde inician datos
            $this->line("\n\n📄 Fila 4 (primeros datos):");
            $rowData = [];
            for ($col = 'A'; $col <= 'CF'; $col++) {
                $value = $sheet->getCell("{$col}4")->getValue();
                if (!empty($value)) {
                    $rowData[] = "{$col}: {$value}";
                }
            }
            if (!empty($rowData)) {
                foreach ($rowData as $item) {
                    $this->line("  " . $item);
                }
            }

            $this->info("\n✅ Análisis completado. Usa esta información para mapear PagoSimpleExport.php");

        } catch (\Exception $e) {
            $this->error("Error al analizar: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
