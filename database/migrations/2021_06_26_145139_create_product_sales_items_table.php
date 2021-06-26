<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sales_id')->unsigned();
            $table->foreign('sales_id')->references('id')->on('product_sales')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->float('big_unit_sales_price')->unsigned()->nullable();
            $table->float('small_unit_sales_price')->unsigned();
            $table->float('big_unit_cost_price')->unsigned()->nullable();
            $table->float('small_unit_cost_price')->unsigned();
            $table->integer('big_unit_qty')->nullable()->nullable();
            $table->integer('small_unit_qty');
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
        Schema::dropIfExists('product_sales_items');
    }
}
