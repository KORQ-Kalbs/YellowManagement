<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">POS System</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Process transactions and manage sales</p>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[calc(100vh-200px)]">
        <!-- Products Section -->
        <div class="lg:col-span-2 flex flex-col">
            <x-card noPadding="true" class="flex-1 flex flex-col">
                <!-- Search and Filters -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 space-y-4">
                    <div class="relative">
                        <input type="text" id="product-search" placeholder="Search products..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <div class="flex space-x-2">
                        <select id="category-filter" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">All Categories</option>
                            <option value="beverage">Beverages</option>
                            <option value="snack">Snacks</option>
                            <option value="coffee">Coffee</option>
                        </select>
                        <button onclick="resetFilters()" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors text-sm font-medium">Reset</button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="flex-1 overflow-y-auto p-4">
                    <div class="grid grid-cols-3 gap-4">
                        <!-- Product Card 1 -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                            <div class="bg-yellow-100 dark:bg-gray-700 h-24 flex items-center justify-center">
                                <svg class="w-12 h-12 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                </svg>
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">Iced Coffee</h3>
                                <p class="text-yellow-600 dark:text-yellow-400 font-bold text-sm mt-2">Rp 25,000</p>
                                <button onclick="addToCart(1, 'Iced Coffee', 25000)" class="w-full mt-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white rounded text-sm font-medium transition-colors">Add</button>
                            </div>
                        </div>

                        <!-- Product Card 2 -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                            <div class="bg-blue-100 dark:bg-gray-700 h-24 flex items-center justify-center">
                                <svg class="w-12 h-12 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                </svg>
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">Vanilla Latte</h3>
                                <p class="text-yellow-600 dark:text-yellow-400 font-bold text-sm mt-2">Rp 30,000</p>
                                <button onclick="addToCart(2, 'Vanilla Latte', 30000)" class="w-full mt-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white rounded text-sm font-medium transition-colors">Add</button>
                            </div>
                        </div>

                        <!-- Product Card 3 -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                            <div class="bg-green-100 dark:bg-gray-700 h-24 flex items-center justify-center">
                                <svg class="w-12 h-12 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                </svg>
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">Matcha Latte</h3>
                                <p class="text-yellow-600 dark:text-yellow-400 font-bold text-sm mt-2">Rp 35,000</p>
                                <button onclick="addToCart(3, 'Matcha Latte', 35000)" class="w-full mt-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white rounded text-sm font-medium transition-colors">Add</button>
                            </div>
                        </div>

                        <!-- Product Card 4 -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                            <div class="bg-red-100 dark:bg-gray-700 h-24 flex items-center justify-center">
                                <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                </svg>
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">Strawberry Juice</h3>
                                <p class="text-yellow-600 dark:text-yellow-400 font-bold text-sm mt-2">Rp 22,000</p>
                                <button onclick="addToCart(4, 'Strawberry Juice', 22000)" class="w-full mt-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white rounded text-sm font-medium transition-colors">Add</button>
                            </div>
                        </div>

                        <!-- Product Card 5 -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                            <div class="bg-orange-100 dark:bg-gray-700 h-24 flex items-center justify-center">
                                <svg class="w-12 h-12 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                </svg>
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">Croissant</h3>
                                <p class="text-yellow-600 dark:text-yellow-400 font-bold text-sm mt-2">Rp 15,000</p>
                                <button onclick="addToCart(5, 'Croissant', 15000)" class="w-full mt-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white rounded text-sm font-medium transition-colors">Add</button>
                            </div>
                        </div>

                        <!-- Product Card 6 -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                            <div class="bg-purple-100 dark:bg-gray-700 h-24 flex items-center justify-center">
                                <svg class="w-12 h-12 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" />
                                </svg>
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2">Blueberry Muffin</h3>
                                <p class="text-yellow-600 dark:text-yellow-400 font-bold text-sm mt-2">Rp 18,000</p>
                                <button onclick="addToCart(6, 'Blueberry Muffin', 18000)" class="w-full mt-2 px-3 py-1 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white rounded text-sm font-medium transition-colors">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Cart Section -->
        <div class="flex flex-col">
            <x-card noPadding="true" class="flex-1 flex flex-col">
                <!-- Cart Header -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Cart</h3>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto p-4" id="cart-items">
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Cart is empty</p>
                    </div>
                </div>

                <!-- Cart Footer -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                        <span class="font-semibold text-gray-900 dark:text-white" id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Tax (10%):</span>
                        <span class="font-semibold text-gray-900 dark:text-white" id="tax">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-bold text-gray-900 dark:text-white">Total:</span>
                        <span class="font-bold text-yellow-600 dark:text-yellow-400 text-2xl" id="total">Rp 0</span>
                    </div>

                    <div class="space-y-2 pt-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Amount</label>
                            <input type="number" id="payment-amount" placeholder="Enter amount" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-lg font-semibold">
                        </div>
                        <div id="change-display" class="hidden">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Change:</p>
                            <p class="text-xl font-bold text-green-600 dark:text-green-400" id="change-amount">Rp 0</p>
                        </div>
                    </div>

                    <div class="flex space-x-2 pt-2">
                        <button onclick="resetCart()" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors font-medium">Cancel</button>
                        <button onclick="completeTransaction()" class="flex-1 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white rounded-lg transition-colors font-medium">Complete</button>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <script>
        let cartItems = [];

        function addToCart(id, name, price) {
            const existingItem = cartItems.find(item => item.id === id);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cartItems.push({ id, name, price, quantity: 1 });
            }
            
            updateCart();
        }

        function removeFromCart(id) {
            cartItems = cartItems.filter(item => item.id !== id);
            updateCart();
        }

        function updateQuantity(id, quantity) {
            const item = cartItems.find(item => item.id === id);
            if (item) {
                if (quantity <= 0) {
                    removeFromCart(id);
                } else {
                    item.quantity = quantity;
                    updateCart();
                }
            }
        }

        function updateCart() {
            const cartContainer = document.getElementById('cart-items');
            
            if (cartItems.length === 0) {
                cartContainer.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Cart is empty</p>
                    </div>
                `;
            } else {
                cartContainer.innerHTML = cartItems.map(item => `
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg mb-2">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 dark:text-white">${item.name}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Rp ${item.price.toLocaleString('id-ID')}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="px-2 py-1 bg-gray-300 dark:bg-gray-600 rounded hover:bg-gray-400 dark:hover:bg-gray-500 text-xs font-bold">−</button>
                            <span class="w-8 text-center font-semibold text-gray-900 dark:text-white">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="px-2 py-1 bg-gray-300 dark:bg-gray-600 rounded hover:bg-gray-400 dark:hover:bg-gray-500 text-xs font-bold">+</button>
                            <button onclick="removeFromCart(${item.id})" class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded hover:bg-red-200 dark:hover:bg-red-900 text-xs">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `).join('');
            }

            calculateTotals();
        }

        function calculateTotals() {
            const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = Math.round(subtotal * 0.1);
            const total = subtotal + tax;

            document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('tax').textContent = `Rp ${tax.toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp ${total.toLocaleString('id-ID')}`;

            // Update change calculation
            const paymentAmount = parseFloat(document.getElementById('payment-amount').value) || 0;
            const change = paymentAmount - total;
            
            if (paymentAmount > 0) {
                document.getElementById('change-display').classList.remove('hidden');
                document.getElementById('change-amount').textContent = `Rp ${change.toLocaleString('id-ID')}`;
            } else {
                document.getElementById('change-display').classList.add('hidden');
            }
        }

        function resetCart() {
            cartItems = [];
            document.getElementById('payment-amount').value = '';
            updateCart();
        }

        function completeTransaction() {
            if (cartItems.length === 0) {
                alert('Cart is empty!');
                return;
            }

            const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const tax = Math.round(subtotal * 0.1);
            const total = subtotal + tax;
            const payment = parseFloat(document.getElementById('payment-amount').value);

            if (!payment || payment < total) {
                alert('Invalid payment amount!');
                return;
            }

            alert(`Transaction completed!\nTotal: Rp ${total.toLocaleString('id-ID')}\nPayment: Rp ${payment.toLocaleString('id-ID')}\nChange: Rp ${(payment - total).toLocaleString('id-ID')}`);
            resetCart();
        }

        function resetFilters() {
            document.getElementById('product-search').value = '';
            document.getElementById('category-filter').value = '';
        }

        // Update change calculation on payment input
        document.getElementById('payment-amount').addEventListener('input', calculateTotals);
    </script>
</x-app-layout>
