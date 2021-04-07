<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantillas', function (Blueprint $table) {
            $table->id();
            $table->string('ubicacion',50)->notnullable();
            $table->string('name',50)->notnullable();
            $table->string('dni',50)->notnullable();
            $table->string('email')->notnullable();
            $table->string('email_super')->notnullable();
            $table->string('celular',20)->notnullable();
            $table->boolean('manager')->default(false);
            $table->string('cargo',50)->notnullable();
            $table->string('nivel_cargo',50)->notnullable();
            $table->foreignId('carga_masivas_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('plantillas');

    }
}
