<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('arl_afiliados', function (Blueprint $table) {
            $table->enum('tipo_base_cotizacion', ['SMMLV', 'FIJO'])->default('FIJO')->after('base_cotizacion')->comment('Tipo de base de cotización: SMMLV o FIJO');
            $table->unsignedBigInteger('parametro_anual_id')->nullable()->after('tipo_base_cotizacion')->comment('Referencia al parámetro anual');
            $table->foreign('parametro_anual_id')->references('id')->on('parametros_anuales')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arl_afiliados', function (Blueprint $table) {
            $table->dropForeign(['parametro_anual_id']);
            $table->dropColumn(['tipo_base_cotizacion', 'parametro_anual_id']);
        });
    }
};
