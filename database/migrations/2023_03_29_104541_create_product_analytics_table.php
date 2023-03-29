<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** to store daily statistics  */
    public function up()
    {
        Schema::create('product_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->integer('view')->unsiged()->default(0);       
            $table->smallInteger('cart')->unsiged()->default(0);   // can handle 2 ^ 16 = 65536 counts for each product a day
            $table->smallInteger('checkout')->unsiged()->default(0);
            $table->smallInteger('order')->unsiged()->default(0);
            $table->smallInteger('review')->unsiged()->default(0);
            $table->date('date')->default(now()->format('Y-m-d'));
            $table->timestamps();

            /** constraints */
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_analytics');
    }
};
