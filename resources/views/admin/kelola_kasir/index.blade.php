<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="min-w-0">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white truncate">Kasir Management</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 truncate">Manage cashier accounts and permissions</p>
            </div>
            <button @click="$dispatch('open-modal', 'kasir-modal'); resetKasirForm()" class="flex-shrink-0 w-full sm:w-auto inline-flex items-center px-4 py-2 font-medium text-white transition-colors bg-yellow-500 rounded-lg hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Kasir
            </button>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 text-red-800 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Kasir Table -->
        <x-card noPadding="true">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                    <thead class="font-semibold text-gray-700 bg-gray-100 border-b border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Name</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Email</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Total Transactions</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Joined Date</th>
                            <th class="px-6 py-3 text-xs font-semibold tracking-wider uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse($kasirs as $kasir)
                            <tr class="transition-colors bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-10 h-10 mr-3 text-sm font-bold text-white bg-yellow-500 rounded-full">
                                            {{ strtoupper(substr($kasir->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $kasir->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">ID: {{ $kasir->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-900 dark:text-white">{{ $kasir->email }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $kasir->transaksis_count }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-600 dark:text-gray-400">{{ $kasir->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <button @click="editKasir({{ $kasir->id }}, '{{ $kasir->name }}', '{{ $kasir->email }}')" class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 transition-colors rounded-lg bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.kasir.destroy', $kasir->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this kasir? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-600 transition-colors rounded-lg bg-red-50 dark:bg-red-900/30 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50" {{ $kasir->transaksis_count > 0 ? 'disabled title="Cannot delete kasir with transactions"' : '' }}>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="text-lg text-gray-600 dark:text-gray-400">No kasir accounts found</p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-500">Add your first kasir to get started</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

    <!-- Kasir Modal -->
    <x-modal name="kasir-modal" :show="false">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4" id="kasir-modal-title">Add Kasir</h3>
            
            <form id="kasir-form" method="POST" action="{{ route('admin.kasir.store') }}">
                @csrf
                <input type="hidden" id="kasir-method" name="_method" value="POST">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                        <input type="text" id="kasir-name" name="name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" id="kasir-email" name="email" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <input type="password" id="kasir-password" name="password" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                        <input type="password" id="kasir-password-confirmation" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button type="button" @click="$dispatch('close')">Cancel</x-secondary-button>
                    <x-primary-button type="submit">Save</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        function resetKasirForm() {
            document.getElementById('kasir-modal-title').textContent = 'Add Kasir';
            document.getElementById('kasir-form').action = '{{ route("admin.kasir.store") }}';
            document.getElementById('kasir-method').value = 'POST';
            document.getElementById('kasir-name').value = '';
            document.getElementById('kasir-email').value = '';
            document.getElementById('kasir-password').value = '';
            document.getElementById('kasir-password-confirmation').value = '';
            document.getElementById('kasir-password').required = true;
            document.getElementById('kasir-password-confirmation').required = true;
        }

        function editKasir(id, name, email) {
            document.getElementById('kasir-modal-title').textContent = 'Edit Kasir';
            document.getElementById('kasir-form').action = '{{ route("admin.kasir.update", ":id") }}'.replace(':id', id);
            document.getElementById('kasir-method').value = 'PUT';
            document.getElementById('kasir-name').value = name;
            document.getElementById('kasir-email').value = email;
            document.getElementById('kasir-password').value = '';
            document.getElementById('kasir-password-confirmation').value = '';
            document.getElementById('kasir-password').required = false;
            document.getElementById('kasir-password-confirmation').required = false;
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'kasir-modal' }));
        }
    </script>
</x-app-layout>
