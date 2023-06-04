<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('event_id');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('attendee1_id');
            $table->unsignedBigInteger('attendee2_id');
            $table->timestamps();
    
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('attendee1_id')->references('id')->on('users');
            $table->foreign('attendee2_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
