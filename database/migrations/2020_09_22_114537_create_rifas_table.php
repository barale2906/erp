<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rifas', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->timestamps();
         $table->date('fecha')->nullable();
         $table->longText('premio');
         $table->integer('boletas')->nullable();
         $table->integer('numeros')->nullable();
         $table->string('responsable')->nullable();
         $table->double('valor')->nullable();
         $table->string('metodo')->nullable();
         $table->integer('estado')->default(1); // 1 proceso, 2 Activo, 3 Finalizado
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rifas');
    }
}
