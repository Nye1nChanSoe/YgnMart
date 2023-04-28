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
            $table->bigInteger('view')->unsiged()->default(0);
            $table->integer('cart')->unsiged()->default(0);
            $table->integer('checkout')->unsiged()->default(0);
            $table->integer('order')->unsiged()->default(0);
            $table->integer('review')->unsiged()->default(0);
            $table->integer('quantity')->unsigned()->default(0);
            $table->double('revenue')->unsigned()->default(0);
            $table->date('date')->default(today('Asia/Yangon'));
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
