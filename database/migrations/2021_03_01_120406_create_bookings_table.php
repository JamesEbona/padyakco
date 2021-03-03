<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('mechanic_id')->nullable();
            $table->foreign('mechanic_id')->references('id')->on('users');
            $table->string('phone_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('repair_type');
            $table->string('location');
            $table->string('longhitude');
            $table->dateTime('booking_time', $precision = 0);
            $table->string('latitude');
            $table->string('notes')->nullable();
            $table->string('status');
            $table->unsignedDecimal('repair_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('transportation_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('additional_fee', $precision = 8, $scale = 2)->nullable();
            $table->unsignedDecimal('total_fee', $precision = 8, $scale = 2);
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
        Schema::dropIfExists('bookings');
    }
}
