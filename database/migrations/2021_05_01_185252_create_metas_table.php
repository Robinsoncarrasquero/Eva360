<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->notnullable()->unique();
            $table->text('description',1000)->notnullable();
            $table->integer('nivelrequerido')->default(0);
            $table->foreignId('tipo_id')->constrained();
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
        Schema::dropIfExists('metas');
    }
}
