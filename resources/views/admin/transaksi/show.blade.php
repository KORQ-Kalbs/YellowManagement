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
                @if($transaksi->status === 'completed')
                <button onclick="openReceiptModal()" class="inline-flex items-center px-4 py-2 font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Receipt
                </button>
                @endif
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
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $detail->product->nama_produk }}
                                        @if($detail->variant)
                                            <span class="text-xs font-normal text-yellow-600 dark:text-yellow-400">({{ $detail->variant->kode_variant }})</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $detail->product->kategori->nama_kategori }}</p>
                                    @if($detail->catatan)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 italic mt-0.5">{{ $detail->catatan }}</p>
                                    @endif
                                </div>
                            </x-table-cell>
                            <x-table-cell>
                                <span class="text-gray-900 dark:text-white">Rp {{ number_format($detail->subtotal / $detail->jumlah, 0, ',', '.') }}</span>
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
        <div class="flex justify-end space-x-3">
            @if($transaksi->status === 'pending')
                <form action="{{ route('admin.transaksi.selesai', $transaksi->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Complete Payment
                    </button>
                </form>
            @endif

            @if($transaksi->status === 'pending')
                <form action="{{ route('admin.transaksi.batalkan', $transaksi->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this transaction? Stock will be restored.')">
                    @csrf
                    @method('PATCH')
                    <x-danger-button type="submit">
                        Cancel Transaction
                    </x-danger-button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>


