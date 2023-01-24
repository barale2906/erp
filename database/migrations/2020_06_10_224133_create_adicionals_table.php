<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdicionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adicionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->longText('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('sanguineo')->nullable();
            $table->date('nacimiento')->nullable();
            $table->date('ingreso')->nullable();
            $table->string('contrato')->default('OPS');
            $table->string('eps')->nullable();
            $table->string('pension')->nullable();
            $table->string('cesantia')->nullable();
            $table->boolean('conductor')->default(false);
            $table->string('runt')->nullable();
            $table->date('egreso')->nullable();
            $table->integer('estado')->default(1); // 1 es registrado, 2 es activo, 3 es inactivo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adicionals');
    }
}
