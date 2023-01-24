<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('boletas', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->foreignId('idrifa')->references('id')->on('rifas');
      $table->string('comprador')->nullable();
      $table->string('direccion')->nullable();
      $table->string('email')->nullable();
      $table->string('telefono')->nullable();
      $table->foreignId('vendedor')->references('id')->on('users');
      $table->integer('estado')->default(1); // 1 En proceso 2 libre, 3 abonada, 4 Vendida, 5 Anulada
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('boletas');
   }
}
