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
        Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pembeli
        $table->foreignId('ticket_id')->constrained()->onDelete('cascade'); // Tiket yang dibeli
        
        $table->string('booking_code')->unique(); // Kode unik tiket
        // Status: 'pending', 'approved', 'canceled'
        $table->enum('status', ['pending', 'approved', 'canceled'])->default('pending');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};