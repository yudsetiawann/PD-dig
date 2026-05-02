<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return $user->id === (int) $order->user_id;
    }

    public function pay(User $user, Order $order): bool
    {
        return $this->view($user, $order) && $order->status === 'pending';
    }

    public function downloadTicket(User $user, Order $order): bool
    {
        return $this->view($user, $order)
            && $order->status === 'paid'
            && $order->ticket_code !== null;
    }

    public function downloadCertificate(User $user, Order $order): bool
    {
        return $this->view($user, $order) && $order->status === 'paid';
    }
}
