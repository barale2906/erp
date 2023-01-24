<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lpclies extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('lpclies', function (Blueprint $table) {
         $table->id();
         $table->foreignId('lp')->references('id')->on('lps');
         $table->foreignId('cliente')->references('id')->on('empresas');
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
