<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas', function(Blueprint $table) {
            $table->unsignedBigInteger('padre');
            $table->foreign('padre')->references('id')->on('cuentas');

            $table->unsignedBigInteger('madre');
            $table->foreign('madre')->references('id')->on('cuentas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema:table('personas', function(Blueprint $table) {
            $table->dropColumn(['padre', 'madre']);
        });
    }
}
