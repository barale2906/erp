<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDilioperadorsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('dilioperadors', function (Blueprint $table) {
         $table->id();
         $table->foreignId('usuario_id')->references('id')->on('users');
         $table->foreignId('diligencia_id')->references('id')->on('diligencias');
         $table->integer('estado')->default(1); // 1 asignado, 2 ejecutado, 3 reasignado, 4 pagado, 5 Cancelado
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
      Schema::dropIfExists('dilioperadors');
   }
}
