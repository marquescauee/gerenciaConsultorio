<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments_items', function (Blueprint $table) {
            $table->unsignedBigInteger("id_appointment");
            $table->unsignedBigInteger("id_product");
            $table->integer("quantity");
            $table->timestamps();

            $table->foreign("id_appointment")->references("id")->on("appointments");
            $table->foreign("id_product")->references("id")->on("products");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments_items');
    }
}
