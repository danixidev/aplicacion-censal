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
            $table->unsignedBigInteger('cp');
            $table->foreign('cp')->references('id')->on('cps');
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
            $table->dropForeign(['cp']);
            $table->dropColumn('cp');
        });
    }
}
