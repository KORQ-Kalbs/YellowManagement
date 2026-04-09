<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">Point of Sale (POS)</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl">
            
            @if(session('success'))
                <div class="p-4 mb-4 text-green-800 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-red-800 bg-red-100 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-4 text-red-800 bg-red-100 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kasir.transaksi.store') }}" method="POST" id="posForm">
                @csrf
                
                <div class="grid grid-cols-3 gap-4">
                    
                    <!-- LEFT: Product Selection -->
                    <div class="col-span-2 p-4 bg-white rounded shadow">
                        <h3 class="mb-4 text-lg font-bold">Pilih Produk</h3>
                        
                        <!-- Search & Filter -->
                        <div class="mb-4">
                            <input type="text" id="searchProduct" placeholder="Cari produk..." class="w-full p-2 border rounded">
                        </div>

                        <!-- Category Filter -->
                        <div class="flex gap-2 mb-4">
                            <button type="button" onclick="filterCategory('all')" class="px-3 py-1 text-sm bg-gray-200 rounded">Semua</button>
                            @foreach($kategoris as $kat)
                                <button type="button" onclick="filterCategory({{ $kat->id }})" class="px-3 py-1 text-sm bg-gray-200 rounded">
                                    {{ $kat->nama_kategori }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Products Grid -->
                        <div class="grid grid-cols-3 gap-3" id="productGrid">
                            @foreach($products as $product)
                                <div class="p-3 border rounded cursor-pointer product-item hover:bg-gray-50" 
                                     data-id="{{ $product->id }}"
                                     data-name="{{ $product->nama_produk }}"
                                     data-price="{{ $product->harga }}"
                                     data-stock="{{ $product->stok }}"
                                     data-category="{{ $product->kategori_id }}"
                                     onclick="addToCart(this)">
                                    <div class="font-semibold">{{ $product->nama_produk }}</div>
                                    <div class="text-sm text-gray-600">{{ $product->kategori->nama_kategori }}</div>
                                    <div class="text-sm font-bold text-green-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500">Stok: {{ $product->stok }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- RIGHT: Cart & Checkout -->
                    <div class="p-4 bg-white rounded shadow">
                        <h3 class="mb-4 text-lg font-bold">Keranjang</h3>

                        <div id="cartItems" class="mb-4 space-y-2">
                            <p class="text-sm text-gray-500">Belum ada item</p>
                        </div>

                        <div class="pt-4 border-t">
                            <div class="flex justify-between mb-2">
                                <span>Subtotal:</span>
                                <span id="subTotalAmount">Rp 0</span>
                            </div>

                            @if($discountEvents->count() > 0)
                            <div class="mb-4">
                                <label class="block mb-1 text-sm font-semibold">Event Diskon Aktif</label>
                                <select name="discount_event_id" id="discountEventId" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="renderCart()">
                                    <option value="">-- Tanpa Diskon --</option>
                                    @foreach($discountEvents as $event)
                                        <option value="{{ $event->id }}" data-percentage="{{ $event->discount_percentage }}">
                                            {{ $event->name }} (-{{ floatval($event->discount_percentage) }}%)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="flex justify-between mb-4 text-lg font-bold text-green-600">
                                <span>Total:</span>
                                <span id="totalAmount">Rp 0</span>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1 text-sm">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metodePembayaran" required class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="toggleJumlahBayar()">
                                    <option value="cash">Cash</option>
                                    <option value="qris">QRIS</option>
                                    <option value="debit">Debit Card</option>
                                    <option value="credit">Credit Card</option>
                                    <option value="transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="mb-4" id="divJumlahBayar">
                                <label class="block mb-1 text-sm">Jumlah Bayar (Tunai)</label>
                                <input type="number" name="jumlah_bayar" id="jumlahBayar" class="w-full p-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="" min="0" placeholder="Rp ">
                            </div>

                            <button type="submit" class="w-full p-3 font-bold text-white bg-green-600 rounded hover:bg-green-700">
                                Proses Transaksi
                            </button>

                            <button type="button" onclick="clearCart()" class="w-full p-2 mt-2 text-sm border rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                                Kosongkan Keranjang
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Hidden cart data -->
                <div id="cartData"></div>
            </form>
        </div>
    </div>

    <!-- Backend Pending Payment Modal -->
    @if(session('pending_transaksi'))
        @php
            $pendingTx = \App\Models\Transaksi::with('pembayaran')->find(session('pending_transaksi'));
        @endphp
        @if($pendingTx)
        <div id="pendingPaymentModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                <div class="relative inline-block w-full max-w-sm px-6 pt-5 pb-6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle dark:bg-gray-800">
                    <h3 class="mb-4 text-xl font-bold text-center text-gray-900 dark:text-white">
                        {{ $pendingTx->pembayaran->metode_pembayaran === 'qris' ? 'QRIS Payment' : 'Menunggu Pembayaran' }}
                    </h3>

                    @if($pendingTx->pembayaran->metode_pembayaran === 'qris')
                        <div class="text-center">
                            <div class="flex items-center justify-center p-4 mx-auto mb-3 bg-gray-100 border-2 border-gray-300 rounded shadow-sm w-52 h-52">
                                <svg class="w-40 h-40 text-gray-800" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h3v3h-3v-3zm-3 3h3v5h-3v-5zm3 3h3v2h-3v-2zm-3-8h5v2h-5v-2zM13 13h3v3h-3v-3zm0 5h3v3h-3v-3z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-blue-600">Scan QR Code ini untuk membayar</p>
                            <p class="mt-2 text-sm text-gray-800 dark:text-gray-300">Total Tagihan: <span class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($pendingTx->total_harga, 0, ',', '.') }}</span></p>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-3 bg-yellow-100 rounded-full">
                                <span class="text-2xl">⏳</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Menunggu penyelesaian transaksi oleh Kasir...</p>
                            <p class="mt-4 mb-2 text-lg font-bold text-gray-900 dark:text-white">Total Tagihan: <span>Rp {{ number_format($pendingTx->total_harga, 0, ',', '.') }}</span></p>
                        </div>
                    @endif

                    <div class="mt-6 space-y-3">
                        <form action="{{ route(auth()->user()->role === 'admin' ? 'admin.transaksi.selesai' : 'kasir.transaksi.selesai', $pendingTx->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            @if($pendingTx->pembayaran->metode_pembayaran === 'cash')
                                <div class="box-border p-3 mb-4 text-left border rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Pembayaran Diterima (Rp)</label>
                                    <input type="number" id="jumlah_bayar_diterima" name="jumlah_bayar_diterima" required value="{{ $pendingTx->pembayaran->jumlah_pembayaran }}" min="{{ $pendingTx->total_harga }}" class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring focus:border-blue-300" oninput="calculateKembalian(this.value, {{ $pendingTx->total_harga }})">
                                    
                                    <div class="flex justify-between mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        <span>Kembalian:</span>
                                        <span id="labelKembalian" class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format(max(0, $pendingTx->pembayaran->jumlah_pembayaran - $pendingTx->total_harga), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <script>
                                    function calculateKembalian(diterima, total) {
                                        let diff = diterima - total;
                                        if (diff < 0) diff = 0;
                                        document.getElementById('labelKembalian').textContent = 'Rp ' + diff.toLocaleString('id-ID');
                                    }
                                </script>
                            @endif

                            <button type="submit" class="w-full px-4 py-3 font-bold text-white bg-blue-600 rounded hover:bg-blue-700">
                                Selesaikan Transaksi
                            </button>
                        </form>
                        
                        <form action="{{ route(auth()->user()->role === 'admin' ? 'admin.transaksi.batalkan' : 'kasir.transaksi.batalkan', $pendingTx->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded hover:bg-gray-300" onsubmit="return confirm('Batalkan transaksi ini?');">
                                Batalkan Transaksi
                            </button>
                        </form>

                        <form action="{{ route(auth()->user()->role === 'admin' ? 'admin.transaksi.suspend' : 'kasir.transaksi.suspend', $pendingTx->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2 text-sm font-semibold text-yellow-700 bg-yellow-100 border border-yellow-300 rounded hover:bg-yellow-200">
                                🕐 Simpan Draft (Tunda)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif

    <script>
        let cart = [];

        function addToCart(element) {
            const productId = element.dataset.id;
            const productName = element.dataset.name;
            const productPrice = parseFloat(element.dataset.price);
            const productStock = parseInt(element.dataset.stock);

            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                if (existingItem.qty >= productStock) {
                    alert('Stok tidak mencukupi');
                    return;
                }
                existingItem.qty++;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    qty: 1,
                    stock: productStock
                });
            }

            renderCart();
        }

        function removeItem(productId) {
            cart = cart.filter(item => item.id !== productId);
            renderCart();
        }

        function updateQty(productId, change) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.qty += change;
                if (item.qty <= 0) {
                    removeItem(productId);
                } else if (item.qty > item.stock) {
                    alert('Stok tidak mencukupi');
                    item.qty = item.stock;
                }
                renderCart();
            }
        }

        function renderCart() {
            const cartItemsDiv = document.getElementById('cartItems');
            const cartDataDiv = document.getElementById('cartData');
            
            if (cart.length === 0) {
                cartItemsDiv.innerHTML = '<p class="text-sm text-gray-500">Belum ada item</p>';
                cartDataDiv.innerHTML = '';
                document.getElementById('subTotalAmount').textContent = 'Rp 0';
                document.getElementById('totalAmount').textContent = 'Rp 0';
                return;
            }

            let html = '';
            let subtotalCart = 0;
            let hiddenInputs = '';

            cart.forEach((item, index) => {
                const itemSubtotal = item.price * item.qty;
                subtotalCart += itemSubtotal;

                html += `
                    <div class="p-2 border rounded">
                        <div class="flex justify-between">
                            <div class="text-sm font-semibold">${item.name}</div>
                            <button type="button" onclick="removeItem('${item.id}')" class="text-red-600">×</button>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="updateQty('${item.id}', -1)" class="px-2 border rounded">-</button>
                                <span class="text-sm">${item.qty}</span>
                                <button type="button" onclick="updateQty('${item.id}', 1)" class="px-2 border rounded">+</button>
                            </div>
                            <div class="text-sm">Rp ${itemSubtotal.toLocaleString('id-ID')}</div>
                        </div>
                    </div>
                `;

                hiddenInputs += `
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][jumlah]" value="${item.qty}">
                `;
            });

            // Calculate Diskon
            const discountSelect = document.getElementById('discountEventId');
            let discountPercentage = 0;
            if (discountSelect && discountSelect.selectedIndex > 0) {
                const selectedOption = discountSelect.options[discountSelect.selectedIndex];
                discountPercentage = parseFloat(selectedOption.getAttribute('data-percentage')) || 0;
            }

            const discountAmount = (subtotalCart * discountPercentage) / 100;
            const finalTotal = subtotalCart - discountAmount;

            cartItemsDiv.innerHTML = html;
            cartDataDiv.innerHTML = hiddenInputs;
            document.getElementById('subTotalAmount').textContent = 'Rp ' + subtotalCart.toLocaleString('id-ID');
            document.getElementById('totalAmount').textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');
        }

        function clearCart() {
            if (confirm('Kosongkan keranjang?')) {
                cart = [];
                renderCart();
            }
        }

        function filterCategory(categoryId) {
            const items = document.querySelectorAll('.product-item');
            items.forEach(item => {
                if (categoryId === 'all' || item.dataset.category == categoryId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Search product
        document.getElementById('searchProduct').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.product-item');
            items.forEach(item => {
                const name = item.dataset.name.toLowerCase();
                if (name.includes(search)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        function toggleJumlahBayar() {
            const method = document.getElementById('metodePembayaran').value;
            const divJumlah = document.getElementById('divJumlahBayar');
            const inputJumlah = document.getElementById('jumlahBayar');
            
            if(method === 'cash') {
                divJumlah.style.display = 'block';
                inputJumlah.required = true;
                if(inputJumlah.value === '0') inputJumlah.value = '';
            } else {
                divJumlah.style.display = 'none';
                inputJumlah.required = false;
                inputJumlah.value = '0';
            }
        }

        // Initialize payment condition on load
        document.addEventListener('DOMContentLoaded', () => toggleJumlahBayar());
    </script>

    @if(session('show_receipt'))
        @php
            $transaksi = \App\Models\Transaksi::with(['details.product.kategori', 'pembayaran', 'user', 'discountEvent'])->find(session('show_receipt'));
            session()->forget('show_receipt');
        @endphp
        
        @if($transaksi)
        <!-- Receipt Modal - Auto Show -->
        <div id="receiptModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                <!-- Modal panel -->
                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                    <!-- Receipt Content (Thermal Receipt Style) -->
                    <div id="receiptContent" class="p-6 font-mono text-sm text-gray-900 bg-white border-t-8 border-b-8 border-gray-100">
                        <!-- Success Checkmark -->
                        <div class="flex justify-center mb-3">
                            <div class="flex items-center justify-center bg-green-500 rounded-full print-bg-black" style="width: 40px; height: 40px;">
                                <svg class="text-white" style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Shop Info -->
                        <div class="mb-4 text-center">
                            <h2 class="mb-1 text-2xl font-bold tracking-wider uppercase">Yellow Drink</h2>
                            <p class="text-xs text-gray-600">Jl. Kasir Yellow No. 1, City</p>
                            <p class="text-xs text-gray-600">Telp: 0812-3456-7890</p>
                        </div>

                        <!-- Divider -->
                        <div class="my-4 border-t-2 border-gray-300 border-dashed"></div>

                        <!-- Transaction Info -->
                        <div class="mb-4 space-y-1 text-xs text-gray-700">
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
                        <div class="my-4 border-t-2 border-gray-300 border-dashed"></div>

                        <!-- Items -->
                        <div class="mb-4">
                            @foreach($transaksi->details as $detail)
                            <div class="mb-3">
                                <div class="text-sm font-bold">{{ $detail->product->nama_produk }}</div>
                                <div class="flex justify-between mt-1 text-xs text-gray-700">
                                    <span>{{ $detail->jumlah }} x {{ number_format($detail->product->harga, 0, ',', '.') }}</span>
                                    <span class="font-medium text-gray-900">{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Divider -->
                        <div class="my-4 border-t-2 border-gray-300 border-dashed"></div>

                        <!-- Totals -->
                        <div class="">
                            @php
                                $subtotalBruto = $transaksi->details->sum('subtotal');
                                $discountPct = $transaksi->discountEvent ? floatval($transaksi->discountEvent->discount_percentage) : 0;
                                $discountAmount = $subtotalBruto - $transaksi->total_harga;
                            @endphp
                            <div class="flex justify-between mb-1 text-xs text-gray-700">
                                <span>SUBTOTAL</span>
                                <span>Rp {{ number_format($subtotalBruto, 0, ',', '.') }}</span>
                            </div>
                            @if($discountPct > 0)
                            <div class="flex justify-between mb-2 text-xs text-red-600">
                                <span>DISKON ({{ number_format($discountPct, 0) }}%{{ $transaksi->discountEvent ? ' - '.$transaksi->discountEvent->name : '' }})</span>
                                <span>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between pt-2 mb-2 text-base font-bold border-t border-gray-300">
                                <span>TOTAL</span>
                                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                            </div>
                            @if($transaksi->pembayaran)
                            <div class="flex justify-between mb-2 text-sm text-gray-700">
                                <span>TUNAI/BAYAR</span>
                                <span>Rp {{ number_format((float)$transaksi->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between pt-2 text-sm font-bold border-t border-gray-300">
                                <span>KEMBALI</span>
                                <span>Rp {{ number_format((float)($transaksi->pembayaran->jumlah_pembayaran - $transaksi->total_harga), 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Divider -->
                        <div class="my-4 border-t-2 border-gray-300 border-dashed"></div>

                        <!-- Footer -->
                        <div class="mt-6 text-xs text-center text-gray-600">
                            <p class="mb-1 font-bold">Terima Kasih Atas Kunjungan Anda!</p>
                            <p class="italic text-[10px]">Layanan Konsumen: @yellowdrink.id</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-3 gap-2 px-6 py-4 border-t bg-gray-50">
                        <button onclick="printReceipt()" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-gray-700 transition-colors bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-100">
                            🖨️ Cetak
                        </button>
                        <button onclick="window.location.href='{{ auth()->user()->role === 'admin' ? route('admin.transaksi.index') : route('kasir.transaksi.index') }}'" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-gray-700 transition-colors bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-100">
                            📋 Riwayat
                        </button>
                        <button onclick="closeReceiptModal()" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-white transition-colors bg-green-600 border border-green-600 rounded shadow-sm hover:bg-green-700">
                            ✅ Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
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
        @endif
    @endif
</x-app-layout>