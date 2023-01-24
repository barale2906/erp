<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Facturazips extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('facturazips', function (Blueprint $table) {
         $table->id();
         $table->foreignId('factura_id')->references('id')->on('facturas');
         $table->foreignId('user_id')->references('id')->on('users');
         $table->longText('ruta')->nullable();
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
