<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Devolucione extends Migration
{
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
         Schema::create('devoluciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('motivo');
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
         //
      }
}
