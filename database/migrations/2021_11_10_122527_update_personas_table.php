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
            $table->unsignedBigInteger('domicilio');
            $table->foreign('domicilio')->references('id')->on('domicilios');

            $table->unsignedBigInteger('padre')->nullable();
            $table->foreign('padre')->references('id')->on('personas');

            $table->unsignedBigInteger('madre')->nullable();
            $table->foreign('madre')->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personas', function(Blueprint $table) {
            $table->dropForeign(['domicilio']);
            $table->dropForeign(['padre']);
            $table->dropForeign(['madre']);

            $table->dropColumn('domicilio');
            $table->dropColumn('padre');
            $table->dropColumn('madre');
        });
    }
}
