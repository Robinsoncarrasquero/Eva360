<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutoevaluacionConfiguraciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            //
            $table->boolean('promediarautoevaluacion');
            $table->string('name',10)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            //
            $table->dropColumn(['promediarautoevaluacion','name']);
        });
    }
}
