<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('asignaciones', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->timestamps();
         $table->unsignedBigInteger('planilla_id')->nullable();
         $table->foreignId('correspondencia_id')->references('id')->on('correspondencias')->onDelete('cascade');
         $table->Integer('orden')->nullable();
         $table->integer('estado')->default(1); //1 construcción, 2 recorrido, 3 No entregado 4 cerrada 5 Soportes entregados
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('asignaciones');
   }
}
