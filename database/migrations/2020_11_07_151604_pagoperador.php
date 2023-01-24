<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagoperador extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('pagoperador', function (Blueprint $table) {
         $table->id();
         $table->longText('cargo');
         $table->longText('descripcion');
         $table->longText('tipo');
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
