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
        Schema::table('events', function (Blueprint $table) {
            // Menyimpan path file gambar sertifikat
            $table->string('certificate_template')->nullable();

            // Menyimpan konfigurasi posisi teks (JSON) agar fleksibel
            // Contoh: {"name_y": 300, "status_y": 400, "font_size": 24, "color": "#000000"}
            $table->json('certificate_settings')->nullable();

            // Apakah sertifikat sudah bisa didownload?
            $table->boolean('is_certificate_published')->default(false);
        });

        Schema::table('orders', function (Blueprint $table) {
            // Menyimpan prestasi. Default NULL (artinya Peserta Biasa)
            // Contoh isi: "JUARA 1 KELAS A", "PESERTA TERBAIK"
            $table->string('achievement')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
