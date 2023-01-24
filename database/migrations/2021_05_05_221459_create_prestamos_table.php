<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('prestamos', function (Blueprint $table) {
         $table->id();
         $table->longText('motivo');
         $table->integer('tipo')->default(1); // 1 Prestamo 2 Pago.
         $table->double('valor');
         $table->longText('observaciones')->nullable();
         $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade'); // usuario que solicita.
         $table->foreignId('caja_id')->references('id')->on('cajas')->onDelete('cascade'); // movimiento de caja.
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
      Schema::dropIfExists('prestamos');
   }
}
