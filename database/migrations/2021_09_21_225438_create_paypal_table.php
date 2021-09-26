<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypals', function (Blueprint $table) {
            $table->id();
            $table->string('payid')->notnullable();
            $table->string('intent',20)->nullable();
            $table->string('state',20)->nullable();
            $table->string('name')->nullable();
            $table->double('total')->nullable();
            $table->string('currency',20)->nullable();
            $table->integer('unidades')->notnullable();
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
        Schema::dropIfExists('paypals');
    }
}
