<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remisiones', function (Blueprint $table) {
            $table->enum('novedad', ['Ingreso', 'Retiro'])->nullable()->after('total');
            $table->date('fecha_retiro')->nullable()->after('novedad');
        });
    }

    public function down(): void
    {
        Schema::table('remisiones', function (Blueprint $table) {
            $table->dropColumn(['novedad', 'fecha_retiro']);
        });
    }
};
