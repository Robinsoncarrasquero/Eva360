<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartamentoEvaluadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('evaluadores', function (Blueprint $table) {
            $table->foreignId('cargo_id')->nullable()->constrained();
            $table->foreignId('departamento_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('evaluadores', function (Blueprint $table) {
            $table->dropColumn(['cargo_id','departamento_id']);
        });

    }
}
