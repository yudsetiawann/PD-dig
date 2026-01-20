<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',
        'status',
        'published_at',
        'user_id'
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    // Konfigurasi Spatie: Single Cover Image
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile();
    }

    // Scope untuk Frontend: Hanya yang published dan tanggalnya sudah lewat/hari ini
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted(): void
    {
        static::creating(function ($post) {
            if (empty($post->user_id)) {
                $post->user_id = Auth::id();
            }
        });
    }
}
