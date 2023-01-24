<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('empresas', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->timestamps();
         $table->bigInteger('nit')->unique(); // Establecer tipo de documento en un esquema de selección para crear el cliente
                                             // Ver página 443 de la caja de herramientas de la DIAN
         $table->string('nombre', 150)->unique();
         $table->longText('direccion')->nullable();
         $table->string('telefono')->nullable();
         $table->string('email')->nullable();
         $table->string('logo')->default('../logos/seyd.jpg');
         $table->string('tipo')->default('jurídico'); // persona Jurídica o natural
         $table->string('metodopago'); // Ver payments means code en caja de herramientas DIAN
         $table->string('contrabd')->nullable();
         $table->boolean('estado')->default(true);
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('empresas');
   }
}
