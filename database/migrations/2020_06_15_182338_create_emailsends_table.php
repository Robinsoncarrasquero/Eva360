<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emailsends', function (Blueprint $table) {
            $table->id();
            $table->string('nameEvaluador',50)->notnualble();
            $table->string('email',100)->notnualble();
            $table->string('linkweb',100)->notnualble();
            $table->string('relation',15)->notnualble();
            $table->string('nameEvaluado',50)->notnualble();
            $table->boolean('enviado')->nullable()->default(false);
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
        Schema::dropIfExists('emailsends');
    }
}
