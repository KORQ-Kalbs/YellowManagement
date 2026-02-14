<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your account information</p>
        </div>
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <!-- Profile Information -->
        <x-card>
            <livewire:profile.update-profile-information-form />
        </x-card>

        <!-- Update Password -->
        <x-card>
            <livewire:profile.update-password-form />
        </x-card>

        <!-- Delete Account -->
        <x-card class="border-red-200 dark:border-red-800">
            <livewire:profile.delete-user-form />
        </x-card>
    </div>
</x-app-layout>
