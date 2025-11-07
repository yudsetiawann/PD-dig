<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>E-Ticket {{ $order->event->title }}</title>
  <style>
    /* Import Google Font 'Poppins' */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap');

    body {
      font-family: Arial, sans-serif;

      /* 1. Gunakan Flexbox */
      display: flex;

      /* 2. Pusatkan Vertikal */
      align-items: center;

      /* 3. Pusatkan Horizontal */
      justify-content: center;
    }

    .ticket-container {
      width: 700px;
      height: 280px;
      margin: 0 auto;
      background-color: #c4c4c4;
      /* Shadow yang lebih halus */
      box-shadow: 0 12px 28px -5px rgba(0, 0, 0, 0.1);
      border-radius: 16px;
      /* Mengganti border biru menjadi MERAH yang kuat */
      border-top: 20px solid #DC2626;
      /* Tailwind Red-600 */
      border: 1px solid #e5e7eb;
      display: table;
      table-layout: fixed;
      position: relative;
      overflow: hidden;
    }

    .logo-watermark {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 60%;
      height: 60%;
      opacity: 0.04;
      /* Sedikit lebih tipis agar tidak mengganggu */
      background-image: url('/img/Logo-PD.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center;
      z-index: 0;
    }

    .main-content {
      display: table-cell;
      width: 65%;
      padding: 25px 30px;
      vertical-align: top;
      position: relative;
      z-index: 1;
    }

    .stub {
      display: table-cell;
      width: 35%;
      padding: 20px;
      text-align: center;
      vertical-align: middle;
      /* Garis putus-putus dengan warna emas/coklat */
      border-left: 2px dashed #D97706;
      /* Tailwind Amber-600 */
      /* Latar belakang stub dengan warna kuning/krem sangat muda */
      background-color: #FEF9C3;
      /* Tailwind Yellow-100 */
      border-bottom-right-radius: 15px;
      z-index: 1;
    }

    .event-title {
      font-size: 28px;
      /* Font weight paling tebal untuk judul */
      font-weight: 900;
      color: #111827;
      margin: 0 0 8px 0;
      line-height: 1.2;
    }

    .attendee-name {
      font-size: 20px;
      font-weight: 600;
      /* Nama peserta menggunakan warna aksen merah */
      color: #DC2626;
      margin: 0 0 30px 0;
    }

    .detail-item {
      margin-bottom: 20px;
      display: table;
      width: 100%;
    }

    .detail-icon {
      display: table-cell;
      width: 30px;
      vertical-align: top;
      padding-top: 2px;
    }

    /* Mengubah warna icon SVG menjadi merah */
    .detail-icon svg {
      stroke: #DC2626;
    }

    .detail-text {
      display: table-cell;
      vertical-align: top;
    }

    .detail-item .label {
      font-size: 11px;
      /* Menggunakan font-weight 700 (bold) */
      font-weight: 700;
      text-transform: uppercase;
      color: #6b7280;
      letter-spacing: 0.5px;
      margin: 0 0 2px 0;
    }

    .detail-item .value {
      font-size: 16px;
      color: #1f2937;
      margin: 0;
      font-weight: 600;
      /* Sedikit lebih tebal */
    }

    .qr-code {
      margin-bottom: 12px;
    }

    .ticket-code {
      font-family: 'Courier New', Courier, monospace;
      font-weight: 700;
      /* Sedikit lebih tebal */
      font-size: 16px;
      letter-spacing: 1px;
      /* Latar belakang kode tiket dengan warna kuning cerah */
      background-color: #FDE047;
      /* Tailwind Yellow-400 */
      padding: 5px 10px;
      border-radius: 6px;
      display: inline-block;
      color: #1f2937;
    }

    .scan-text {
      font-size: 11px;
      margin-top: 8px;
      color: #6b7280;
    }

    .footer {
      position: absolute;
      bottom: 20px;
      left: 30px;
      font-size: 10px;
      color: #9ca3af;
    }
  </style>
</head>

<body>
  <div class="ticket-container">
    <div class="logo-watermark"></div>
    <div class="main-content">
      <h1 class="event-title">{{ $order->event->title }}</h1>
      <p class="attendee-name">{{ $order->customer_name }}</p>

      <div class="details-section">
        <div class="detail-item">
          <div class="detail-icon">
            <img
              src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2YjcyODAiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cmVjdCB4PSIzIiB5PSI0IiB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHJ4PSIyIiByeT0iMiI+PC9yZWN0PjxsaW5lIHgxPSIxNiIgeTE9IjIiIHgyPSIxNiIgeTI9IjYiPjwvbGluZT48bGluZSB4MT0iOCIgeTE9IjIiIHgyPSI4IiB5Mj0iNiI+PC9saW5lPjxsaW5lIHgxPSIzIiB5MT0iMTAiIHgyPSIyMSIgeTI9IjEwIj48L2xpbmU+PC9zdmc+"
              style="width: 20px; height: 20px;">
          </div>
          <div class="detail-text">
            <p class="label">Tanggal Acara</p>
            <p class="value">{{ $order->event->starts_at->format('l, d F Y') }}</p>
          </div>
        </div>
        <div class="detail-item">
          <div class="detail-icon">
            <img
              src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM2YjcyODAiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNMjEgMTBjMCA3LTkgMTMtOSAxM3MtOS02LTktMTNhOSA5IDAgMCAxIDE4IDB6Ij48L3BhdGg+PGNpcmNsZSBjeD0iMTIiIGN5PSIxMCIgcj0iMyI+PC9jaXJjbGU+PC9zdmc+"
              style="width: 20px; height: 20px;">
          </div>
          <div class="detail-text">
            <p class="label">Lokasi</p>
            <p class="value">{{ $order->event->location }}</p>
          </div>
        </div>
      </div>

      <p class="footer">E-Tick PD &copy; {{ date('Y') }}</p>
    </div>

    <div class="stub">
      <div class="qr-code">
        <img src="data:image/svg+xml;base64,{!! base64_encode(QrCode::format('svg')->size(140)->generate($order->ticket_code)) !!}">
      </div>
      <p class="ticket-code">{{ $order->ticket_code }}</p>
      <p class="scan-text">Pindai kode ini untuk Check-in</p>
    </div>
  </div>
</body>

</html>
