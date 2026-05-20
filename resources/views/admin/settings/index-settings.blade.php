<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Pengaturan</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Konfigurasi preferensi sistem</p>
        </div>
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <!-- Application Settings -->
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pengaturan Aplikasi</h3>
            </x-slot>

            <form class="space-y-6">
                <!-- Shop Name -->
                <div>
                    <label for="shop_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Toko</label>
                    <input type="text" id="shop_name" value="Yellow Drink" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500" readonly>
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mata Uang</label>
                    <select id="currency" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500">
                        <option selected>IDR (Rp)</option>
                        <option>USD ($)</option>
                        <option>EUR (€)</option>
                    </select>
                </div>

                <!-- Tax Rate -->
                <div>
                    <label for="tax_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tarif Pajak Default (%)</label>
                    <input type="number" id="tax_rate" value="10" step="0.01" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500">
                </div>

                <!-- Items Per Page -->
                <div>
                    <label for="items_per_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Item Per Halaman</label>
                    <input type="number" id="items_per_page" value="10" min="5" max="100" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500">
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-4">
                    <x-primary-button type="submit">Simpan Pengaturan</x-primary-button>
                </div>
            </form>
        </x-card>

        <!-- Notification Settings -->
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Notifikasi</h3>
            </x-slot>

            <form class="space-y-4">
                <!-- Email Notifications -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Notifikasi Email</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Terima email untuk pembaruan penting</p>
                    </div>
                    <input type="checkbox" checked class="w-5 h-5 rounded text-yellow-500 cursor-pointer">
                </div>

                <!-- Low Stock Alerts -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Peringatan Stok Rendah</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Peringatan ketika stok produk menipis</p>
                    </div>
                    <input type="checkbox" checked class="w-5 h-5 rounded text-yellow-500 cursor-pointer">
                </div>

                <!-- Daily Reports -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Laporan Harian</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Terima laporan penjualan harian</p>
                    </div>
                    <input type="checkbox" class="w-5 h-5 rounded text-yellow-500 cursor-pointer">
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
                    <x-primary-button type="submit">Simpan Preferensi</x-primary-button>
                </div>
            </form>
        </x-card>

        <!-- System Information -->
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Sistem</h3>
            </x-slot>

            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Versi Aplikasi</span>
                    <span class="font-semibold text-gray-900 dark:text-white">1.0.0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Versi Laravel</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Versi PHP</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Mode Demo</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200">
                        Aktif
                    </span>
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
