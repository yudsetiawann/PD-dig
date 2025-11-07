<?php

namespace App\Models;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingAttendance extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingAttendanceFactory> */
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'date',
        'is_present',
    ];

    protected $casts = [
        'date' => 'date',
        'is_present' => 'boolean',
    ];

    // Relasi ke Participant
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
