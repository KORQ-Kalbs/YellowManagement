<x-app-layout>
	<x-slot name="header">
		<div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
			<div>
				<p class="text-xs font-semibold tracking-[0.35em] text-yellow-600 uppercase dark:text-yellow-400">Dashboard Settings</p>
				<h2 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Welcome & Menu Control</h2>
				<p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Edit the content used by <span class="font-semibold">welcome.blade.php</span> and <span class="font-semibold">menu.blade.php</span> without touching the templates.</p>
			</div>

			@if($activeDiscount)
				<div class="px-4 py-3 text-sm border rounded-2xl border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-100">
					<div class="font-semibold">Active discount</div>
					<div>{{ $activeDiscount->name }} - {{ floatval($activeDiscount->discount_percentage) }}%</div>
				</div>
			@endif
		</div>
	</x-slot>

	<div class="space-y-6">
		@if(session('success'))
			<div class="px-4 py-3 text-green-800 bg-green-100 rounded-xl dark:bg-green-900/30 dark:text-green-300">{{ session('success') }}</div>
		@endif

		@if(session('error'))
			<div class="px-4 py-3 text-red-800 bg-red-100 rounded-xl dark:bg-red-900/30 dark:text-red-300">{{ session('error') }}</div>
		@endif

		<x-card>
			<div class="space-y-6">
				<div class="flex items-center justify-between gap-3">
					<div>
						<h3 class="text-lg font-bold text-gray-900 dark:text-white">Welcome Page Content</h3>
						<p class="text-sm text-gray-600 dark:text-gray-400">JSON structure for the landing page hero, features, about, and location sections.</p>
					</div>
					@if($welcomeSetting)
						<form method="POST" action="{{ route('admin.dashboard-setting.destroy', $welcomeSetting) }}" onsubmit="return confirm('Reset welcome settings to defaults?')">
							@csrf
							@method('DELETE')
							<x-secondary-button type="submit">Reset</x-secondary-button>
						</form>
					@endif
				</div>

				<form method="POST" action="{{ $welcomeSetting ? route('admin.dashboard-setting.update', $welcomeSetting) : route('admin.dashboard-setting.store') }}" class="space-y-4">
					@csrf
					@if($welcomeSetting)
						@method('PUT')
					@endif
					<input type="hidden" name="page" value="welcome">

					<div>
						<label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Content JSON</label>
						<textarea name="content_json" rows="28" class="w-full px-4 py-3 font-mono text-sm text-gray-800 bg-white border border-gray-300 rounded-2xl dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('content_json', json_encode($welcomeSetting?->content ?? \App\Models\DashboardSetting::defaultsForPage('welcome'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) }}</textarea>
						@error('content_json')
							<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex justify-end">
						<x-primary-button type="submit">Save Welcome Settings</x-primary-button>
					</div>
				</form>
			</div>
		</x-card>

		<x-card>
			<div class="space-y-6">
				<div class="flex items-center justify-between gap-3">
					<div>
						<h3 class="text-lg font-bold text-gray-900 dark:text-white">Menu Page Content</h3>
						<p class="text-sm text-gray-600 dark:text-gray-400">Control the menu page title, subtitle, empty state, and CTA text.</p>
					</div>
					@if($menuSetting)
						<form method="POST" action="{{ route('admin.dashboard-setting.destroy', $menuSetting) }}" onsubmit="return confirm('Reset menu settings to defaults?')">
							@csrf
							@method('DELETE')
							<x-secondary-button type="submit">Reset</x-secondary-button>
						</form>
					@endif
				</div>

				<form method="POST" action="{{ $menuSetting ? route('admin.dashboard-setting.update', $menuSetting) : route('admin.dashboard-setting.store') }}" class="space-y-4">
					@csrf
					@if($menuSetting)
						@method('PUT')
					@endif
					<input type="hidden" name="page" value="menu">

					<div>
						<label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Content JSON</label>
						<textarea name="content_json" rows="18" class="w-full px-4 py-3 font-mono text-sm text-gray-800 bg-white border border-gray-300 rounded-2xl dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('content_json', json_encode($menuSetting?->content ?? \App\Models\DashboardSetting::defaultsForPage('menu'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) }}</textarea>
						@error('content_json')
							<p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
						@enderror
					</div>

					<div class="flex justify-end">
						<x-primary-button type="submit">Save Menu Settings</x-primary-button>
					</div>
				</form>
			</div>
		</x-card>
	</div>
</x-app-layout>
