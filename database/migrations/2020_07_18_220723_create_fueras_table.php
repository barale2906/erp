<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fueras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('guia');
            $table->foreignId('transportadora_id')->references('id')->on('transportadoras');
            $table->foreignId('correspondencia_id')->references('id')->on('correspondencias');
            $table->foreignId('empresa')->references('id')->on('empresas');
            $table->foreignId('envio')->references('id')->on('users');
            $table->integer('estado')->default(1); //1 construcción, 2 enviado, 3 entregado

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fueras');
    }
}
