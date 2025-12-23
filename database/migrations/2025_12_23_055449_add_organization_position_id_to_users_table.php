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
            Schema::table('users', function (Blueprint $table) {
                // Kolom ini nullable, karena User biasa (atlet) tidak punya jabatan
                $table->foreignId('organization_position_id')
                    ->nullable()
                    ->after('unit_id') // Letakkan setelah unit_id agar rapi
                    ->constrained('organization_positions')
                    ->nullOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_position_id']);
            $table->dropColumn('organization_position_id');
        });
    }
};
