<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold tracking-[0.35em] text-yellow-600 uppercase dark:text-yellow-400">Asset Library</p>
                <h2 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Image Product Manager</h2>
                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    Manage every image stored in <span class="font-semibold">public/images</span>, keep metadata in sync, and upload new assets whenever you need them.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="button" @click="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'image-modal' })); resetImageForm();" class="inline-flex items-center px-4 py-2 font-medium text-white transition-colors rounded-lg bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Upload Image
                </button>
            </div>
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

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <x-card>
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-yellow-500/10 text-yellow-600 dark:text-yellow-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Images</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-green-500/10 text-green-600 dark:text-green-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Uploaded This Week</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['recent'] }}</p>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Visible on Page</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $images->count() }}</p>
                    </div>
                </div>
            </x-card>
        </div>

        <x-card>
            <form method="GET" class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div class="w-full lg:max-w-xl">
                    <x-input-label for="q" value="Search images" />
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" id="q" name="q" value="{{ $search }}" placeholder="Search by title or filename..." class="block w-full py-3 pl-10 pr-4 border border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="flex gap-2">
                    <x-secondary-button type="submit">Filter</x-secondary-button>
                    @if($search !== '')
                        <a href="{{ route('admin.img-product.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">Reset</a>
                    @endif
                </div>
            </form>
        </x-card>

        <x-card noPadding="true">
            @if($images->count() > 0)
                <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach($images as $image)
                        <article class="overflow-hidden border border-gray-200 shadow-sm group rounded-2xl bg-white/80 dark:bg-gray-800/80 dark:border-gray-700">
                            <div class="relative aspect-square bg-gray-100 dark:bg-gray-700">
                                <img src="{{ $image->url }}" alt="{{ $image->alt_text ?? $image->display_name }}" class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute top-3 left-3 rounded-full bg-black/60 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-white backdrop-blur">
                                    {{ strtoupper(pathinfo($image->file_name, PATHINFO_EXTENSION)) }}
                                </div>
                                @if($image->product)
                                    <div class="absolute top-3 right-3 rounded-full bg-emerald-600/90 px-2.5 py-1 text-[11px] font-semibold text-white backdrop-blur">
                                        Linked
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 space-y-4">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-1">{{ $image->display_name }}</h3>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 break-all">{{ $image->original_name }}</p>
                                </div>

                                <div class="flex items-center justify-between gap-3 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Linked product</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $image->product?->nama_produk ?? 'Not linked' }}</span>
                                </div>

                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>{{ $image->human_size }}</span>
                                    <span>{{ $image->created_at->format('d M Y') }}</span>
                                </div>

                                <div class="flex gap-2">
                                    <button type="button" onclick="editImage({{ $image->id }}, @js($image->title), @js($image->alt_text), @js($image->original_name), @js($image->url), @js($image->display_name), @js($image->product_id))" class="inline-flex flex-1 items-center justify-center px-3 py-2 text-sm font-medium text-blue-600 transition-colors rounded-lg bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50">
                                        Edit
                                    </button>

                                    <button type="button" onclick="editImage({{ $image->id }}, @js($image->title), @js($image->alt_text), @js($image->original_name), @js($image->url), @js($image->display_name), @js($image->product_id))" class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-yellow-700 transition-colors rounded-lg bg-yellow-50 dark:bg-yellow-900/30 dark:text-yellow-300 hover:bg-yellow-100 dark:hover:bg-yellow-900/50">
                                        Link
                                    </button>

                                    <form action="{{ route('admin.img-product.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-red-600 transition-colors rounded-lg bg-red-50 dark:bg-red-900/30 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if(method_exists($images, 'links'))
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $images->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-16 text-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-2xl bg-yellow-500/10 text-yellow-600 dark:text-yellow-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">No images found</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Upload an image to start building the media library.</p>
                </div>
            @endif
        </x-card>
    </div>

    <x-modal name="image-modal" :show="false">
        <div class="p-6">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="image-modal-title">Upload Image</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Store a new image in <span class="font-semibold">public/images</span>.</p>
                </div>
                <button type="button" class="text-gray-400 transition-colors hover:text-gray-600 dark:hover:text-gray-200" x-on:click="$dispatch('close')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="image-form" method="POST" action="{{ route('admin.img-product.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="image-method" name="_method" value="POST">
                <input type="hidden" id="image-id" name="id">

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="image-title" value="Title" />
                            <input type="text" id="image-title" name="title" class="block w-full px-4 py-3 mt-1 border border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Optional title">
                        </div>

                        <div>
                            <x-input-label for="image-alt" value="Alt Text" />
                            <input type="text" id="image-alt" name="alt_text" class="block w-full px-4 py-3 mt-1 border border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Optional alt text">
                        </div>

                        <div>
                            <x-input-label for="image-product-id" value="Link to Product" />
                            <select id="image-product-id" name="product_id" class="block w-full px-4 py-3 mt-1 border border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">-- No linked product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->nama_produk }}</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Choose a product to keep the image library and product image synchronized.</p>
                        </div>

                        <div>
                            <x-input-label for="image-file" value="Image File" />
                            <input type="file" id="image-file" name="image" accept="image/*" class="block w-full px-4 py-3 mt-1 border border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Allowed: JPG, JPEG, PNG, WEBP, GIF, SVG. Max 5 MB.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="overflow-hidden border border-dashed border-gray-300 rounded-2xl dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50">
                            <div class="p-3 border-b border-dashed border-gray-300 dark:border-gray-600">
                                <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase dark:text-gray-400">Preview</p>
                            </div>
                            <div class="flex items-center justify-center p-4 min-h-64">
                                <img id="image-preview" src="" alt="Preview" class="hidden object-contain max-h-64 rounded-xl shadow-sm">
                                <div id="image-preview-empty" class="text-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm">Your selected image will appear here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                    <x-primary-button type="submit" id="image-submit-button">Save Image</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        const imageModalRoutes = {
            store: @json(route('admin.img-product.store')),
            update: @json(route('admin.img-product.update', ['productImage' => '__ID__'])),
        };

        function resetImageForm() {
            document.getElementById('image-modal-title').textContent = 'Upload Image';
            document.getElementById('image-form').action = imageModalRoutes.store;
            document.getElementById('image-method').value = 'POST';
            document.getElementById('image-id').value = '';
            document.getElementById('image-title').value = '';
            document.getElementById('image-alt').value = '';
            document.getElementById('image-product-id').value = '';
            document.getElementById('image-file').value = '';
            document.getElementById('image-preview').src = '';
            document.getElementById('image-preview').classList.add('hidden');
            document.getElementById('image-preview-empty').classList.remove('hidden');
            document.getElementById('image-submit-button').textContent = 'Save Image';
        }

        function openImageModal() {
            resetImageForm();
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'image-modal' }));
        }

        function editImage(id, title, altText, originalName, imageUrl, displayName, productId = '') {
            document.getElementById('image-modal-title').textContent = 'Edit Image';
            document.getElementById('image-form').action = imageModalRoutes.update.replace('__ID__', id);
            document.getElementById('image-method').value = 'PUT';
            document.getElementById('image-id').value = id;
            document.getElementById('image-title').value = title || displayName || '';
            document.getElementById('image-alt').value = altText || '';
            document.getElementById('image-product-id').value = productId || '';
            document.getElementById('image-file').value = '';
            document.getElementById('image-preview').src = imageUrl;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('image-preview-empty').classList.add('hidden');
            document.getElementById('image-submit-button').textContent = 'Update Image';
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'image-modal' }));
        }

        document.getElementById('image-file')?.addEventListener('change', function(event) {
            const file = event.target.files?.[0];
            if (!file) {
                return;
            }

            const preview = document.getElementById('image-preview');
            const emptyState = document.getElementById('image-preview-empty');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            emptyState.classList.add('hidden');
        });
    </script>
</x-app-layout>