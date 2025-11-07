<x-app-layout title="Tiket Saya">
    <x-slot name="header">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
            Riwayat Tiket Saya
        </h1>
    </x-slot>

    {{-- Tampilkan pesan sukses jika ada (setelah batal order) --}}
    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4 dark:bg-green-900/30">
            <p class="text-sm font-medium text-green-700 dark:text-green-300">{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-4 px-5">
        @forelse ($orders as $order)
            <div class="flex flex-col items-start justify-between gap-4 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800 sm:flex-row sm:items-center">
                <div class="grow">
                    <h2 class="font-bold text-lg text-gray-900 dark:text-white">{{ $order->event->title }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Nama: {{ $order->customer_name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Tanggal Pesan: {{ $order->created_at->format('d M Y') }}</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
                <div class="flex shrink-0 items-center gap-4">
                    @if ($order->status === 'paid')
                        @if ($order->ticket_code)
                            <a href="{{ route('tickets.show', $order) }}" target="_blank" class="rounded-md bg-sky-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                                Lihat E-Ticket
                            </a>
                            <a href="{{ route('tickets.download', $order) }}" class="rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                                Download
                            </a>
                        @else
                            {{-- Jika status paid tapi kode tiket belum ada (jarang terjadi) --}}
                            <span class="rounded-md bg-gray-200 px-3 py-1.5 text-sm font-semibold text-gray-800 dark:bg-gray-700 dark:text-gray-300">Diproses</span>
                        @endif
                    @elseif ($order->status === 'pending')
                         {{-- Tombol Batalkan (pakai form karena method DELETE) --}}
                         <form action="{{ route('tickets.cancel', $order) }}" method="POST" onsubmit="return confirm('Anda yakin ingin membatalkan pesanan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700">
                                Batalkan
                            </button>
                        </form>
                        <a href="{{ route('orders.payment', $order) }}" class="rounded-md bg-green-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                            Bayar
                        </a>
                    @else {{-- Status failed atau expired --}}
                        <span class="rounded-md px-3 py-1.5 text-sm font-semibold
                                     {{ $order->status === 'failed' ? 'bg-red-200 text-red-800 dark:bg-red-700 dark:text-red-200' : 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
             <div class="rounded-lg border-2 border-dashed border-gray-300 p-12 text-center dark:border-gray-700">
                <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki riwayat pembelian tiket.</p>
            </div>
        @endforelse
    </div>

     {{-- Link Paginasi --}}
    <div class="mt-8">
        {{ $orders->links() }}
    </div>

</x-app-layout>
