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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('type');                     // food, beverages, households, etc..      
            $table->string('sub_type')->unique();       // fruits, meat, alcohol, seasonings, cleaning, medicine etc..
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamps();

            /** constraints */
            $table->index(['type', 'sub_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
