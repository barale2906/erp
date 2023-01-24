<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDotaentregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dotaentregas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('elemento_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('programa_id');
            $table->string('talla');
            $table->integer('cantidad');
            $table->date('fechaEntrega')->nullable();
            $table->string('carta')->nullable();
            $table->double('valor')->nullable();
            $table->integer('estado')->default('1'); // 1 generado 2 programado 3 entregado


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dotaentregas');
    }
}
