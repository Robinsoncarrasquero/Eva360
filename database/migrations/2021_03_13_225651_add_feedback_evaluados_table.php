<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeedbackEvaluadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluados', function (Blueprint $table) {
            //
            $table->text('feedback',1000)->nullable();
            $table->date('fb_finicio')->nullable();
            $table->date('fb_ffinal')->nullable();
            $table->set('fb_status', ['Cumplida', 'No_Cumplida']);
            $table->string('fb_nota',1000)->nullable();
            $table->string('unidades',4)->nullable();
            $table->foreignId('medida_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluados', function (Blueprint $table) {
            //
            $table->dropForeign(['medida_id']);
            $table->dropColumn(['feedback','fb_finicio','fb_ffinal','fb_status','fb_nota','unidades','medida_id']);

        });
    }
}
