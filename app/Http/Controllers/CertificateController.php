<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function download(Order $order)
    {
        // 1. Validasi Keamanan
        if ((int)$order->user_id !== auth()->id()) {
            abort(403);
        }

        $event = $order->event;

        // Ambil media dari Spatie
        $mediaItem = $event->getFirstMedia('certificate_template');

        if (!$mediaItem || !$event->is_certificate_published) {
            return back()->with('error', 'Sertifikat belum tersedia.');
        }

        // 2. Setup Variable
        $statusText = $order->achievement ?? 'PESERTA';
        $settings = $event->certificate_settings ?? [];

        $marginTopName = $settings['name_top_margin'] ?? 300;
        $marginTopStatus = $settings['status_top_margin'] ?? 450;
        $fontColor = $settings['font_color'] ?? '#000000';

        // --- DEFINISIKAN ORIENTATION ---
        $orientation = $settings['orientation'] ?? 'landscape';

        // 3. Proses Gambar (Spatie Path)
        $path = $mediaItem->getPath();

        if (file_exists($path)) {
            $imageContent = file_get_contents($path);
            $backgroundImage = base64_encode($imageContent);
        } else {
            return back()->with('error', 'File template fisik tidak ditemukan.');
        }

        // 4. Load View
        $pdf = Pdf::loadView('pdf.certificate', [
            'order' => $order,
            'event' => $event,
            'statusText' => strtoupper($statusText),
            'marginTopName' => $marginTopName,
            'marginTopStatus' => $marginTopStatus,
            'fontColor' => $fontColor,
            'backgroundImage' => $backgroundImage,
            'orientation' => $orientation,
        ]);

        // Set paper di library DOMPDF juga agar konsisten
        $pdf->setPaper('a4', $orientation);

        return $pdf->stream('Sertifikat-' . $order->customer_name . '.pdf');
    }
}
