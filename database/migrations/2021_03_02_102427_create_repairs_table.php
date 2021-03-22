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

        DB::table('repairs')->insert(
            array(
                'basic_fee' => 0,
                'expert_fee' => 0,
                'upgrade_fee' => 0,
                'caloocan_fee' => 0,
                'malabon_fee' => 0,
                'navotas_fee' => 0,
                'valenzuela_fee' => 0,
                'quezon_fee' => 0,
                'marikina_fee' => 0,
                'pasig_fee' => 0,
                'taguig_fee' => 0,
                'makati_fee' => 0,
                'manila_fee' => 0,
                'mandaluyong_fee' => 0,
                'sanjuan_fee' => 0,
                'pasay_fee' => 0,
                'paranaque_fee' => 0,
                'laspinas_fee' => 0,
                'muntinlupa_fee' => 0,
            )
        );
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
