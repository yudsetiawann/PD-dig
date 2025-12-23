<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
