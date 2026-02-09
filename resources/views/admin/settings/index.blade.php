<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Settings</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure your system preferences</p>
        </div>
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <!-- Application Settings -->
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Application Settings</h3>
            </x-slot>

            <form class="space-y-6">
                <!-- Shop Name -->
                <div>
                    <label for="shop_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Shop Name</label>
                    <input type="text" id="shop_name" value="Yellow Drink" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500" readonly>
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                    <select id="currency" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500">
                        <option selected>IDR (Rp)</option>
                        <option>USD ($)</option>
                        <option>EUR (€)</option>
                    </select>
                </div>

                <!-- Tax Rate -->
                <div>
                    <label for="tax_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Default Tax Rate (%)</label>
                    <input type="number" id="tax_rate" value="10" step="0.01" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500">
                </div>

                <!-- Items Per Page -->
                <div>
                    <label for="items_per_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Items Per Page</label>
                    <input type="number" id="items_per_page" value="10" min="5" max="100" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500">
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-4">
                    <x-primary-button type="submit">Save Settings</x-primary-button>
                </div>
            </form>
        </x-card>

        <!-- Notification Settings -->
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Notifications</h3>
            </x-slot>

            <form class="space-y-4">
                <!-- Email Notifications -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Email Notifications</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Receive email for important updates</p>
                    </div>
                    <input type="checkbox" checked class="w-5 h-5 rounded text-yellow-500 cursor-pointer">
                </div>

                <!-- Low Stock Alerts -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Low Stock Alerts</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Alert when product stock is low</p>
                    </div>
                    <input type="checkbox" checked class="w-5 h-5 rounded text-yellow-500 cursor-pointer">
                </div>

                <!-- Daily Reports -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Daily Reports</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Receive daily sales reports</p>
                    </div>
                    <input type="checkbox" class="w-5 h-5 rounded text-yellow-500 cursor-pointer">
                </div>

                <!-- Save Button -->
                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
                    <x-primary-button type="submit">Save Preferences</x-primary-button>
                </div>
            </form>
        </x-card>

        <!-- System Information -->
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">System Information</h3>
            </x-slot>

            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Application Version</span>
                    <span class="font-semibold text-gray-900 dark:text-white">1.0.0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Laravel Version</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ app()->version() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">PHP Version</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Demo Mode</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200">
                        Active
                    </span>
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
