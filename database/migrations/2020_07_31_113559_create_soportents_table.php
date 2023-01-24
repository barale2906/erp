<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoportentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('soportents', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->timestamps();
         $table->foreignId('correspondencia_id')->references('id')->on('correspondencias');
         $table->foreignId('usuario')->references('id')->on('users');
         $table->longText('ruta');
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('soportents');
   }
}

//79693118 Esneyder Ríos Abril
