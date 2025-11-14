<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Relasi ke event (tiket ini milik acara mana)
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            $table->string('name'); // Nama tiket (e.g., "VIP", "Regular")
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0); // Harga tiket
            $table->integer('quantity'); // Kuota tiket

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};