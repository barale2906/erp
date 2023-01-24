<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanillasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('planillas', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->timestamps();
         $table->date('fecha');
         $table->foreignId('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
         $table->foreignId('ruta_id')->references('id')->on('rutas')->onDelete('cascade');
         $table->unsignedBigInteger('operador')->nullable();
         $table->foreignId('asigno')->references('id')->on('users')->onDelete('cascade');
         $table->longText('observaciones')->nullable();
         $table->integer('estado')->default(1); //1 construcción, 2 recorrido, 3 cerrada
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('planillas');
   }
}
