<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'event_id',
        'user_id',
        'order_code',
        'ticket_code',
        'quantity',
        'total_price',
        'customer_name',
        'phone_number',
        'school',
        'level',
        'competition_level',
        'category',
        'status',
        'midtrans_token',
        'checked_in_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi ke User (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Konfigurasi Spatie Media Library
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('etickets')->singleFile(); // Untuk file PDF e-ticket
    }
}
