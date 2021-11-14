<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDomiciliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domicilios', function(Blueprint $table) {
            $table->bigInteger('codigo_postal')->nullable();    //REMOVE WHEN FINISHED : TESTING PURPOSES ONLY
            $table->foreign('codigo_postal')->references('cp')->on('cps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domicilios', function(Blueprint $table) {
            $table->dropForeign(['codigo_postal']);
            $table->dropColumn('codigo_postal');
        });
    }
}
