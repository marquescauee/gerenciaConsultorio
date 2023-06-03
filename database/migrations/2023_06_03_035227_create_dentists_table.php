<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentists', function (Blueprint $table) {
            $table->unsignedBigInteger("id");
            $table->unsignedBigInteger('speciality_id');
            $table->string("CRO");
            $table->string("password");
            $table->boolean("admin");
            $table->timestamps();

            $table->primary("id");
            $table->foreign('speciality_id')->references('id')->on('specialities');
            $table->foreign("id")->references("id")->on("pessoas");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dentists');
    }
}
