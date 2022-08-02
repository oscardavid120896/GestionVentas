<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupoProfesor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();

            $table->unsignedBigInteger('idGrupo')->unsigned();
            $table->foreign('idGrupo')->references('id')->on('grupo');

            $table->unsignedBigInteger('idMateria')->unsigned();
            $table->foreign('idMateria')->references('id')->on('materia');

            $table->unsignedBigInteger('idProfesor')->unsigned();
            $table->foreign('idProfesor')->references('idUsuario')->on('profesor');
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
        Schema::drop('grupoProfesor');
    }
};
