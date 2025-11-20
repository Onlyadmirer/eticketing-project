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
        Schema::create('events', function (Blueprint $table) {
        $table->id();
        // Relasi ke user (organizer) yang membuat event
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        $table->string('title');
        $table->text('description');
        $table->dateTime('start_time'); // Tanggal dan Waktu
        $table->string('location');
        $table->string('image')->nullable(); // Path gambar
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};