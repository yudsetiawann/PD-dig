<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ActivityArchive extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'date',
        'description',
        'link_google_drive',
        'link_instagram',
        'link_tiktok'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Konfigurasi Spatie: Hanya 1 file thumbnail
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile(); // Force replace jika upload baru
    }
}
