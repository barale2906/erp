<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaPrestamosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('caja_prestamos', function (Blueprint $table) {
         $table->id();
         $table->double('valor');
         $table->foreignId('caja_id')->references('id')->on('cajas')->onDelete('cascade');
         $table->foreignId('prestamos_id')->references('id')->on('prestamos')->onDelete('cascade');
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
      Schema::dropIfExists('caja_prestamos');
   }
}
