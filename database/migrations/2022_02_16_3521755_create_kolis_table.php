<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKolisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kolis', function (Blueprint $table) {
            $table->id();

            $table->integer('koli_length');
            $table->string('awb_url');
            $table->timestamps();
            $table->integer('koli_chargeable_weight');
            $table->integer('koli_width');
            $table->string('koli_surcharge')->nullable();
            $table->integer('koli_height');
            $table->string('koli_description');
            $table->string('koli_formula_id')->nullable();
            $table->string('connote_id');
            $table->integer('koli_volume');
            $table->integer('koli_weight');
            $table->string('koli_id');
            $table->string('awb_sicepat')->nullable();
            $table->integer('harga_barang')->nullable();
            $table->string('koli_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kolis');
    }
}
