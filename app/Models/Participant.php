<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\ParticipantFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'school',
        'level',
    ];

    public function attendances()
    {
        return $this->hasMany(TrainingAttendance::class);
    }
}
