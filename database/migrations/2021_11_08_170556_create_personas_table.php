<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 20);
            $table->string("primer_apellido", 50);
            $table->string("segundo_apellido", 50);
            $table->date("nacimiento");     //Formato yyyy-mm-dd
            $table->date("fallecimiento")->nullable();     //Formato yyyy-mm-dd

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
        Schema::dropIfExists('personas');
    }
}
