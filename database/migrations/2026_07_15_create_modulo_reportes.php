<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar módulo Reportes si no existe
        $modulo = \DB::table('modulos')->where('nombre', 'Reportes')->first();

        if (!$modulo) {
            \DB::table('modulos')->insert([
                'nombre' => 'Reportes',
                'descripcion' => 'Módulo de reportes e históricos de pagos',
                'icono' => 'chart-bar',
                'ruta' => 'reportes',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        \DB::table('modulos')->where('nombre', 'Reportes')->delete();
    }
};
