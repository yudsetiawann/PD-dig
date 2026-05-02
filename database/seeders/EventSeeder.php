<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan sudah ada user dengan ID 1 di database kamu
        $userId = 1;

        // 1. Contoh Event Ujian Kenaikan Tingkat (UKT)
        $titleUkt = 'Ujian Kenaikan Tingkat Wilayah Tasikmalaya 2026';
        Event::create([
            'user_id' => $userId,
            'title' => $titleUkt,
            'slug' => Str::slug($titleUkt),
            'description' => 'Ujian kenaikan tingkat untuk seluruh ranting Perisai Diri di wilayah Tasikmalaya.',
            'location' => 'Padepokan Perisai Diri, Tasikmalaya',
            'location_map_link' => 'https://maps.app.goo.gl/example',
            'ticket_price' => 0, // Harga diatur lewat dynamic pricing
            'event_type' => 'ujian',
            'has_dynamic_pricing' => true,
            'level_prices' => [
                'pemula_dasar1' => 50000,
                'dasar2' => 65000,
                'cakel' => 80000,
                'putih' => 100000,
                'putih_hijau' => 125000,
                'hijau' => 150000,
            ],
            'ticket_quota' => 200,
            'ticket_sold' => 0,
            'starts_at' => Carbon::now()->addDays(15),
            'ends_at' => Carbon::now()->addDays(16),
            'contact_person_name' => 'Admin PD-dig',
            'contact_person_phone' => '081234567890',
            'is_certificate_published' => false,
            'certificate_settings' => [
                'name_top_margin' => 300,
                'status_top_margin' => 450,
                'font_color' => '#000000',
            ],
        ]);

        // 2. Contoh Event Pertandingan
        $titleMatch = 'Perisai Diri Championship Tasikmalaya 2026';
        Event::create([
            'user_id' => $userId,
            'title' => $titleMatch,
            'slug' => Str::slug($titleMatch),
            'description' => 'Kejuaraan pencak silat antar ranting se-Kabupaten Tasikmalaya.',
            'location' => 'GOR Sukapura, Tasikmalaya',
            'location_map_link' => 'https://maps.app.goo.gl/example2',
            'ticket_price' => 0,
            'event_type' => 'pertandingan',
            'has_dynamic_pricing' => true,
            'level_prices' => [
                'tanding' => 150000,
                'tgr' => 125000,
                'serang_hindar' => 100000,
            ],
            'ticket_quota' => 500,
            'ticket_sold' => 0,
            'starts_at' => Carbon::now()->addMonths(2),
            'ends_at' => Carbon::now()->addMonths(2)->addDays(3),
            'contact_person_name' => 'Panitia Pelaksana',
            'contact_person_phone' => '08987654321',
            'is_certificate_published' => false,
        ]);
    }
}
