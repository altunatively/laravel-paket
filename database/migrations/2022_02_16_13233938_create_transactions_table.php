<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            $table->string('transaction_id');
            $table->string('customer_name');
            $table->string('customer_code');
            $table->string('transaction_amount');
            $table->string('transaction_discount')->default("0");
            $table->string('transaction_additional_field')->nullable();
            $table->string('transaction_payment_type');
            $table->string('transaction_state');
            $table->string('transaction_code');
            $table->integer('transaction_order');
            $table->string('location_id');
            $table->integer('organization_id');
            $table->timestamps();
            $table->string('transaction_payment_type_name');
            $table->integer('transaction_cash_amount');
            $table->integer('transaction_cash_change');

            $table->string('nama_sales');
            $table->string('top');
            $table->string('jenis_pelanggan');

            $table->string('connote_id');

            $table->string('origin_customer_name');
            $table->string('origin_customer_address');
            $table->string('origin_customer_email');
            $table->string('origin_customer_phone');
            $table->string('origin_customer_address_detail')->nullable();
            $table->string('origin_customer_zip_code');
            $table->string('origin_zone_code');
            $table->integer('origin_organization_id');
            $table->string('origin_location_id');

            $table->string('destination_customer_name');
            $table->string('destination_customer_address');
            $table->string('destination_customer_email')->nullable();
            $table->string('destination_customer_phone');
            $table->string('destination_customer_address_detail')->nullable();
            $table->string('destination_customer_zip_code');
            $table->string('destination_zone_code');
            $table->integer('destination_organization_id');
            $table->string('destination_location_id');
            
            $table->string('catatan_tambahan')->nullable();
            
            $table->string('location_name');
            $table->string('location_code');
            $table->string('location_type');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
