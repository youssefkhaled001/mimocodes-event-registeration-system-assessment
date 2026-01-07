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
        Schema::create('registerations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('attendee_id')->constrained('attendees');
            $table->timestamp('registration_date');
            $table->enum('status', ['confirmed', 'waitlisted', 'cancelled']);
            $table->enum('payment_status', ['pending', 'paid', 'refunded']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registerations');
    }
};
