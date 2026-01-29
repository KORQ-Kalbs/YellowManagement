<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }} <br>
                    <!-- table content -->
                     <table>
                        <thead>
                            <tr>
                                <th>Nama Ikan</th>
                                <th>Harga Ikan</th>
                                <th>Stok Ikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(App\Models\IkanModel::all() as $ikan)
                            <tr>
                                <td>{{ $ikan->nama_ikan }}</td>
                                <td>{{ $ikan->harga_ikan }}</td>
                                <td>{{ $ikan->stok_ikan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
