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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pembeli tiket
            $table->string('order_code')->unique(); // Kode unik order (untuk Midtrans)
            $table->string('ticket_code')->unique()->nullable(); // Kode unik tiket (untuk QR & check-in)
            $table->integer('quantity');
            $table->decimal('total_price', 12, 2);
            $table->string('customer_name');
            $table->string('phone_number');
            $table->string('school');
            $table->string('level');
            $table->enum('status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->string('midtrans_token')->nullable(); // Snap Token Midtrans
            $table->timestamp('checked_in_at')->nullable(); // Waktu check-in
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
