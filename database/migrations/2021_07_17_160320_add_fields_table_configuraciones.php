<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsTableConfiguraciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->string('manager',15)->null();
            $table->string('supervisor',15)->null();
            $table->string('supervisores',15)->null();
            $table->string('pares',15)->null();
            $table->string('subordinados',15)->null();
            $table->string('autoevaluacion',15)->null();
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
            $table->dropColumn(['manager','supervisor','supervisores','pares','subordinados','autoevaluacion']);
        });
    }
}
