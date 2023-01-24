<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cajas', function (Blueprint $table) {
         $table->id();
         $table->string('movimiento');
         $table->string('tipo');
         $table->double('valor');
         $table->longText('descripcion')->nullable();
         $table->string('documento')->nullable();
         $table->string('imagen');
         $table->string('usuario')->nullable();
         $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade'); // Creo el movimiento
         $table->foreignId('financiero_id')->references('id')->on('financieros')->onDelete('cascade'); // Producto financiero
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
      Schema::dropIfExists('cajas');
   }
}
