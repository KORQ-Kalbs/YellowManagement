<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Transaction Details
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Invoice: {{ $transaksi->no_invoice }}
                </p>
            </div>
            <a href="{{ route('admin.transaksi.index') }}" class="inline-flex items-center px-4 py-2 font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Transaction Info -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Transaction Details -->
            <x-card title="Transaction Information">
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Invoice No.</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $transaksi->no_invoice }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Date & Time</span>
                        <span class="text-gray-900 dark:text-white">{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Cashier</span>
                        <span class="text-gray-900 dark:text-white">{{ $transaksi->user->name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Status</span>
                        <div>
                            @if($transaksi->status === 'completed')
                                <x-badge type="completed">✓ Completed</x-badge>
                            @elseif($transaksi->status === 'pending')
                                <x-badge type="pending">⏳ Pending</x-badge>
                            @else
                                <x-badge type="cancelled">✕ Cancelled</x-badge>
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-lg font-bold text-gray-700 dark:text-gray-300">Total Price</span>
                        <span class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </x-card>

            <!-- Payment Details -->
            @if($transaksi->pembayaran)
                <x-card title="Payment Information">
                    <div class="space-y-4">
                        <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Payment Method</span>
                            <span class="font-semibold text-gray-900 dark:text-white uppercase">{{ $transaksi->pembayaran->metode_pembayaran }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Amount Paid</span>
                            <span class="text-gray-900 dark:text-white">Rp {{ number_format($transaksi->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-medium text-gray-700 dark:text-gray-300">Change</span>
                            <span class="font-semibold text-green-600 dark:text-green-400">Rp {{ number_format($transaksi->pembayaran->jumlah_pembayaran - $transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </x-card>
            @endif
        </div>

        <!-- Items List -->
        <x-card title="Item Details" noPadding="true">
            <x-table>
                <x-table-head>
                    <x-table-heading>Product</x-table-heading>
                    <x-table-heading>Unit Price</x-table-heading>
                    <x-table-heading>Quantity</x-table-heading>
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

        <!-- Actions -->
        @if($transaksi->status !== 'cancelled')
            <div class="flex justify-end space-x-3">
                <form action="{{ route('admin.transaksi.batalkan', $transaksi->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this transaction? Stock will be restored.')">
                    @csrf
                    @method('PATCH')
                    <x-danger-button type="submit">
                        Cancel Transaction
                    </x-danger-button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
