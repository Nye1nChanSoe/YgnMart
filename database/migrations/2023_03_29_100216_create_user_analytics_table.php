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
            $table->timestamp('end_time')->nullable();      // beforeunload, periodic AJAX, timeout
            $table->integer('page_views');
            $table->integer('unique_page_views');
            $table->json('visited_pages');
            $table->json('unique_visited_pages');
            $table->string('device_type');
            $table->string('device_name');
            $table->string('browser_type');
            $table->string('operating_system');
            $table->text('location')->nullable();       // TODO: use GeoIP2 
            $table->date('date')->default(now()->format('Y-m-d'));
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
