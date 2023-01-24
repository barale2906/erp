<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagoesquema extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('pagoesquema', function (Blueprint $table) {
         $table->id();
         $table->string('esquema');
         $table->date('inicio');
         $table->date('fin');
         $table->foreignId('creo')->references('id')->on('users');
         $table->integer('estado')->default(1); // 1 Elaboración 2 Activo 3 Inactivo
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
