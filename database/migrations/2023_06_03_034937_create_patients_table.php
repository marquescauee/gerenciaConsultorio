<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->unsignedBigInteger("id");
            $table->string("cpf");
            $table->unsignedBigInteger("id_prontuario");
            $table->timestamps();

            $table->primary("id");
            $table->foreign("id")->references("id")->on("pessoas");
            $table->foreign("id_prontuario")->references("id")->on("prontuarios");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
