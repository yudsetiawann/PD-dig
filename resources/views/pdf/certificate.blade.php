<!DOCTYPE html>
<html>

<head>
  <style>
    /* Mengatur ukuran kertas secara eksplisit via CSS */
    @page {
      margin: 0px;
      size: A4 {{ $orientation }};
    }

    body {
      margin: 0px;
      font-family: 'Helvetica', sans-serif;
      color: {{ $fontColor }};

      /* Pastikan body memenuhi halaman */
      width: 100%;
      height: 100%;
    }

    .background {
      position: absolute;
      top: 0;
      left: 0;
      /* Gunakan 100% agar responsif mengikuti orientasi kertas */
      width: 100%;
      height: 100%;
      z-index: -1;
      object-fit: cover;
      /* Agar gambar tidak gepeng */
    }

    .content-name {
      position: absolute;
      width: 100%;
      text-align: center;
      top: {{ $marginTopName }}px;
      font-size: 36px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .content-status {
      position: absolute;
      width: 100%;
      text-align: center;
      top: {{ $marginTopStatus }}px;
      font-size: 24px;
      font-weight: normal;
    }
  </style>
</head>

<body>
  <img src="data:image/jpg;base64,{{ $backgroundImage }}" class="background">

  <div class="content-name">
    {{ $order->customer_name }}
  </div>

  <div class="content-status">
    {{ $statusText }}
  </div>
</body>

</html>
