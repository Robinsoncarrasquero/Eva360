<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submetas', function (Blueprint $table) {
            $table->id();
            $table->string('submeta',1);
            $table->text('description')->notnullable();
            $table->integer('requerido')->default(0);
            $table->foreignId('meta_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('submetas');
    }
}
