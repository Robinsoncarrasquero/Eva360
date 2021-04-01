<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('competencia',50)->notnullable()->unique();
            $table->text('feedback',1000)->nullable();
            $table->date('fb_finicio')->nullable();
            $table->date('fb_ffinal')->nullable();
            $table->set('fb_status', ['Cumplida', 'No_Cumplida']);
            $table->string('fb_nota',1000)->nullable();
            $table->string('unidades',4)->nullable();
            $table->foreignId('evaluado_id')->constrained();
            $table->foreignId('medida_id')->nullable()->constrained();
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

        Schema::dropIfExists('feedbacks');
    }
}
