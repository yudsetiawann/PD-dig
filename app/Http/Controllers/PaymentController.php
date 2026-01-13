<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat order miliknya dan statusnya pending
        if ((int)$order->user_id !== (int)auth()->id() || $order->status !== 'pending') {
            abort(403);
        }
        return view('payment', compact('order'));
    }
}
