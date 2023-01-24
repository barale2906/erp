<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrepagosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('prepagos', function (Blueprint $table) {
         $table->id();
         $table->foreignId('empresa_id')->references('id')->on('empresas');
         $table->string('documento');
         $table->bigInteger('documento_id');
         $table->double('cantidad');
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
      Schema::dropIfExists('prepagos');
   }
}
