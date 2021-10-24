<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantillaparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantillapares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carga_masivas_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('email_par')->notnullable();
            $table->string('email_evaluado')->notnullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantillapares');
    }
}
