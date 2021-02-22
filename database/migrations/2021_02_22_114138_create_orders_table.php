<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('quantity_total');
            $table->unsignedDecimal('sub_total', $precision = 8, $scale = 2);
            $table->unsignedDecimal('grand_total', $precision = 8, $scale = 2);
            $table->unsignedDecimal('shipping', $precision = 8, $scale = 2);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->string('phone_number');
            $table->string('status');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
