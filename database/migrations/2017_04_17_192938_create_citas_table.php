<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estilista_id')->unsigned()->nullable();
            $table->foreign('estilista_id')->references('id')->on('estilistas');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('telefono');
            $table->string('email');
            $table->datetime('fecha_llegada');
            $table->datetime('fecha_salida');
            $table->boolean('confirmado');
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
        Schema::dropIfExists('citas');
    }
}
