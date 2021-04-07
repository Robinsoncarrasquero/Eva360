<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldModeloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carga_masivas', function (Blueprint $table) {
            //
            $table->foreignId('modelo_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carga_masivas', function (Blueprint $table) {
            //
            $table->dropForeign(['modelo_id']);
            $table->dropColumn(['modelo_id']);
        });
    }
}
