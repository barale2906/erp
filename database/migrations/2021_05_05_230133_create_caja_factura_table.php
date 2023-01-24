<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaFacturaTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('caja_factura', function (Blueprint $table) {
         $table->id();
         $table->foreignId('caja_id')->references('id')->on('cajas')->onDelete('cascade');
         $table->foreignId('factura_id')->references('id')->on('facturas')->onDelete('cascade');
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
      Schema::dropIfExists('caja_factura');
   }
}
