<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnInInventoryChallan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_challans', function (Blueprint $table) {
            $table->bigInteger('available_big_unit_qty')->unsigned()->nullable();
            $table->bigInteger('available_small_unit_qty')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_challans', function (Blueprint $table) {
            $table->bigInteger('available_big_unit_qty')->unsigned()->nullable();
            $table->bigInteger('available_small_unit_qty')->unsigned();
        });
    }
}
