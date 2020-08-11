<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluadores', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->notnualble();
            $table->string('email',100)->notnualble();
            $table->string('relation',10)->notnualble();
            $table->boolean('status')->default(0);
            $table->rememberToken();
            $table->foreignId('evaluado_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained();
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
        Schema::dropIfExists('evaluadores');
    }
}
