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
        Schema::table('users', function (Blueprint $table) {
            // Data Pribadi
            $table->string('nik', 16)->nullable()->unique();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('job')->nullable();

            // Data Perisai Diri
            $table->year('join_year')->nullable();
            $table->string('level')->nullable(); // Tingkatan (Dasar I, dll)

            // Relasi Unit (Atlet hanya punya 1 unit latihan utama)
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();

            // Status Verifikasi (Workflow Kunci)
            // incomplete: Baru daftar
            // pending: Sudah isi data, menunggu ACC pelatih
            // approved: Data valid, bisa daftar event
            // rejected: Data salah, harus diperbaiki
            $table->enum('verification_status', ['incomplete', 'pending', 'approved', 'rejected'])->default('incomplete');
            $table->text('rejection_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
