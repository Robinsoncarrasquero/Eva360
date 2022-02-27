<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValorSubmetaObjetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submetas', function (Blueprint $table) {
            $table->string('valormeta',20)->notnullable();
            $table->float('peso',5)->notnullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submetas', function (Blueprint $table) {
            $table->dropColumn(['valormeta','peso']);
        });
    }
}
