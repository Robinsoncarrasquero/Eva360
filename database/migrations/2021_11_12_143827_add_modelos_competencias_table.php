<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelosCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modelos_competencias', function (Blueprint $table) {
            //
            $table->integer('nivelrequerido')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modelos_competencias', function (Blueprint $table) {
            //
            $table->dropColumn(['nivelrequerido']);
        });
    }
}
