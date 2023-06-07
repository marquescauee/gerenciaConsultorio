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
        Schema::create('health_plans_patients', function (Blueprint $table) {
            $table->unsignedBigInteger("id_health_plan");
            $table->unsignedBigInteger("id_patient");
            $table->timestamps();

            $table->foreign("id_health_plan")->references("id")->on("health_plans");
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
        Schema::table('health_plans_patients', function (Blueprint $table) {
            $table->dropForeign(["id_health_plan"]);
            $table->dropForeign(["id_patient"]);

            $table->dropColumn(["id_health_plan"]);
            $table->dropColumn(["id_patient"]);
        });

        Schema::dropIfExists('health_plans_patients');
    }
}
