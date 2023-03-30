<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** 
     * This table currently have one to one relationship with the product table 
     * might scale up to one to many relationship in future and allows different 
     * vendors to have the same product with different stock amounts and price
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->foreignId('vendor_id');
            $table->integer('in_stock_quantity');
            $table->integer('minimum_quantity');
            $table->integer('available_quantity');
            $table->boolean('is_in_stock');
            $table->string('status');       // sell, close
            $table->timestamps();

            /** constraints */
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
