<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSalesItemChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales_item_challans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sales_item_id')->unsigned();
            $table->foreign('sales_item_id')->references('id')->on('product_sales_items')->onDelete('cascade');
            $table->bigInteger('inventory_challan_id')->unsigned();
            $table->foreign('inventory_challan_id')->references('id')->on('inventory_challans')->onDelete('cascade');
            $table->integer('big_unit_qty')->nullable();
            $table->integer('small_unit_qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sales_item_challans');
    }
}
