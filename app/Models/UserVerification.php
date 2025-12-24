<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVerification extends Model
{
    // Pastikan fillable sesuai dengan struktur tabel
    protected $fillable = [
        'user_id',
        'verifier_id',
        'snapshot_data',
        'approved_at',
    ];

    // CASTING WAJIB: Agar JSON di database otomatis jadi Array di PHP
    protected $casts = [
        'snapshot_data' => 'array',
        'approved_at' => 'datetime',
    ];

    // Relasi ke User (Atlet)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Verifier (Pelatih)
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }
}
