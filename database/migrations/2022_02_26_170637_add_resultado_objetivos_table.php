<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResultadoObjetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objetivos', function (Blueprint $table) {
            $table->dropColumn(['cumplida','montoasignado','montocumplido','status']);
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
            $table->float('cumplida',5,2)->default(0);
            $table->float('montoasignado',12,2)->default(0);
            $table->float('montocumplido',12,2)->default(0);
            $table->set('status', ['Cumplida', 'No_Cumplida']);
        });
    }
}
