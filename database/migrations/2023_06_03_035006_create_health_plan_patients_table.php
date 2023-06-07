<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthPlanPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('healthPlan_patients', function (Blueprint $table) {
            $table->unsignedBigInteger("id_healthPlan");
            $table->unsignedBigInteger("id_patient");
            $table->timestamps();

            $table->foreign("id_healthPlan")->references("id")->on("healthPlans");
            $table->foreign("id_patient")->references("id")->on("patients");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('healthPlan_patients', function (Blueprint $table) {
            $table->dropForeign(["id_healthPlan"]);
            $table->dropForeign(["id_patient"]);

            $table->dropColumn(["id_healthPlan"]);
            $table->dropColumn(["id_patient"]);
        });

        Schema::dropIfExists('healthPlan_patients');
    }
}
