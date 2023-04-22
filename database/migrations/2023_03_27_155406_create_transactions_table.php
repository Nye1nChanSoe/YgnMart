<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('order_id');
            $table->foreignId('vendor_id');
            $table->foreignId('user_id');
            $table->string('payment_type');
            $table->string('currency');
            $table->float('gross_amount');      // before tax - total payment amount
            $table->float('tax');
            $table->float('other_fees');
            $table->string('status');
            $table->timestamps();

            /** constraints */
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
};
