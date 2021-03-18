<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreMonthlySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_monthly_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('month');
            $table->unsignedDecimal('profit', $precision = 8, $scale = 2);
            $table->boolean('after');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_monthly_sales');
    }
}
