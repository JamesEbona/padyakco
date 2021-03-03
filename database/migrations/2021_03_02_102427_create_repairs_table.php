<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedDecimal('basic_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('expert_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('upgrade_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('caloocan_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('malabon_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('navotas_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('valenzuela_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('quezon_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('marikina_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('pasig_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('taguig_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('makati_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('manila_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('mandaluyong_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('sanjuan_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('pasay_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('paranaque_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('laspinas_fee', $precision = 8, $scale = 2);
            $table->unsignedDecimal('muntinlupa_fee', $precision = 8, $scale = 2);
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
        Schema::dropIfExists('table_repairs');
    }
}
