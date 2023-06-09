<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_products', function (Blueprint $table) {
            $table->unsignedBigInteger("id_supplier");
            $table->unsignedBigInteger("id_product");
            $table->timestamps();

            $table->foreign("id_supplier")->references("id")->on("suppliers");
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
        Schema::table('suppliers_products', function (Blueprint $table) {
            $table->dropForeign(["id_supplier"]);
            $table->dropForeign(["id_product"]);

            $table->dropColumn(["id_supplier"]);
            $table->dropColumn(["id_product"]);
        });
        Schema::dropIfExists('suppliers_products');
    }
}
