<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaObligacionTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('caja_obligacion', function (Blueprint $table) {
         $table->id();
         $table->foreignId('caja_id')->references('id')->on('cajas')->onDelete('cascade');
         $table->foreignId('obligacion_id')->references('id')->on('obligaciones')->onDelete('cascade');
         $table->double('valor');
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
      Schema::dropIfExists('caja_obligacion');
   }
}
