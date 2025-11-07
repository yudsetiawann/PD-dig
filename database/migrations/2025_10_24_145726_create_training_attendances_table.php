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
        Schema::create('training_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
            $table->date('date'); // Tanggal absensi
            $table->boolean('is_present')->default(false); // Status hadir/tidak
            $table->timestamps(); // Waktu pencatatan

            // Hanya boleh ada satu catatan per atlet per tanggal
            $table->unique(['participant_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_attendances');
    }
};
