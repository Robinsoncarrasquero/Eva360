<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->default(true);
            $table->string('codigo',10)->nullable();
            $table->foreignId('cargo_id')->nullable()->constrained();
            $table->foreignId('departamento_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['cargo_id']);
            $table->dropForeign(['departamento_id']);
            $table->dropColumn(['active','codigo','cargo_id','departamento_id']);
        });

    }
}
