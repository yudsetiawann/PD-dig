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
        Schema::create('activity_archives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->date('date'); // Tanggal kegiatan
            $table->text('description')->nullable();

            // Link Eksternal (Nullable sesuai request)
            $table->string('link_google_drive')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_tiktok')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_archives');
    }
};
