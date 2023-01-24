<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiligenciasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('diligencias', function (Blueprint $table) {
         $table->id();
         $table->foreignId('usuario_id')->references('id')->on('users');
         $table->foreignId('empresa_id')->references('id')->on('empresas');
         $table->longText('recoge');
         $table->longText('entrega');
         $table->string('uen');
         $table->string('centro');
         $table->string('proyecto');
         $table->date('fecha');
         $table->longText('comentarios');
         $table->longText('observaciones');
         $table->integer('guias')->nullable();
         $table->integer('estado')->default(1); 
         // 1 creado, 2 asignado, 3 en proceso, 4 entregada destinatario, 5 ejecutada(cierro yo), 
         //6 cerrada(cierra cliente), 7 facturada-prepagada, 8 Diligencia Cancelada, 9 legalizada mensajero 
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
      Schema::dropIfExists('diligencias');
   }
}
