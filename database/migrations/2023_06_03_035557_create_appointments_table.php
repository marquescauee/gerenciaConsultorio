<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_procedure");
            $table->unsignedBigInteger("id_patient");
            $table->unsignedBigInteger("id_dentist");
            $table->string("name");
            $table->string("date");
            $table->timestamps();

            $table->foreign("id_procedure")->references("id")->on("procedures");
            $table->foreign("id_patient")->references("id")->on("patients");
            $table->foreign("id_dentist")->references("id")->on("dentists");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
