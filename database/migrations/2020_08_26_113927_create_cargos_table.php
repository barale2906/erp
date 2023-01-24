<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cargos', function (Blueprint $table) {
         $table->id();
         $table->timestamps();
         $table->string('cargo');
         $table->longText('descripcion');
         $table->integer('tipo'); // 1 Impuesto 2 Descuento
         $table->double('valor');
         $table->integer('factor'); // 1 porcentaje 2 numero
         $table->bigInteger('producto');
         $table->integer('idtributo')->nullable(); // identificador definido en el numeral 13.2.2 de herramientas DIAN
         $table->string('nombretributo')->nullable(); // Nombre del tributo según datos.
         $table->foreignId('creo')->references('id')->on('users');
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
      Schema::dropIfExists('cargos');
   }
}
