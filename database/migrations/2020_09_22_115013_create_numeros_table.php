<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumerosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('numeros', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->foreignId('idboleta')->references('id')->on('boletas');
      $table->integer('idrifa');
      $table->integer('numero');
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('numeros');
   }
}
