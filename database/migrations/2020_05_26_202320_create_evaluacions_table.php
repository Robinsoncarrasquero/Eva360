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
            $table->float('ponderacion',5,2)->default(0);
            $table->integer('frecuencia')->default(0);
            $table->float('resultado',5,2)->default(0);

            $table->foreignId('evaluador_id')->constrained("evaluadores");
            // $table->foreignId('evaluador_id')->constrained("evaluadores")->onDelete('cascade');
            $table->timestamps();
            $table->unique(['competencia_id', 'evaluador_id']);
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
