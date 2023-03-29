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
        Schema::create('product_user_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('user_id');                        
            $table->tinyInteger('view_count')->unsigned()->default(0);
            $table->tinyInteger('cart_count')->unsigned()->default(0);       
            $table->tinyInteger('order_count')->unsigned()->default(0);      
            $table->float('revenue')->default(0.0);                         
            $table->string('device_type')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();

            /** constraints */
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
        Schema::dropIfExists('product_user_analytics');
    }
};
