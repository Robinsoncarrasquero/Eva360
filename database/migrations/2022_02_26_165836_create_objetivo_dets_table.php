<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivoDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetivos_dets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objetivo_id')->constrained('objetivos')->cascadeOnDelete();
            $table->foreignId('submeta_id',1)->constrained('submetas');
            $table->string('valormeta',20)->nullable();
            $table->float('peso',5)->default(0);
            $table->float('cumplido',5)->default(0);
            $table->unique(['objetivo_id', 'submeta_id']);
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
        Schema::dropIfExists('objetivos_dets');
    }
}
