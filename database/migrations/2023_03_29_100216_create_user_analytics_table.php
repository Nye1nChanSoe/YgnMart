<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * TODO: Google Analytics or Mixpanel to track user activity and collect their behavior
     */
    public function up()
    {
        Schema::create('user_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('ip_address');
            $table->string('session_id');
            $table->timestamp('start_time');
            $table->timestamp('end_time');      // beforeunload, periodic AJAX, timeout
            $table->integer('page_views');
            $table->json('visited_pages');
            $table->string('device_type');
            $table->string('browser_type');
            $table->string('operating_system');
            $table->text('location');
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
        Schema::dropIfExists('user_analytics');
    }
};
