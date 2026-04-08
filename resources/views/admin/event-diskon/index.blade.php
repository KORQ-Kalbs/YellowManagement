<x-app-layout>
<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Discount Events</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Manage ongoing and future discount events for the POS system.</p>
        </div>
        <a href="{{ route('admin.event-diskon.create') }}" 
           class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition-all duration-200 bg-yellow-500 rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Event
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 mb-6 text-sm text-green-800 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-200 border-l-4 border-green-500 shadow-sm" role="alert">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 rounded-xl rounded-2xl ring-1 ring-gray-200 dark:ring-gray-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Name</th>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Discount</th>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Period</th>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Status</th>
                        <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse ($events as $event)
                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $event->name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ $event->description ?: 'No description' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="inline-flex items-center px-2.5 py-1.5 rounded-md text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                {{ floatval($event->discount_percentage) }}%
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-300">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $event->start_date->format('d M Y, H:i') }}
                                </div>
                                <div class="flex items-center gap-1 mt-1 text-xs text-gray-500">
                                    <span class="px-1 items-center flex">to</span>
                                    {{ $event->end_date->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $isActive = $event->is_active && $event->start_date <= now() && $event->end_date >= now();
                                $isFuture = $event->is_active && $event->start_date > now();
                            @endphp
                            
                            @if($isActive)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 ring-1 ring-inset ring-yellow-600/20">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-yellow-500 rounded-full animate-pulse"></span>
                                    Active Now
                                </span>
                            @elseif($isFuture)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 ring-1 ring-inset ring-blue-600/20">
                                    Upcoming
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 ring-1 ring-inset ring-gray-500/20">
                                    Inactive / Expired
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.event-diskon.edit', $event->id) }}" class="p-1 text-blue-600 transition-colors rounded hover:bg-blue-100 hover:text-blue-900 dark:text-blue-400 dark:hover:bg-blue-900/30" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.event-diskon.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-red-600 transition-colors rounded hover:bg-red-100 hover:text-red-900 dark:text-red-400 dark:hover:bg-red-900/30" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">No discount events found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new event.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.event-diskon.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-yellow-600 bg-yellow-100 rounded-md hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50">
                                    <svg class="w-4 h-4 mr-1.5 -ml-1 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    Create Event
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($events->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-700">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</div>
</x-app-layout>
