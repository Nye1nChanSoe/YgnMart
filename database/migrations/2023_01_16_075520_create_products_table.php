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
            $table->text('name')->notNullable();            // fresh organic watermelon
            $table->text('slug')->unique();
            $table->string('meta_type')->notNullable();     // watermelon
            $table->integer('price')->notNullable();
            $table->foreignId('measurement_id');
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
