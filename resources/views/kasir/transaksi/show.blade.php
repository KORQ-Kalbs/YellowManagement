<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Detail Transaksi
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Invoice: {{ $transaksi->no_invoice }}
                </p>
            </div>
            <div class="flex gap-2">
                <button onclick="openReceiptModal()" class="inline-flex items-center px-4 py-2 font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Struk
                </button>
                <a href="{{ route('kasir.transaksi.index') }}" class="inline-flex items-center px-4 py-2 font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Transaction Info -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Transaction Details -->
            <x-card title="Informasi Transaksi">
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">No. Invoice</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $transaksi->no_invoice }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal & Waktu</span>
                        <span class="text-gray-900 dark:text-white">{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Kasir</span>
                        <span class="text-gray-900 dark:text-white">{{ $transaksi->user->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Status</span>
                        <div>
                                    @if($transaksi->status === 'completed')
                                        <x-badge type="completed">✓ Selesai</x-badge>
                                    @elseif($transaksi->status === 'pending')
                                        <x-badge type="pending">⏳ Menunggu</x-badge>
                                    @else
                                        <x-badge type="cancelled">✕ Dibatalkan</x-badge>
                                    @endif
                        </div>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-lg font-bold text-gray-700 dark:text-gray-300">Total Harga</span>
                        <span class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </x-card>

            <!-- Payment Details -->
            @if($transaksi->pembayaran)
                <x-card title="Informasi Pembayaran">
                    <div class="space-y-4">
                        <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Metode Pembayaran</span>
                            <span class="font-semibold text-gray-900 dark:text-white uppercase">{{ $transaksi->pembayaran->metode_pembayaran }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Jumlah Bayar</span>
                            <span class="text-gray-900 dark:text-white">Rp {{ number_format($transaksi->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Kembalian</span>
                            <span class="font-semibold text-green-600 dark:text-green-400">Rp {{ number_format($transaksi->pembayaran->jumlah_pembayaran - $transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </x-card>
            @endif
        </div>

        <!-- Items List -->
        <x-card title="Detail Item" noPadding="true">
            <x-table>
                <x-table-head>
                    <x-table-heading>Produk</x-table-heading>
                    <x-table-heading>Harga Satuan</x-table-heading>
                    <x-table-heading>Jumlah</x-table-heading>
                    <x-table-heading>Subtotal</x-table-heading>
                </x-table-head>
                <x-table-body>
                    @foreach($transaksi->details as $detail)
                        <x-table-row>
                            <x-table-cell>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $detail->product->nama_produk }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $detail->product->kategori->nama_kategori }}</p>
                                </div>
                            </x-table-cell>
                            <x-table-cell>
                                <span class="text-gray-900 dark:text-white">Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</span>
                            </x-table-cell>
                            <x-table-cell>
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-200">
                                    {{ $detail->jumlah }}x
                                </span>
                            </x-table-cell>
                            <x-table-cell>
                                <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </x-table-cell>
                        </x-table-row>
                    @endforeach
                </x-table-body>
            </x-table>
        </x-card>
    </div>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="fixed inset-0 z-50 hidden overflow-y-auto" x-data="{ show: false }">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false"></div>

            <!-- Modal panel -->
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <!-- Receipt Content -->
                <div id="receiptContent" class="px-6 py-8 bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-gray-800 dark:to-gray-900">
                    <!-- Success Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="flex items-center justify-center w-20 h-20 bg-green-500 rounded-full">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="mb-2 text-2xl font-bold text-center text-green-600 dark:text-green-400">Pembayaran Berhasil!</h2>
                    <p class="mb-6 text-sm text-center text-gray-600 dark:text-gray-400">Pesanan minuman Anda telah diproses</p>

                    <!-- Product Details -->
                    @foreach($transaksi->details as $detail)
                    <div class="mb-4">
                        <div class="flex justify-between mb-1">
                            <span class="font-semibold text-gray-800 dark:text-gray-200">Produk</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $detail->product->nama_produk }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700 dark:text-gray-300">Kategori</span>
                            <span class="text-gray-900 dark:text-white">{{ $detail->product->kategori->nama_kategori }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700 dark:text-gray-300">Ukuran</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $detail->jumlah }}x</span>
                        </div>
                    </div>
                    @endforeach

                    <div class="flex justify-between pt-4 mb-6 border-t-2 border-gray-300 dark:border-gray-600">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>

                    <!-- Transaction Info -->
                    <div class="p-4 mb-6 bg-white rounded-lg dark:bg-gray-700">
                        <h3 class="mb-3 font-bold text-gray-900 dark:text-white">Informasi Transaksi</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">ID Transaksi</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $transaksi->no_invoice }}</span>
                            </div>
                            @if($transaksi->pembayaran)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Metode Pembayaran</span>
                                <span class="font-semibold text-gray-900 dark:text-white uppercase">{{ $transaksi->pembayaran->metode_pembayaran }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tanggal</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $transaksi->tanggal_transaksi->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Status</span>
                                <span class="font-semibold text-green-600 dark:text-green-400">Completed</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notice -->
                    <div class="p-3 mb-6 bg-yellow-100 border border-yellow-300 rounded-lg dark:bg-yellow-900/30 dark:border-yellow-700">
                        <p class="text-sm text-center text-yellow-800 dark:text-yellow-200">
                            Minuman akan diproses dalam 5-10 menit. Silakan hubungi kasir jika belum diterima.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-3 gap-2 px-6 py-4 bg-gray-50 dark:bg-gray-800">
                    <button onclick="printReceipt()" class="px-4 py-3 font-semibold text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
                        Cetak Struk
                    </button>
                    <button onclick="window.location.href='{{ route('kasir.transaksi.index') }}'" class="px-4 py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                        Riwayat
                    </button>
                    <button onclick="window.location.href='{{ route('kasir.pos') }}'" class="px-4 py-3 font-semibold text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                        Pesan Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openReceiptModal() {
            document.getElementById('receiptModal').classList.remove('hidden');
        }

        function closeReceiptModal() {
            document.getElementById('receiptModal').classList.add('hidden');
        }

        function printReceipt() {
            const receiptContent = document.getElementById('receiptContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Struk Pembayaran - {{ $transaksi->no_invoice }}</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; max-width: 400px; margin: 0 auto; }
                        @media print {
                            body { padding: 0; }
                        }
                    </style>
                </head>
                <body>
                    ${receiptContent}
                    <script>
                        window.onload = function() {
                            window.print();
                            window.onafterprint = function() {
                                window.close();
                            }
                        }
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }

        // Close modal when clicking outside
        document.getElementById('receiptModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeReceiptModal();
            }
        });
    </script>
</x-app-layout>
