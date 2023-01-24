<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Extension\Table\Table;

class CreateCiudadesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('ciudades', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->timestamps();
         $table->string('ciudad', 150)->unique();
         $table->integer('codigociudad');
         $table->string('departamento');
         $table->integer('codigodepto');
         $table->boolean('estado')->default(1);
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('ciudades');
   }
}
