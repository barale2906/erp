<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateCorrespondenciasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('correspondencias', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->timestamps();
         $table->foreignId('solicita')->references('id')->on('users');
         $table->foreignId('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
         $table->string('name');
         $table->foreignId('sucursal')->references('id')->on('sucursales');
         $table->string('nombresucursal');
         $table->foreignId('area')->references('id')->on('areas');
         $table->string('nombrearea');
         $table->foreignId('clase')->references('id')->on('tipo_envios')->nullable();
         $table->integer('destinatario')->nullable();
         $table->longText('nombredestinatario');
         $table->integer('sede')->nullable();
         $table->longText('nombresede');
         $table->integer('ubicacion')->nullable();
         $table->longText('nombreubicacion');
         $table->longText('horario')->nullable();
         $table->longText('descripcion');
         $table->longText('detalle');
         $table->timestamp('recepcion')->nullable();
         $table->unsignedBigInteger('recibe')->nullable();
         $table->longText('observaciones')->nullable();
         $table->unsignedBigInteger('planilla')->nullable();
         $table->double('cobrocliente')->nullable();
         $table->double('cobro')->nullable();
         $table->integer('estado')->default(1); // 1 creado, 2 dev 3 fuera 4 alertado 5 ruta 6 Cerrado 7 Entregado
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('correspondencias');
   }
}
