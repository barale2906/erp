<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usercontacto extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
   Schema::create('usercontacto', function (Blueprint $table) {
      $table->id();
      $table->date('fecha');
      $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->longText('direccion')->nullable();
      $table->longText('banco')->nullable();
      $table->longText('cuenta')->nullable();
      $table->longText('tipocuenta')->nullable();
      $table->string('telefono')->nullable(); 
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
