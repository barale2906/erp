<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObligacionesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('obligaciones', function (Blueprint $table) {
         $table->id();
         $table->string('nombre');
         $table->string('identificacion');
         $table->string('banco');
         $table->string('cuenta');
         $table->string('tipocuenta');
         $table->boolean('periodico')->default(false);
         $table->integer('tipo');
         $table->string('numerotipo')->nullable();
         $table->date('fecha');
         $table->double('pago');
         $table->double('pagorealizado')->nullable();
         $table->longText('observaciones')->nullable();
         $table->integer('estado')->default(1); // 1 Activo 2 Abonado 3 Pagado 4 Cancelado 5 Anulado
         $table->foreignId('user_id')->references('id')->on('users'); // usuario que registra.
         $table->string('soporte')->nullable();
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
      Schema::dropIfExists('obligaciones');
   }
}
