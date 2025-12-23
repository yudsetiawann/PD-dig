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
            // Tambahkan kolom biodata setelah kolom total_price (agar rapi)
            $table->string('customer_name')->after('total_price')->nullable();
            $table->string('phone_number')->after('customer_name')->nullable();
            $table->string('school')->after('phone_number')->nullable();
            $table->string('level')->after('school')->nullable(); // Sabuk (Dasar I, dsb)

            // Kolom spesifik (mungkin sudah ada weight, competition_level, dll di migrasi sebelumnya?)
            // Jika kolom weight, competition_level, category, class SUDAH ADA (berdasarkan info Anda),
            // maka JANGAN tambahkan lagi di sini. Cukup yang belum ada saja.

            // Kolom tambahan biodata
            $table->string('birth_place')->after('level')->nullable();
            $table->date('birth_date')->after('birth_place')->nullable();
            $table->string('nik', 16)->after('birth_date')->nullable();
            $table->string('kk', 16)->after('nik')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'phone_number',
                'school',
                'level',
                'birth_place',
                'birth_date',
                'nik',
                'kk'
            ]);
        });
    }
};
