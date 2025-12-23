<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom baru
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('level_id')->nullable()->after('join_year')->constrained('levels')->nullOnDelete();
        });

        // 2. Migrasi Data (Opsional: Mencoba mencocokkan string lama ke ID baru)
        // Logic: Ambil semua user yang punya level string, cari ID level-nya, update level_id
        $users = DB::table('users')->whereNotNull('level')->get();
        foreach ($users as $user) {
            $levelId = DB::table('levels')->where('name', $user->level)->value('id');
            if ($levelId) {
                DB::table('users')->where('id', $user->id)->update(['level_id' => $levelId]);
            }
        }

        // 3. Hapus kolom string lama
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('level')->nullable();
            $table->dropForeign(['level_id']);
            $table->dropColumn('level_id');
        });
    }
};
