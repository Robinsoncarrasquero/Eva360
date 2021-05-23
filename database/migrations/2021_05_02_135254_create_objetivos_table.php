<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meta_id')->constrained();
            $table->foreignId('evaluador_id')->constrained('evaluadores')->onDelete('cascade');;
            $table->unique(['meta_id', 'evaluador_id']);
            $table->foreignId('medida_id')->nullable()->constrained();
            $table->string('submeta',1)->nullable();
            $table->float('requerido',5,2)->default(0);
            $table->float('cumplida',5,2)->default(0);
            $table->float('resultado',5,2)->default(0);
            $table->float('montoasignado',12,2)->default(0);
            $table->float('montocumplido',12,2)->default(0);
            $table->set('status', ['Cumplida', 'No_Cumplida']);
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
        Schema::dropIfExists('objetivos');
    }
}
