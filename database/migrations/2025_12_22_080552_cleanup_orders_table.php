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
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom ini karena sudah ada di table users
            $table->dropColumn(['customer_name', 'phone_number', 'school', 'level', 'nik', 'kk', 'birth_place', 'birth_date']);

            // Pastikan kolom ini ADA (Snapshot data saat pertandingan)
            // $table->integer('weight')->nullable();
            // $table->string('competition_class')->nullable(); // Kelas A, B, dll
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
