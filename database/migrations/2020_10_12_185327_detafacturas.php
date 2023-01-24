<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Detafacturas extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('detafacturas', function (Blueprint $table) {
         $table->id();
         $table->integer('factura_id');
         $table->foreignId('producto_id')->references('id')->on('lppros');
         $table->foreignId('operador_id')->references('id')->on('users');
         $table->double('cantidad');
         $table->double('vr_unitario');
         $table->double('vr_impuesto');
         $table->double('vr_total');
         $table->integer('cuentacobro')->nullable();
         $table->integer('recorrido_id')->nullable();
         $table->integer('diligencia_id')->nullable();
         $table->integer('estado')->default(1); // 1 En proceso 2 Finalizada
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
