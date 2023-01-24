<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateIncapacidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacidads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('usu_id');
            $table->unsignedBigInteger('registra_id');
            $table->longText('motivo');
            $table->date('inicia');
            $table->date('finaliza')->nullable();
            $table->double('valor')->nullable();
            $table->string('paga')->nullable();
            $table->date('fechaPago')->nullable();
            $table->longText('observacion')->nullable();
            $table->integer('estado')->default(1); // 1 activa 2 pendiente de pago 3 cerrada

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incapacidads');
    }
}
