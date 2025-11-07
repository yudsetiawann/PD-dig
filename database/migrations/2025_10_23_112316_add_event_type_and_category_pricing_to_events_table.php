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
            // Kolom untuk jenis event (ujian, pertandingan, dll.)
            $table->string('event_type')->default('ujian')->after('slug');
            // Ubah level_prices agar bisa menyimpan harga per kategori juga
            // Kita akan tetap menggunakan kolom JSON ini, tapi strukturnya berbeda tergantung event_type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('event_type');
        });
    }
};
