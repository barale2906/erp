<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagoesquedeta extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('pagoesquedeta', function (Blueprint $table) {
         $table->id();
         $table->foreignId('esquema_id')->references('id')->on('pagoesquema');
         $table->foreignId('pago_id')->references('id')->on('pagoperador');
         $table->double('valor');
         $table->foreignId('creo')->references('id')->on('users');
         $table->boolean('estado')->default(1); // 0 Inactivo, 1 Activo
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
