<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResetPasswordTable extends Migration
{
    public function up()
    {
        Schema::create('reset_password', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_employe')->unsigned();
            $table->string('token');
            $table->timestamp('expiration');
            $table->timestamps();

            $table->foreign('id_employe')->references('id')->on('employes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reset_password');
    }
}
