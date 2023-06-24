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
            $table->string("date");
            $table->string("start_time");
            $table->string("end_time");
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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(["id_dentist"]);
            $table->dropForeign(["id_patient"]);
            $table->dropForeign(["id_procedure"]);

            $table->dropColumn(["id_dentist"]);
            $table->dropColumn(["id_patient"]);
            $table->dropColumn(["id_procedure"]);
        });

        Schema::dropIfExists('appointments');
    }
}
