<x-app-layout>
<div class="px-4 py-8 mx-auto max-w-4xl sm:px-6 lg:px-8">
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.event-diskon.index') }}" class="p-2 text-gray-400 transition-colors bg-white rounded-lg shadow-sm hover:text-gray-500 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-gray-300 ring-1 ring-gray-200 dark:ring-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Create Discount Event</h1>
                <p class="mt-1 text-sm text-gray-500">Configure a new active promotional discount period.</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-6 rounded-lg bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 ring-1 ring-red-200 dark:ring-red-900/50">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400 dark:text-red-300" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission</h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <ul class="pl-5 space-y-1 list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 rounded-2xl ring-1 ring-gray-200 dark:ring-gray-700">
        <form action="{{ route('admin.event-diskon.store') }}" method="POST" class="p-6 sm:p-8">
            @csrf

            <div class="space-y-8">
                <!-- General Information -->
                <div>
                    <h3 class="mb-4 text-sm font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400">General Info</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Event Name</label>
                            <div class="mt-2 text-sm">
                                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 dark:bg-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="3" 
                                          class="block w-full rounded-md border-0 py-2 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 dark:bg-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-500 sm:text-sm sm:leading-6">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-1">
                            <label for="discount_percentage" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Discount Percentage (%)</label>
                            <div class="mt-2 relative rounded-md shadow-sm">
                                <input type="number" step="0.01" min="0" max="100" name="discount_percentage" id="discount_percentage" required value="{{ old('discount_percentage') }}"
                                       class="block w-full rounded-md border-0 py-2 pr-10 text-gray-900 dark:text-white ring-1 ring-inset ring-gray-300 dark:ring-gray-600 dark:bg-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-yellow-500 sm:text-sm sm:leading-6" placeholder="e.g. 15">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-gray-500 sm:text-sm">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scheduling -->
                <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                    <h3 class="mb-4 text-sm font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400">Scheduling</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="start_date" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Start Date & Time</label>
                            <div class="mt-2">
                                <input type="datetime-local" name="start_date" id="start_date" required value="{{ old('start_date') }}"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-inset focus:ring-yellow-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">End Date & Time</label>
                            <div class="mt-2">
                                <input type="datetime-local" name="end_date" id="end_date" required value="{{ old('end_date') }}"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-inset focus:ring-yellow-500 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activation -->
                <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                    <div class="relative flex items-start">
                        <div class="flex h-6 items-center">
                            <input id="is_active" name="is_active" value="1" type="checkbox" checked
                                   class="h-5 w-5 rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-gray-900 transition duration-200">
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="is_active" class="font-medium text-gray-900 dark:text-white">Active Status</label>
                            <p class="text-gray-500 dark:text-gray-400">If unchecked, the discount will be paused regardless of the dates.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-10 flex items-center justify-end gap-x-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                <a href="{{ route('admin.event-diskon.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300 hover:text-gray-500">Cancel</a>
                <button type="submit" class="rounded-md bg-yellow-500 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-yellow-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500 transition-colors">
                    Save Event
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
