<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagodetacuenta extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('pagodetacuenta', function (Blueprint $table) {
         $table->id();
         $table->foreignId('cuenta_id')->references('id')->on('cuentas');
         $table->foreignId('pagope_id')->references('id')->on('pagoperador');
         $table->bigInteger('producto_id')->nullable(); // Registra el producto que se cargo de los servicios
         $table->double('cantidad');
         $table->double('vr_unitario');
         $table->double('vr_total');
         $table->integer('clase'); // 0 Cuenta de cobro, 1 nomina
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
