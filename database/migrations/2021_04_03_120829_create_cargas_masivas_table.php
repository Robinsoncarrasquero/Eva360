<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargasMasivasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_masivas', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->notnullable()->unique();
            $table->text('description',255)->nullable();
            $table->set('metodo', ['90', '180','360']);
            $table->boolean('procesado')->default(0);
            $table->string('file')->notnullable();
            $table->string('metodos',10)->nullable();
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
        Schema::dropIfExists('carga_masivas');
    }
}
