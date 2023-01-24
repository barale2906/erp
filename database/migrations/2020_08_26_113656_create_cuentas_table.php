<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cuentas', function (Blueprint $table) {
         $table->id();
         $table->timestamps();
         $table->bigInteger('genero');
         $table->bigInteger('numero')->nullable();
         $table->bigInteger('operador_id');
         $table->double('valor');
         $table->date('fecha');
         $table->longText('observaciones')->nullable();
         $table->date('fechapago')->nullable();
         $table->double('valorpagado')->nullable();
         $table->longText('observacionespago')->nullable();
         $table->bigInteger('estado')->default(1); // 1 En proceso 2 Finalizada, 3 Abonada, 4 Pagada, 5 Anulada
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('cuentas');
   }
}
