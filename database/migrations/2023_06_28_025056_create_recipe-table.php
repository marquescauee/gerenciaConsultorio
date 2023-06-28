<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_dentist");
            $table->unsignedBigInteger("id_patient");
            $table->longText("prescription");
            $table->timestamps();

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
        //
    }
}
