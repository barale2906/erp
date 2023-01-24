<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Extension\Table\Table;

class CreateUsersTable extends Migration
   {
      /**
       * Run the migrations.
       *
       * @return void
       */
      public function up()
      {
         Schema::create('users', function (Blueprint $table) {
               $table->bigIncrements('id');
               $table->timestamps();
               $table->string('username');
               $table->string('name');
               $table->string('password');
               $table->rememberToken();
               $table->string('email', 150)->unique();
               $table->timestamp('email_verified_at')->nullable();
               $table->bigInteger('empresa')->nullable();
               $table->string('foto')->default('../usuarios/default.jpg');
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
         Schema::dropIfExists('users');
      }
}
