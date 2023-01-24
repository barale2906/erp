<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Inditiempo extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('inditiempos', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->timestamp('fecha');
         $table->timestamp('entrega')->nullable();
         $table->timestamp('recibe')->nullable();
         $table->bigInteger('correspondencia_id');
         $table->double('diferencia')->nullable();
         $table->double('diferem')->nullable();
         $table->integer('festivos')->nullable();
         $table->integer('motivo')->nullable();
         $table->bigInteger('factura')->nullable();
         $table->bigInteger('guia')->nullable();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      //
   }
}
