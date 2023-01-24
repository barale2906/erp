<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancierosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('financieros', function (Blueprint $table) {
         $table->id();
         $table->string('nombre');
         $table->string('tipo');
         $table->string('numero')->nullable();
         $table->integer('estado')->default(1); // 1 Activo 2 Inactivo 3 Cancelado
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
      Schema::dropIfExists('financieros');
   }
}
