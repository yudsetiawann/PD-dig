<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityArchive;
use Illuminate\Support\Facades\Auth;
use App\Models\Event; // Uncomment jika sudah ada Model Event

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // 1. Data Dummy Dokumentasi & Galeri
        $documentationArchives = [
            [
                'title' => 'Perisai Diri Cup XX 2025',
                'date' => '25 Desember 2025',
                'description' => 'Dokumentasi perolehan medali dan pertandingan atlit Perisai Diri pada kejuaraan silat Perisai Diri Cup XX 2025 se-kabupaten Tasikmalaya antar pelajar.',
                'thumbnail' => asset('img/pdcup-xx.jpeg'),
                'links' => [
                    'drive' => 'https://drive.google.com/drive/folders/1gixrqIJ_7IoFNCv2BEBhAbtzdbfCFYic',
                    'instagram' => 'https://instagram.com/',
                ],
            ],
            [
                'title' => 'Ujian Kenaikan Tingkat (UKT) 2024',
                'date' => '12 Desember 2024',
                'description' => 'Kegiatan UKT Semester Ganjil yang diikuti oleh 250 peserta dari seluruh ranting di Kabupaten Tasikmalaya.',
                'thumbnail' => asset('img/6.jpeg'),
                'links' => [
                    'drive' => 'https://drive.google.com/',
                    'instagram' => 'https://instagram.com/',
                    'tiktok' => 'https://tiktok.com/',
                ],
            ],
            [
                'title' => 'Latihan Gabungan Cabang',
                'date' => '15 Oktober 2024',
                'description' => 'Latihan bersama untuk mempererat silaturahmi dan penyamaan teknik antar unit latihan.',
                'thumbnail' => asset('img/3.jpeg'),
                'links' => [
                    'instagram' => 'https://instagram.com/',
                    'tiktok' => 'https://tiktok.com/',
                ],
            ],
        ];

        // 2. Data Galeri Bawah (PERBAIKAN DI SINI)
        // Kita ubah menjadi array of arrays agar punya key 'src' dan 'alt'
        $welcomeImages = [
            ['src' => 'img/6.jpeg', 'alt' => 'Latihan Silat 1'],
            ['src' => 'img/3.jpeg', 'alt' => 'Latihan Silat 2'],
            ['src' => 'img/pdcup-xix.jpeg', 'alt' => 'Kejuaraan PD Cup XIX'],
            ['src' => 'img/pdcup-xx(2).jpeg', 'alt' => 'Kejuaraan PD Cup XX'],
            ['src' => 'img/7.jpg', 'alt' => 'Kejuaraan PD Cup XIX'],
            ['src' => 'img/8.jpeg', 'alt' => 'Kejuaraan PD Cup XIX'],
            ['src' => 'img/5.jpeg', 'alt' => 'Kejuaraan PD Cup XVII'],
            ['src' => 'img/1.jpeg', 'alt' => 'Dokumentasi'],
        ];

        // 3. Data Event Terbaru (INI YANG DIUPDATE DARI CODE ANDA)
        // Kita pindahkan logic dari web.php ke sini:
        $latestEvents = Event::where('starts_at', '>=', now())
            ->orderBy('starts_at', 'asc')
            ->limit(3)
            ->get();

        // Query Baru: Dokumentasi
        $archives = ActivityArchive::query()
            ->with('media') // Eager load media agar tidak N+1 query
            ->orderBy('date', 'desc')
            ->limit(6) // Batasi tampilan di homepage (misal 6 terbaru)
            ->get();

        return view('welcome', compact('documentationArchives', 'welcomeImages', 'latestEvents', 'archives'));
    }
}
