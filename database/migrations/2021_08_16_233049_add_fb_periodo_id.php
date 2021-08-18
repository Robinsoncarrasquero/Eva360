<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFbPeriodoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropColumn(['fb_status']);
            $table->text('development',1000)->nullable();
            $table->foreignId('fbstatu_id')->nullable()->constrained();
            $table->foreignId('periodo_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropForeign(['periodo_id']);
            $table->dropColumn(['development','periodo_id']);
            $table->set('fb_status', ['Cumplida', 'No_Cumplida']);
        });
    }
}
