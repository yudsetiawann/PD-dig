<?php

namespace App\Services;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key'); // Ambil dari config/services.php
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function createTransaction(array $params)
    {
        try {
            return Snap::createTransaction($params);
        } catch (Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage());
            throw new Exception("Gagal membuat transaksi Midtrans: " . $e->getMessage());
        }
    }
}
