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
            <div class="flex gap-2">
                <button onclick="openReceiptModal()" class="inline-flex items-center px-4 py-2 font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Receipt
                </button>
                <a href="{{ route('admin.transaksi.index') }}" class="inline-flex items-center px-4 py-2 font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
            </div>
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


<!-- Receipt Modal -->
<div id="receiptModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeReceiptModal()"></div>

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
                <h2 class="mb-2 text-2xl font-bold text-center text-green-600 dark:text-green-400">Payment Successful!</h2>
                <p class="mb-6 text-sm text-center text-gray-600 dark:text-gray-400">Your order has been processed</p>

                <!-- Product Details -->
                @foreach($transaksi->details as $detail)
                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">Product</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $detail->product->nama_produk }}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-700 dark:text-gray-300">Category</span>
                        <span class="text-gray-900 dark:text-white">{{ $detail->product->kategori->nama_kategori }}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-700 dark:text-gray-300">Quantity</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $detail->jumlah }}x</span>
                    </div>
                </div>
                @endforeach

                <div class="flex justify-between pt-4 mb-6 border-t-2 border-gray-300 dark:border-gray-600">
                    <span class="font-semibold text-gray-800 dark:text-gray-200">Total Payment</span>
                    <span class="text-2xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>

                <!-- Transaction Info -->
                <div class="p-4 mb-6 bg-white rounded-lg dark:bg-gray-700">
                    <h3 class="mb-3 font-bold text-gray-900 dark:text-white">Transaction Information</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Transaction ID</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $transaksi->no_invoice }}</span>
                        </div>
                        @if($transaksi->pembayaran)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Payment Method</span>
                            <span class="font-semibold text-gray-900 dark:text-white uppercase">{{ $transaksi->pembayaran->metode_pembayaran }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Date</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $transaksi->tanggal_transaksi->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Cashier</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $transaksi->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Status</span>
                            <span class="font-semibold text-green-600 dark:text-green-400">Completed</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-3 gap-2 px-6 py-4 bg-gray-50 dark:bg-gray-800">
                <button onclick="printReceipt()" class="px-4 py-3 font-semibold text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
                    Print
                </button>
                <button onclick="window.location.href='{{ route('admin.transaksi.index') }}'" class="px-4 py-3 font-semibold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                    History
                </button>
                <button onclick="closeReceiptModal()" class="px-4 py-3 font-semibold text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                    Close
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
                <title>Receipt - {{ $transaksi->no_invoice }}</title>
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
