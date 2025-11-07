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
            // Tandai jika event punya harga dinamis
            $table->boolean('has_dynamic_pricing')->default(false)->after('ticket_price');
            // Simpan struktur harga per tingkatan (JSON)
            $table->json('level_prices')->nullable()->after('has_dynamic_pricing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['has_dynamic_pricing', 'level_prices']);
        });
    }
};
