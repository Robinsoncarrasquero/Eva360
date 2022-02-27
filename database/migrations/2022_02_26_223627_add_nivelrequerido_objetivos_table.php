<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNivelrequeridoObjetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objetivos', function (Blueprint $table) {
            $table->integer('nivelrequerido')->default(0);
            $table->dropColumn(['requerido','submeta']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objetivos', function (Blueprint $table) {
            $table->string('submeta',1)->nullable();
            $table->float('requerido',5,2)->default(0);
            $table->dropColumn(['nivelrequerido']);
        });
    }
}
