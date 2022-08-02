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
        Schema::create('calificacion', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('calificacion');

            $table->unsignedBigInteger('idAlumno')->unsigned();
            $table->foreign('idAlumno')->references('idUsuario')->on('alumno');

            $table->unsignedBigInteger('idGrupoProfesor')->unsigned();
            $table->foreign('idGrupoProfesor')->references('id')->on('grupoProfesor');

            $table->unsignedBigInteger('idUnidad')->unsigned();
            $table->foreign('idUnidad')->references('id')->on('unidad');
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
        Schema::drop('calificacion');
    }
};
