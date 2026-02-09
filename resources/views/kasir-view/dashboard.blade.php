<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Point of Sale (POS)</h2>
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
                                <span class="font-bold">Total:</span>
                                <span class="font-bold" id="totalAmount">Rp 0</span>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1 text-sm">Metode Pembayaran</label>
                                <select name="metode_pembayaran" required class="w-full p-2 border rounded">
                                    <option value="cash">Cash</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1 text-sm">Jumlah Bayar</label>
                                <input type="number" name="jumlah_bayar" id="jumlahBayar" required class="w-full p-2 border rounded" min="0" step="1000">
                            </div>

                            <div class="mb-4">
                                <div class="flex justify-between text-sm">
                                    <span>Kembalian:</span>
                                    <span id="kembalian">Rp 0</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full p-3 font-bold text-white bg-green-600 rounded hover:bg-green-700">
                                Proses Transaksi
                            </button>

                            <button type="button" onclick="clearCart()" class="w-full p-2 mt-2 text-sm border rounded hover:bg-gray-50">
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
                document.getElementById('totalAmount').textContent = 'Rp 0';
                return;
            }

            let html = '';
            let total = 0;
            let hiddenInputs = '';

            cart.forEach((item, index) => {
                const subtotal = item.price * item.qty;
                total += subtotal;

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
                            <div class="text-sm">Rp ${subtotal.toLocaleString('id-ID')}</div>
                        </div>
                    </div>
                `;

                hiddenInputs += `
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][jumlah]" value="${item.qty}">
                `;
            });

            cartItemsDiv.innerHTML = html;
            cartDataDiv.innerHTML = hiddenInputs;
            document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');

            // Update kembalian calculation
            const jumlahBayar = parseFloat(document.getElementById('jumlahBayar').value) || 0;
            const kembalian = jumlahBayar - total;
            document.getElementById('kembalian').textContent = 'Rp ' + (kembalian > 0 ? kembalian : 0).toLocaleString('id-ID');
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

        // Update kembalian on jumlah bayar change
        document.getElementById('jumlahBayar').addEventListener('input', function() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const jumlahBayar = parseFloat(this.value) || 0;
            const kembalian = jumlahBayar - total;
            document.getElementById('kembalian').textContent = 'Rp ' + (kembalian > 0 ? kembalian : 0).toLocaleString('id-ID');
        });
    </script>
</x-app-layout>