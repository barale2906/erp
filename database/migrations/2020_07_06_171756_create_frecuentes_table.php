<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrecuentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frecuentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->foreignId('sucursal')->references('id')->on('sucursales');
            $table->foreignId('area')->references('id')->on('areas');
            $table->string('destinatario');
            $table->longText('direccion');
            $table->longText('horario');
            $table->longText('ciudad');
            $table->longText('observaciones');
            $table->boolean('estado')->default(1); // 1 = Activo 2 = Inactivo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frecuentes');
    }
}
