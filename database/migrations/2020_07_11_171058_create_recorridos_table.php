<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecorridosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
   Schema::create('recorridos', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->foreignId('correspondencia_id')->references('id')->on('correspondencias');
      $table->foreignId('operador')->references('id')->on('users');
      $table->integer('entregado')->nullable(); // 1 Entrego, 2 Devolución
      $table->integer('motivo')->nullable(); // Carga los motivos de devolución
      $table->integer('idfactura')->nullable(); // Muestra en que factura se registro el envío
      $table->integer('estado')->default(1); //1 ruta, 2 fuera de la ciudad, 3 entregado a otro operador 4 Cerrado
   });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('recorridos');
   }
}
