<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your account information</p>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="space-y-6">
            <!-- Profile Information Card -->
            <x-card>
                <x-slot name="header">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Profile Information</h3>
                </x-slot>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500" required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500" required>
                    </div>

                    <!-- Role Badge -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                        <div class="inline-block">
                            @if(auth()->user()->role === 'admin')
                                <x-badge :color="'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200'">
                                    Administrator
                                </x-badge>
                            @else
                                <x-badge :color="'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200'">
                                    Cashier
                                </x-badge>
                            @endif
                        </div>
                    </div>

                    <!-- Member Since -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Member Since</label>
                        <p class="text-gray-900 dark:text-white">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end pt-4">
                        <x-primary-button type="submit">Save Changes</x-primary-button>
                    </div>
                </form>
            </x-card>

            <!-- Change Password Card -->
            <x-card>
                <x-slot name="header">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Change Password</h3>
                </x-slot>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500" required>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500" required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500" required>
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end pt-4">
                        <x-primary-button type="submit">Update Password</x-primary-button>
                    </div>
                </form>
            </x-card>

            <!-- Danger Zone -->
            <x-card class="border-red-200 dark:border-red-800">
                <x-slot name="header">
                    <h3 class="text-lg font-bold text-red-600 dark:text-red-400">Danger Zone</h3>
                </x-slot>

                <div class="space-y-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Permanently delete your account and all associated data. This action cannot be undone.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            Delete Account
                        </button>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
