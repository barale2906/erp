<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Facturacargos extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('facturacargos', function (Blueprint $table) {
         $table->id();
         $table->foreignId('factura_id')->references('id')->on('facturas');
         $table->foreignId('cargo_id')->references('id')->on('cargos');
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
