<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('facturas', function (Blueprint $table) {
         $table->id();
         $table->timestamps();
         $table->foreignId('genero')->references('id')->on('users');
         $table->integer('numero')->nullable();
         $table->foreignId('cliente_id')->references('id')->on('empresas');
         $table->foreignId('sucursal_id')->references('id')->on('sucursales');
         $table->double('valor');
         $table->double('impuesto');
         $table->date('fecha');
         $table->date('fechavence');
         $table->longText('observacionesfactura')->nullable();
         $table->date('fechapago')->nullable();
         $table->double('valorpagado')->nullable();
         $table->longText('observacionespago')->nullable();
         $table->integer('estado')->default(1); // 1 En proceso 2 Finalizada, 3 Abonada, 4 Pagada, 5 Anulada
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('facturas');
   }
}
