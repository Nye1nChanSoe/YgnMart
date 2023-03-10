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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('role');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->unique();
            $table->foreignId('address_id')->nullable();        // user can update their address later
            $table->timestamp('phone_verified_at')->nullable();
            // $table->boolean('is_active');
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();

            /** constraints */
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
