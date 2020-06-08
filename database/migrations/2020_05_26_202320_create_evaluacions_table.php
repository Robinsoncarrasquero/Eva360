<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competencia_id')->constrained();
            $table->string('grado',1)->nullable();
            $table->unsignedDecimal('ponderacion',5,2);
            $table->unsignedDecimal('frecuencia',5,2);
            $table->foreignId('evaluador_id')->constrained("evaluadores");
            // $table->foreignId('evaluado_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('evaluacions');
    }
}
