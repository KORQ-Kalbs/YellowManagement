<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">Point of Sale (POS)</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl">

            @if(session('success'))
                <div class="p-4 mb-4 text-green-800 bg-green-100 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="p-4 mb-4 text-red-800 bg-red-100 rounded">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="p-4 mb-4 text-red-800 bg-red-100 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kasir.transaksi.store') }}" method="POST" id="posForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                    <!-- LEFT: Product Selection -->
                    <div class="lg:col-span-2 p-4 bg-white rounded shadow text-sm sm:text-base">
                        <h3 class="mb-4 text-lg font-bold">Pilih Produk</h3>
                        <div class="mb-4">
                            <input type="text" id="searchProduct" placeholder="Cari produk..." class="w-full p-2 border rounded">
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button type="button" onclick="filterCategory('all')" class="px-3 py-1 text-xs sm:text-sm bg-gray-200 rounded">Semua</button>
                            @foreach($kategoris as $kat)
                                <button type="button" onclick="filterCategory({{ $kat->id }})" class="px-3 py-1 text-xs sm:text-sm bg-gray-200 rounded">{{ $kat->nama_kategori }}</button>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3" id="productGrid">
                            @foreach($products as $product)
                                <div class="p-3 border rounded cursor-pointer product-item hover:bg-gray-50"
                                     data-id="{{ $product->id }}"
                                     data-name="{{ $product->nama_produk }}"
                                     data-price="{{ $product->harga }}"
                                     data-stock="{{ $product->stok }}"
                                     data-category="{{ $product->kategori_id }}"
                                     data-variants="{{ $product->variants->toJson() }}"
                                     onclick="addToCart(this)">
                                    <div class="font-semibold text-sm">{{ $product->nama_produk }}</div>
                                    <div class="text-xs text-gray-500">{{ $product->kategori->nama_kategori }}</div>
                                    <div class="text-sm font-bold text-green-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-400">Stok: {{ $product->stok }}</div>
                                    @if($product->variants->count())
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($product->variants as $v)
                                                <span class="px-1.5 py-0.5 text-[10px] bg-yellow-100 text-yellow-700 rounded font-semibold">{{ $v->kode_variant }}</span>
                                            @endforeach
                                        </div>
                                    @endif
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
                <div id="cartData"></div>
            </form>
        </div>
    </div>

    <!-- Backend Pending Payment Modal -->
    @if(session('pending_transaksi'))
        @php $pendingTx = \App\Models\Transaksi::with('pembayaran')->find(session('pending_transaksi')); @endphp
        @if($pendingTx)
        <div id="pendingPaymentModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                <div class="relative inline-block w-full max-w-sm px-6 pt-5 pb-6 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle dark:bg-gray-800">
                    <h3 id="pendingModalTitle" class="mb-4 text-xl font-bold text-center text-gray-900 dark:text-white">
                        Menunggu Pembayaran
                    </h3>

                    <!-- Payment Method Switcher -->
                    <div class="mb-4">
                        <label class="block mb-1.5 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Metode Pembayaran</label>
                        <select id="pendingMetodePembayaran" onchange="switchPendingPaymentMethod(this.value)"
                            class="w-full px-3 py-2.5 text-sm font-medium border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-colors">
                            <option value="cash" {{ $pendingTx->pembayaran->metode_pembayaran === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="qris" {{ $pendingTx->pembayaran->metode_pembayaran === 'qris' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>

                    <!-- Dynamic Payment Content -->
                    <!-- CASH view -->
                    <div id="pendingView-cash" class="pending-payment-view hidden">
                        <div class="text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-3 bg-green-100 rounded-full dark:bg-green-900/30">
                                <span class="text-3xl">💵</span>
                            </div>
                            <p class="mt-2 text-lg font-bold text-gray-900 dark:text-white">Total: <span>Rp {{ number_format($pendingTx->total_harga, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <!-- QRIS view -->
                    <div id="pendingView-qris" class="pending-payment-view hidden">
                        <div class="text-center">
                            <div class="flex items-center justify-center p-4 mx-auto mb-3 bg-gray-100 border-2 border-gray-300 rounded shadow-sm w-52 h-52">
                                <svg class="w-40 h-40 text-gray-800" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h3v3h-3v-3zm-3 3h3v5h-3v-5zm3 3h3v2h-3v-2zm-3-8h5v2h-5v-2zM13 13h3v3h-3v-3zm0 5h3v3h-3v-3z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-blue-600">Scan QR Code ini untuk membayar</p>
                            <p class="mt-2 text-sm text-gray-800 dark:text-gray-300">Total Tagihan: <span class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($pendingTx->total_harga, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <!-- DEBIT / CREDIT / TRANSFER view -->
                    <div id="pendingView-other" class="pending-payment-view hidden">
                        <div class="text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-3 bg-blue-100 rounded-full dark:bg-blue-900/30">
                                <span class="text-3xl" id="pendingOtherIcon">💳</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400" id="pendingOtherLabel">Menunggu pembayaran via kartu...</p>
                            <p class="mt-4 mb-2 text-lg font-bold text-gray-900 dark:text-white">Total: <span>Rp {{ number_format($pendingTx->total_harga, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="mt-6 space-y-3">
                        <form action="{{ route(auth()->user()->role === 'admin' ? 'admin.transaksi.selesai' : 'kasir.transaksi.selesai', $pendingTx->id) }}" method="POST" id="pendingSelesaiForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="metode_pembayaran_baru" id="inputMetodeBaru" value="{{ $pendingTx->pembayaran->metode_pembayaran }}">

                            <!-- Cash-specific fields -->
                            <div id="pendingCashFields" class="hidden">
                                <div class="box-border p-3 mb-4 text-left border rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <label class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Pembayaran Diterima (Rp)</label>
                                    <input type="number" id="jumlah_bayar_diterima" name="jumlah_bayar_diterima"
                                        value="{{ $pendingTx->pembayaran->jumlah_pembayaran }}"
                                        min="{{ $pendingTx->total_harga }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring focus:border-blue-300"
                                        oninput="calculateKembalian(this.value, {{ $pendingTx->total_harga }})">
                                    <div class="flex justify-between mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        <span>Kembalian:</span>
                                        <span id="labelKembalian" class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format(max(0, $pendingTx->pembayaran->jumlah_pembayaran - $pendingTx->total_harga), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full px-4 py-3 font-bold text-white bg-blue-600 rounded hover:bg-blue-700">
                                Selesaikan Transaksi
                            </button>
                        </form>
                        <form action="{{ route(auth()->user()->role === 'admin' ? 'admin.transaksi.batalkan' : 'kasir.transaksi.batalkan', $pendingTx->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                Batalkan Transaksi
                            </button>
                        </form>
                        <form action="{{ route(auth()->user()->role === 'admin' ? 'admin.transaksi.suspend' : 'kasir.transaksi.suspend', $pendingTx->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2 text-sm font-semibold text-yellow-700 bg-yellow-100 border border-yellow-300 rounded hover:bg-yellow-200">
                                Simpan Draft (Tunda)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function switchPendingPaymentMethod(method) {
                // Update hidden input
                document.getElementById('inputMetodeBaru').value = method;

                // Hide all views
                document.querySelectorAll('.pending-payment-view').forEach(el => el.classList.add('hidden'));

                // Show relevant view
                if (method === 'cash') {
                    document.getElementById('pendingView-cash').classList.remove('hidden');
                    document.getElementById('pendingCashFields').classList.remove('hidden');
                    document.getElementById('pendingModalTitle').textContent = 'Pembayaran Cash';
                    const inp = document.getElementById('jumlah_bayar_diterima');
                    inp.required = true;
                } else if (method === 'qris') {
                    document.getElementById('pendingView-qris').classList.remove('hidden');
                    document.getElementById('pendingCashFields').classList.add('hidden');
                    document.getElementById('pendingModalTitle').textContent = 'QRIS Payment';
                    document.getElementById('jumlah_bayar_diterima').required = false;
                } else {
                    document.getElementById('pendingView-other').classList.remove('hidden');
                    document.getElementById('pendingCashFields').classList.add('hidden');
                    document.getElementById('jumlah_bayar_diterima').required = false;

                    const labels = {
                        debit:    { icon: '💳', text: 'Menunggu pembayaran via Debit Card...',    title: 'Debit Card Payment' },
                        credit:   { icon: '💳', text: 'Menunggu pembayaran via Credit Card...',   title: 'Credit Card Payment' },
                        transfer: { icon: '🏦', text: 'Menunggu konfirmasi Bank Transfer...',     title: 'Bank Transfer' },
                    };
                    const info = labels[method] || labels.debit;
                    document.getElementById('pendingOtherIcon').textContent  = info.icon;
                    document.getElementById('pendingOtherLabel').textContent = info.text;
                    document.getElementById('pendingModalTitle').textContent = info.title;
                }
            }

            function calculateKembalian(diterima, total) {
                let diff = diterima - total;
                if (diff < 0) diff = 0;
                document.getElementById('labelKembalian').textContent = 'Rp ' + diff.toLocaleString('id-ID');
            }

            // Initialize on load
            document.addEventListener('DOMContentLoaded', function() {
                const currentMethod = document.getElementById('pendingMetodePembayaran').value;
                switchPendingPaymentMethod(currentMethod);
            });
        </script>
        @endif
    @endif

    <!-- Variant Picker Modal -->
    <div id="variantModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen px-4 pb-4 sm:items-center">
            <div class="fixed inset-0 bg-black bg-opacity-40" onclick="closeVariantModal()"></div>
            <div class="relative w-full max-w-xs bg-white rounded-xl shadow-xl dark:bg-gray-800 p-5 z-10">
                <h4 class="mb-1 text-base font-bold text-gray-900 dark:text-white" id="variantModalTitle">Pilih Ukuran</h4>
                <p class="mb-3 text-xs text-gray-500 dark:text-gray-400" id="variantModalSubtitle"></p>
                <div id="variantOptions" class="grid grid-cols-3 gap-2 mb-4"></div>
                <button type="button" onclick="closeVariantModal()" class="w-full py-2 text-sm text-gray-600 border rounded-lg hover:bg-gray-50">Batal</button>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function addToCart(element) {
            const product = {
                id:       element.dataset.id,
                name:     element.dataset.name,
                price:    parseFloat(element.dataset.price),
                stock:    parseInt(element.dataset.stock),
                variants: JSON.parse(element.dataset.variants || '[]'),
            };
            if (product.variants.length > 0) {
                openVariantModal(product);
            } else {
                pushToCart(product, null);
            }
        }

        function openVariantModal(product) {
            document.getElementById('variantModalTitle').textContent = product.name;
            document.getElementById('variantModalSubtitle').textContent = 'Harga dasar: Rp ' + product.price.toLocaleString('id-ID');
            const opts = document.getElementById('variantOptions');
            opts.innerHTML = '';
            product.variants.forEach(v => {
                const finalPrice = product.price + parseFloat(v.harga_tambahan);
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'flex flex-col items-center p-3 border-2 border-gray-200 rounded-xl hover:border-yellow-400 hover:bg-yellow-50 transition-all';
                btn.innerHTML = `
                    <span class="text-lg font-black text-gray-800">${v.kode_variant}</span>
                    <span class="text-[10px] text-gray-500 mt-0.5">${v.nama_variant}</span>
                    <span class="text-xs font-semibold text-gray-900 mt-1">Rp ${finalPrice.toLocaleString('id-ID')}</span>
                    ${parseFloat(v.harga_tambahan) > 0 ? `<span class="text-[9px] text-gray-500">+Rp ${parseFloat(v.harga_tambahan).toLocaleString('id-ID')}</span>` : ''}
                `;
                btn.onclick = () => { pushToCart(product, v); closeVariantModal(); };
                opts.appendChild(btn);
            });
            document.getElementById('variantModal').classList.remove('hidden');
        }

        function closeVariantModal() {
            document.getElementById('variantModal').classList.add('hidden');
        }

        function pushToCart(product, variant) {
            // Each addition creates a new cart item (unique key with timestamp)
            // so the same product with different variant/notes stays separate
            const cartKey    = product.id + '_' + (variant ? variant.id : 'novar') + '_' + Date.now();
            const finalPrice = product.price + (variant ? parseFloat(variant.harga_tambahan) : 0);

            // Check total qty of this product already in cart
            const totalQtyInCart = cart.filter(i => i.id === product.id).reduce((sum, i) => sum + i.qty, 0);
            if (totalQtyInCart >= product.stock) { alert('Stok tidak mencukupi'); return; }

            cart.push({
                cartKey,
                id:          product.id,
                name:        product.name,
                basePrice:   product.price,
                price:       finalPrice,
                stock:       product.stock,
                variants:    product.variants || [],
                qty:         1,
                variantId:   variant ? variant.id : null,
                variantName: variant ? `${variant.kode_variant} - ${variant.nama_variant}` : null,
                catatan:     '',
            });
            renderCart();
        }

        function changeVariant(cartKey, variantId) {
            const item = cart.find(i => i.cartKey === cartKey);
            if (!item) return;

            if (!variantId) {
                item.variantId   = null;
                item.variantName = null;
                item.price       = item.basePrice;
            } else {
                const v = item.variants.find(v => String(v.id) === String(variantId));
                if (!v) return;
                item.variantId   = v.id;
                item.variantName = `${v.kode_variant} - ${v.nama_variant}`;
                item.price       = item.basePrice + parseFloat(v.harga_tambahan);
            }
            renderCart();
        }

        /**
         * Duplicate a cart item — creates a new row for the same product+variant
         * so the user can set different notes / qty.
         */
        function duplicateItem(cartKey) {
            const src = cart.find(i => i.cartKey === cartKey);
            if (!src) return;
            const totalQty = cart.filter(i => i.id === src.id).reduce((s,i) => s + i.qty, 0);
            if (totalQty >= src.stock) { alert('Stok tidak mencukupi'); return; }
            cart.push({
                ...src,
                cartKey: src.id + '_' + (src.variantId || 'novar') + '_' + Date.now(),
                qty: 1,
                catatan: '',
            });
            renderCart();
        }

        function removeItem(cartKey) {
            cart = cart.filter(i => i.cartKey !== cartKey);
            renderCart();
        }

        function updateQty(cartKey, change) {
            const item = cart.find(i => i.cartKey === cartKey);
            if (!item) return;
            const newQty = item.qty + change;
            if (newQty <= 0) { removeItem(cartKey); return; }
            // Check total stock across all rows of same product
            const otherQty = cart.filter(i => i.id === item.id && i.cartKey !== cartKey).reduce((s,i) => s + i.qty, 0);
            if (otherQty + newQty > item.stock) { alert('Stok tidak mencukupi'); return; }
            item.qty = newQty;
            renderCart();
        }

        function updateCatatan(cartKey, value) {
            const item = cart.find(i => i.cartKey === cartKey);
            if (item) item.catatan = value;
        }

        function renderCart() {
            const cartItemsDiv = document.getElementById('cartItems');
            const cartDataDiv  = document.getElementById('cartData');

            if (cart.length === 0) {
                cartItemsDiv.innerHTML = '<p class="text-sm text-gray-500">Belum ada item</p>';
                cartDataDiv.innerHTML  = '';
                document.getElementById('subTotalAmount').textContent = 'Rp 0';
                document.getElementById('totalAmount').textContent    = 'Rp 0';
                return;
            }

            let html = '', subtotalCart = 0, hiddenInputs = '';

            cart.forEach((item, index) => {
                const itemSubtotal = item.price * item.qty;
                subtotalCart += itemSubtotal;

                // Build variant button group if product has variants
                let variantButtons = '';
                if (item.variants && item.variants.length > 0) {
                    const btns = item.variants.map(v => {
                        const isActive = String(item.variantId) === String(v.id);
                        const activeClass = isActive
                            ? 'bg-yellow-400 border-yellow-500 text-gray-900 font-bold'
                            : 'bg-white border-gray-300 text-gray-600 hover:border-yellow-400 hover:bg-yellow-50';
                        return `<button type="button"
                            onclick="changeVariant('${item.cartKey}', '${v.id}')"
                            class="px-2 py-0.5 text-xs border rounded transition-colors ${activeClass}">
                            ${v.kode_variant}
                        </button>`;
                    }).join('');
                    variantButtons = `<div class="flex gap-1 mt-1 items-center">
                        <span class="text-xs text-gray-400 mr-1">Ukuran:</span>${btns}
                    </div>`;
                }

                html += `
                <div class="p-2 border rounded">
                    <div class="flex justify-between">
                        <div class="text-sm font-semibold">${item.name}</div>
                        <div class="flex items-center gap-1">
                            <button type="button" onclick="duplicateItem('${item.cartKey}')" class="text-blue-500 hover:text-blue-700" title="Duplikat item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                            </button>
                            <button type="button" onclick="removeItem('${item.cartKey}')" class="text-red-600 hover:text-red-800">✕</button>
                        </div>
                    </div>
                    ${item.variantName ? `<div class="text-xs text-yellow-600 font-medium">${item.variantName}</div>` : ''}
                    ${variantButtons}
                    <div class="flex items-center justify-between mt-1">
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="updateQty('${item.cartKey}', -1)" class="px-2 border rounded">-</button>
                            <span class="text-sm">${item.qty}</span>
                            <button type="button" onclick="updateQty('${item.cartKey}', 1)" class="px-2 border rounded">+</button>
                        </div>
                        <div class="text-sm font-semibold">Rp ${itemSubtotal.toLocaleString('id-ID')}</div>
                    </div>
                    <input type="text"
                        placeholder="Catatan (opsional)..."
                        value="${item.catatan}"
                        oninput="updateCatatan('${item.cartKey}', this.value)"
                        class="mt-1.5 w-full text-xs px-2 py-1 border border-dashed border-gray-300 rounded bg-white dark:bg-gray-600 dark:border-gray-500 dark:text-white placeholder-gray-400 focus:outline-none focus:border-yellow-400">
                </div>`;

                hiddenInputs += `
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][jumlah]" value="${item.qty}">
                    <input type="hidden" name="items[${index}][variant_id]" value="${item.variantId ?? ''}">
                    <input type="hidden" name="items[${index}][catatan]" value="${item.catatan}">
                `;
            });

            const discountSelect = document.getElementById('discountEventId');
            let discountPct = 0;
            if (discountSelect && discountSelect.selectedIndex > 0) {
                discountPct = parseFloat(discountSelect.options[discountSelect.selectedIndex].getAttribute('data-percentage')) || 0;
            }
            const discountAmount = (subtotalCart * discountPct) / 100;
            const finalTotal     = subtotalCart - discountAmount;

            cartItemsDiv.innerHTML = html;
            cartDataDiv.innerHTML  = hiddenInputs;
            document.getElementById('subTotalAmount').textContent = 'Rp ' + subtotalCart.toLocaleString('id-ID');
            document.getElementById('totalAmount').textContent    = 'Rp ' + finalTotal.toLocaleString('id-ID');
        }

        function clearCart() {
            if (confirm('Kosongkan keranjang?')) { cart = []; renderCart(); }
        }

        function filterCategory(categoryId) {
            document.querySelectorAll('.product-item').forEach(item => {
                item.style.display = (categoryId === 'all' || item.dataset.category == categoryId) ? 'block' : 'none';
            });
        }

        document.getElementById('searchProduct').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                item.style.display = item.dataset.name.toLowerCase().includes(search) ? 'block' : 'none';
            });
        });

        function toggleJumlahBayar() {
            const method      = document.getElementById('metodePembayaran').value;
            const divJumlah   = document.getElementById('divJumlahBayar');
            const inputJumlah = document.getElementById('jumlahBayar');
            if (method === 'cash') {
                divJumlah.style.display = 'block';
                inputJumlah.required    = true;
                if (inputJumlah.value === '0') inputJumlah.value = '';
            } else {
                divJumlah.style.display = 'none';
                inputJumlah.required    = false;
                inputJumlah.value       = '0';
            }
        }

        document.addEventListener('DOMContentLoaded', () => toggleJumlahBayar());
    </script>

    @if(session('show_receipt'))
        @php
            $transaksi = \App\Models\Transaksi::with(['details.product.kategori', 'details.variant', 'pembayaran', 'user', 'discountEvent'])->find(session('show_receipt'));
            session()->forget('show_receipt');
        @endphp
        @if($transaksi)
        <div id="receiptModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                    <div id="receiptContent" class="p-6 font-mono text-sm text-gray-900 bg-white border-t-8 border-b-8 border-gray-100">
                        <div class="flex justify-center mb-3">
                            <div class="flex items-center justify-center bg-green-500 rounded-full" style="width:40px;height:40px;">
                                <svg class="text-white" style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="mb-4 text-center">
                            <h2 class="mb-1 text-2xl font-bold tracking-wider uppercase">Yellow Drink</h2>
                            <p class="text-xs text-gray-600">Jl. Kasir Yellow No. 1, City</p>
                            <p class="text-xs text-gray-600">Telp: 0812-3456-7890</p>
                        </div>
                        <div class="my-4 border-t-2 border-gray-300 border-dashed"></div>
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
                        <div class="my-4 border-t-2 border-gray-300 border-dashed"></div>
                        <div class="mb-4">
                            @foreach($transaksi->details as $detail)
                            <div class="mb-3">
                                <div class="text-sm font-bold">{{ $detail->product->nama_produk }}
                                    @if($detail->variant)
                                        <span class="text-xs font-normal text-gray-600">({{ $detail->variant->kode_variant }})</span>
                                    @endif
                                </div>
                                @if($detail->catatan)
                                    <div class="text-xs text-gray-500 italic">{{ $detail->catatan }}</div>
                                @endif
                                <div class="flex justify-between mt-1 text-xs text-gray-700">
                                    <span>{{ $detail->jumlah }} x {{ number_format($detail->subtotal / $detail->jumlah, 0, ',', '.') }}</span>
                                    <span class="font-medium text-gray-900">{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="my-4 border-t-2 border-gray-300 border-dashed"></div>
                        <div>
                            @php
                                $subtotalBruto  = $transaksi->details->sum('subtotal');
                                $discountPct    = $transaksi->discountEvent ? floatval($transaksi->discountEvent->discount_percentage) : 0;
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
                        <div class="my-4 border-t-2 border-gray-300 border-dashed"></div>
                        <div class="mt-6 text-xs text-center text-gray-600">
                            <p class="mb-1 font-bold">Terima Kasih Atas Kunjungan Anda!</p>
                            <p class="italic text-[10px]">Layanan Konsumen: @yellowdrink.id</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 px-6 py-4 border-t bg-gray-50">
                        <button onclick="printReceipt()" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-gray-700 transition-colors bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-100">
                            Cetak
                        </button>
                        <button onclick="window.location.href='{{ auth()->user()->role === 'admin' ? route('admin.transaksi.index') : route('kasir.transaksi.index') }}'" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-gray-700 transition-colors bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-100">
                            Riwayat
                        </button>
                        <button onclick="closeReceiptModal()" class="flex items-center justify-center px-4 py-3 text-sm font-semibold text-white transition-colors bg-green-600 border border-green-600 rounded shadow-sm hover:bg-green-700">
                            Selesai
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
                    <html><head>
                        <title>Struk - {{ $transaksi->no_invoice }}</title>
                        <style>
                            @media print { @page { margin: 0; } body { margin: 0; padding: 5mm; } }
                            body { font-family: 'Courier New', monospace; padding: 20px; max-width: 80mm; margin: 0 auto; color: #000; background: #fff; line-height: 1.4; }
                            * { box-sizing: border-box; }
                            .text-center { text-align: center; } .flex { display: flex; } .justify-between { justify-content: space-between; }
                            .font-bold, .font-semibold, .font-medium { font-weight: 700; }
                            .text-2xl { font-size: 1.5rem; } .text-base { font-size: 1rem; } .text-sm { font-size: 0.875rem; } .text-xs { font-size: 0.75rem; }
                            .uppercase { text-transform: uppercase; } .italic { font-style: italic; }
                            .mb-1 { margin-bottom: 0.25rem; } .mb-2 { margin-bottom: 0.5rem; } .mb-3 { margin-bottom: 0.75rem; } .mb-4 { margin-bottom: 1rem; }
                            .mt-1 { margin-top: 0.25rem; } .mt-6 { margin-top: 1.5rem; } .my-4 { margin: 1rem 0; } .pt-2 { padding-top: 0.5rem; }
                            .text-gray-500, .text-gray-600, .text-gray-700, .text-gray-800, .text-gray-900 { color: #000; }
                            .bg-green-500 { background-color: #000; } .text-white { color: #fff; } .rounded-full { border-radius: 50%; }
                            .border-t-2 { border-top: 2px solid #000; } .border-t { border-top: 1px solid #000; } .border-dashed { border-style: dashed; } .border-gray-300 { border-color: #000; }
                            .text-red-600 { color: #000; }
                        </style>
                    </head><body>
                        ${receiptContent}
                        <script>window.onload=function(){window.print();window.onafterprint=function(){window.close();}}<\/script>
                    </body></html>
                `);
                printWindow.document.close();
            }
            document.getElementById('receiptModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeReceiptModal();
            });
        </script>
        @endif
    @endif
</x-app-layout>
