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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name');                   // fresh organic watermelon
            $table->string('slug')->unique();
            $table->string('meta_type');            // watermelon
            $table->integer('price');
            $table->foreignId('measurement_id')->nullable();
            $table->float('rating_point')->default(0.0);
            $table->text('description');
            $table->string('image')->nullable();   // will provide the default image at first 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
