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
        Schema::create('organization_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Jabatan (Ketua, Sekretaris, dll)
            $table->integer('order_level')->default(0); // Untuk sorting dropdown
            $table->boolean('is_active')->default(true); // Soft delete alternatif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_positions');
    }
};
