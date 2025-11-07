<x-app-layout title="Pembayaran Tiket">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
      Selesaikan Pembayaran
    </h1>
  </x-slot>

  <div class="mx-auto max-w-xl rounded-lg bg-white p-6 text-center shadow-sm dark:bg-gray-800">
    <h2 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Pembayaran Tiket: {{ $order->event->title }}
    </h2>
    <p class="mb-6 text-gray-600 dark:text-gray-400">Order ID: {{ $order->order_code }}</p>
    <p class="mb-8 text-3xl font-bold text-blue-600 dark:text-blue-400">
      Total Tagihan: Rp {{ number_format($order->total_price, 0, ',', '.') }}
    </p>
    <button id="pay-button"
      class="rounded-lg bg-green-600 px-8 py-3 text-lg font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
      Bayar Sekarang
    </button>
    <p class="mt-6 text-xs text-gray-500 dark:text-gray-400">Pembayaran aman didukung oleh Midtrans.</p>
  </div>

  {{-- Script Midtrans Snap --}}
  <script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>
  <script>
    document.getElementById('pay-button').addEventListener('click', function() {
      window.snap.pay('{{ $order->midtrans_token }}', {
        onSuccess: function(result) {
          alert('Pembayaran sukses! Anda akan diarahkan ke halaman tiket Anda.');
          window.location.href = '{{ route('my-tickets.index') }}';
        },
        onPending: function(result) {
          alert('Menunggu pembayaran Anda...');
          console.log(result);
          // Mungkin redirect ke my-tickets juga agar user tidak bingung
          // window.location.href = '{{ route('my-tickets.index') }}';
        },
        onError: function(result) {
          alert('Pembayaran gagal! Silakan coba lagi atau hubungi admin.');
          console.log(result);
          window.location.href = '{{ route('my-tickets.index') }}';
        }
      });
    });
  </script>
</x-app-layout>