<!-- Receipt Modal -->
<div id="receiptModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeReceiptModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
            <!-- Receipt Content (Thermal Receipt Style) -->
            <div id="receiptContent" class="p-6 bg-white text-gray-900 font-mono text-sm border-t-8 border-gray-100 border-b-8 border-gray-100">
                <!-- Success Checkmark -->
                <div class="flex justify-center mb-3">
                    <div class="flex items-center justify-center bg-green-500 rounded-full print-bg-black" style="width: 40px; height: 40px;">
                        <svg class="text-white" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <!-- Shop Info -->
                <div class="text-center mb-4">
                    <h2 class="text-2xl font-bold uppercase tracking-wider mb-1">Yellow Drink</h2>
                    <p class="text-xs text-gray-600">Jl. Kasir Yellow No. 1, City</p>
                    <p class="text-xs text-gray-600">Telp: 0812-3456-7890</p>
                </div>

                <!-- Divider -->
                <div class="border-t-2 border-dashed border-gray-300 my-4"></div>

                <!-- Transaction Info -->
                <div class="text-xs text-gray-700 mb-4 space-y-1">
                    <div class="flex justify-between">
                        <span>No: {{ $transaksi->no_invoice }}</span>
                        <span>{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Kasir: {{ $transaksi->user->name }}</span>
                        <span class="uppercase">By: {{ $transaksi->pembayaran->metode_pembayaran ?? 'CASH' }}</span>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t-2 border-dashed border-gray-300 my-4"></div>

                <!-- Items -->
                <div class="mb-4">
                    @foreach($transaksi->details as $detail)
                    <div class="mb-3">
                        <div class="font-bold text-sm">{{ $detail->product->nama_produk }}@if($detail->variant) <span class="font-normal">({{ $detail->variant->kode_variant }})</span>@endif</div>
                        @if($detail->catatan)
                            <div class="text-xs text-gray-500 italic">{{ $detail->catatan }}</div>
                        @endif
                        <div class="flex justify-between text-xs text-gray-700 mt-1">
                            <span>{{ $detail->jumlah }} x {{ number_format($detail->subtotal / $detail->jumlah, 0, ',', '.') }}</span>
                            <span class="font-medium text-gray-900">{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Divider -->
                <div class="border-t-2 border-dashed border-gray-300 my-4"></div>

                <!-- Totals -->
                <div class="">
                    @php
                        $subtotalBruto = $transaksi->details->sum('subtotal');
                        $discountPct = $transaksi->discountEvent ? floatval($transaksi->discountEvent->discount_percentage) : 0;
                        $discountAmount = $subtotalBruto - $transaksi->total_harga;
                    @endphp
                    <div class="flex justify-between text-xs text-gray-700 mb-1">
                        <span>SUBTOTAL</span>
                        <span>Rp {{ number_format($subtotalBruto, 0, ',', '.') }}</span>
                    </div>
                    @if($discountPct > 0)
                    <div class="flex justify-between text-xs text-red-600 mb-2">
                        <span>DISKON ({{ number_format($discountPct, 0) }}%{{ $transaksi->discountEvent ? ' - '.$transaksi->discountEvent->name : '' }})</span>
                        <span>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-base font-bold mb-2 border-t border-gray-300 pt-2">
                        <span>TOTAL</span>
                        <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                    @if($transaksi->pembayaran)
                    <div class="flex justify-between text-sm text-gray-700 mb-2">
                        <span>TUNAI/BAYAR</span>
                        <span>Rp {{ number_format($transaksi->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold border-t border-gray-300 pt-2">
                        <span>KEMBALI</span>
                        <span>Rp {{ number_format($transaksi->pembayaran->jumlah_pembayaran - $transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>

                <!-- Divider -->
                <div class="border-t-2 border-dashed border-gray-300 my-4"></div>

                <!-- Footer -->
                <div class="text-center mt-6 text-xs text-gray-600">
                    <p class="font-bold mb-1">Terima Kasih Atas Kunjungan Anda!</p>
                    <p class="italic text-[10px]">Layanan Konsumen: @yellowdrink.id</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-3 gap-2 px-6 py-4 bg-gray-50 border-t">
                <button onclick="printReceipt()" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-gray-700 transition-colors bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-100">
                    🖨️ Cetak
                </button>
                <button onclick="window.location.href='{{ route('admin.transaksi.index') }}'" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-gray-700 transition-colors bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-100">
                    📋 Riwayat
                </button>
                <button onclick="closeReceiptModal()" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-white transition-colors bg-green-600 border border-green-600 rounded shadow-sm hover:bg-green-700">
                    ✅ Tutup
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
        const printWindow = window.open('', '_blank', 'width=400,height=600');
        
        printWindow.document.write(`
            <html>
            <head>
                <title>Struk Pembayaran - {{ $transaksi->no_invoice }}</title>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap');
                    @media print {
                        @page { margin: 0; }
                        body { margin: 0; padding: 5mm; }
                    }
                    body { 
                        font-family: 'Courier Prime', 'Courier New', Courier, monospace;
                        padding: 20px; 
                        max-width: 80mm; /* Standard thermal printer width */
                        margin: 0 auto; 
                        color: #000;
                        background: #fff;
                        line-height: 1.4;
                    }
                    * { box-sizing: border-box; }
                    
                    /* Core utility classes mapped to standard CSS */
                    .text-center { text-align: center; }
                    .flex { display: flex; }
                    .justify-between { justify-content: space-between; }
                    .items-center { align-items: center; }
                    .font-bold { font-weight: 700; }
                    .font-semibold { font-weight: 700; }
                    .font-medium { font-weight: 700; }
                    
                    .text-2xl { font-size: 1.5rem; line-height: 2rem; }
                    .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
                    .text-base { font-size: 1rem; line-height: 1.5rem; }
                    .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
                    .text-xs { font-size: 0.75rem; line-height: 1rem; }
                    .text-\\[10px\\] { font-size: 10px; }
                    
                    .uppercase { text-transform: uppercase; }
                    .italic { font-style: italic; }
                    .tracking-wider { letter-spacing: 0.05em; }
                    
                    .mb-1 { margin-bottom: 0.25rem; }
                    .mb-2 { margin-bottom: 0.5rem; }
                    .mb-3 { margin-bottom: 0.75rem; }
                    .mb-4 { margin-bottom: 1rem; }
                    .mt-1 { margin-top: 0.25rem; }
                    .mt-6 { margin-top: 1.5rem; }
                    .my-4 { margin-top: 1rem; margin-bottom: 1rem; }
                    .pt-2 { padding-top: 0.5rem; }
                    
                    /* Thermal simulation forces colors to black */
                    .text-gray-500, .text-gray-600, .text-gray-700, .text-gray-800, .text-gray-900 { color: #000; }
                    
                    .bg-green-500 { background-color: #000; }
                    .text-white { color: #fff; }
                    .rounded-full { border-radius: 50%; }
                    .w-10 { width: 40px; }
                    .h-10 { height: 40px; }
                    .w-6 { width: 24px; }
                    .h-6 { height: 24px; }
                    .justify-center { justify-content: center; }
                    
                    .border-t-2 { border-top: 2px solid #000; }
                    .border-t { border-top: 1px solid #000; }
                    .border-dashed { border-style: dashed; }
                    .border-gray-300 { border-color: #000; }
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
