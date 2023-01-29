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
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('product_id');
            $table->timestamps();

            // $table->dateTime('created_at')->useCurrent();
            // $table->dateTime('updated_at')->useCurrent()->onUpdate('CURRENT_TIMESTAMP');

            /** constraints */
            /** each pair of category_id and product_id is unique and can't be duplicated */
            $table->unique(['category_id', 'product_id']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('category_product');
    }
};
