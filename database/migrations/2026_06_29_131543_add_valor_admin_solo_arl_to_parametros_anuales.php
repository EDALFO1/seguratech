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
        Schema::table('parametros_anuales', function (Blueprint $table) {
            $table->decimal('valor_admin_solo_arl', 10, 2)->nullable()->after('administracion')->comment('Valor administración para planes Solo ARL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parametros_anuales', function (Blueprint $table) {
            $table->dropColumn('valor_admin_solo_arl');
        });
    }
};
