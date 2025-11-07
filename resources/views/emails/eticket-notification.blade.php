<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket Anda</title>
</head>
<body style="font-family: sans-serif; color: #333;">
    <h2>Halo, {{ $order->customer_name }}!</h2>
    <p>Terima kasih telah melakukan pembayaran untuk acara <strong>{{ $order->event->title }}</strong>.</p>
    <p>E-Ticket Anda terlampir dalam email ini. Silakan tunjukkan QR Code pada e-ticket kepada panitia di lokasi acara untuk proses check-in.</p>
    <p>Sampai jumpa di lokasi acara!</p>
    <br>
    <p>Hormat kami,</p>
    <p><strong>Panitia {{ config('app.name', 'E-Ticketing') }}</strong></p>
</body>
</html>
