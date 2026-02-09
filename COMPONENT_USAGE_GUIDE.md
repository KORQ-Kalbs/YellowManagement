# Component Usage Guide - Yellow Drink POS

## Overview

This guide provides examples of how to use the new reusable components in the Yellow Drink POS frontend.

## Card Component

**File:** `resources/views/components/card.blade.php`

### Basic Usage

```blade
<x-card>
    <p>This is card content</p>
</x-card>
```

### With Title

```blade
<x-card title="Card Title">
    <p>Card content goes here</p>
</x-card>
```

### Without Padding

```blade
<x-card noPadding="true">
    <!-- Table or other content that handles its own padding -->
    <x-table>...</x-table>
</x-card>
```

### With Custom Class

```blade
<x-card title="Danger Zone" class="border-red-200 dark:border-red-800">
    <p>Delete your account here</p>
</x-card>
```

---

## Stat Card Component

**File:** `resources/views/components/stat-card.blade.php`

### Basic Dashboard Stat

```blade
<x-stat-card
    label="Total Produk"
    :value="$productCount"
    color="blue"
>
    <x-slot name="icon">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
            <!-- SVG icon here -->
        </svg>
    </x-slot>
</x-stat-card>
```

### With Trend

```blade
<x-stat-card
    label="Revenue Today"
    :value="'Rp ' . number_format($revenue, 0, ',', '.')"
    color="green"
    trend="+12%"
    :trendUp="true"
>
    <x-slot name="icon">
        <!-- Icon SVG -->
    </x-slot>
</x-stat-card>
```

### Color Options

- `blue` - Information/Primary
- `green` - Success
- `yellow` - Warning
- `red` - Danger
- `purple` - Secondary

---

## Badge Component

**File:** `resources/views/components/badge.blade.php`

### Status Badges

```blade
<!-- Success -->
<x-badge type="success">Aktif</x-badge>

<!-- Pending -->
<x-badge type="pending">Menunggu Konfirmasi</x-badge>

<!-- Completed -->
<x-badge type="completed">Selesai</x-badge>

<!-- Cancelled -->
<x-badge type="cancelled">Dibatalkan</x-badge>

<!-- Info -->
<x-badge type="info">Informasi</x-badge>

<!-- Warning -->
<x-badge type="warning">Peringatan</x-badge>
```

---

## Table Components

**Files:** `resources/views/components/table*.blade.php`

### Complete Table Example

```blade
<x-card noPadding="true">
    <x-table>
        <x-table-head>
            <x-table-heading>Column 1</x-table-heading>
            <x-table-heading>Column 2</x-table-heading>
            <x-table-heading>Action</x-table-heading>
        </x-table-head>
        <x-table-body>
            @foreach($items as $item)
                <x-table-row>
                    <x-table-cell>{{ $item->name }}</x-table-cell>
                    <x-table-cell>{{ $item->email }}</x-table-cell>
                    <x-table-cell>
                        <a href="#">Edit</a>
                    </x-table-cell>
                </x-table-row>
            @endforeach
        </x-table-body>
    </x-table>

    <!-- Pagination -->
    @if(method_exists($items, 'links'))
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $items->links() }}
        </div>
    @endif
</x-card>
```

### Table with Complex Content

```blade
<x-table-row>
    <x-table-cell>
        <div>
            <p class="font-semibold">Primary text</p>
            <p class="text-xs text-gray-600">Secondary text</p>
        </div>
    </x-table-cell>
    <x-table-cell>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700">
            Badge
        </span>
    </x-table-cell>
</x-table-row>
```

---

## Button Components

**Files:** `resources/views/components/*-button.blade.php`

### Primary Button

```blade
<x-primary-button type="submit">Save Changes</x-primary-button>
```

### Secondary Button

```blade
<x-secondary-button type="button" onclick="closeModal()">Cancel</x-secondary-button>
```

### Danger Button

```blade
<x-danger-button type="submit">Delete</x-danger-button>
```

### Button with Icon

```blade
<x-primary-button>
    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <!-- Icon SVG -->
    </svg>
    Button Text
</x-primary-button>
```

---

## Layout Usage

**File:** `resources/views/layouts/app.blade.php`

### With Header Slot

```blade
<x-app-layout>
    <x-slot name="header">
        <h2>Page Title</h2>
        <p>Page description</p>
    </x-slot>

    <!-- Page content -->
    <div class="space-y-6">
        <!-- Your content here -->
    </div>
</x-app-layout>
```

### Multiple Sections

```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold">Transaksi</h2>
                <p class="text-sm text-gray-600">Manage transactions</p>
            </div>
            <a href="#" class="px-4 py-2 bg-yellow-500 text-white rounded">New</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <x-card>Filter</x-card>

        <!-- Table -->
        <x-card noPadding="true">
            <x-table>...</x-table>
        </x-card>
    </div>
</x-app-layout>
```

---

## Common Patterns

### Dashboard Header with Stats

```blade
<x-slot name="header">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Welcome back</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-600">{{ now()->format('d F Y') }}</p>
        </div>
    </div>
</x-slot>
```

### Action Buttons (Create, View, Edit, Delete)

```blade
<div class="flex items-center space-x-2">
    <a href="{{ route('edit', $item->id) }}" class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Edit
    </a>

    <form action="{{ route('destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center px-3 py-1 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Delete
        </button>
    </form>
</div>
```

### Empty State

```blade
<x-card>
    <div class="text-center py-16">
        <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <!-- Icon SVG -->
        </svg>
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">No items found</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Create one to get started</p>
    </div>
</x-card>
```

### Grid Layout

```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($items as $item)
        <x-card>
            <h3>{{ $item->name }}</h3>
            <!-- Content -->
        </x-card>
    @endforeach
</div>
```

### Form Layout

```blade
<x-card title="Edit Product">
    <form action="{{ route('product.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="space-y-4">
            <div>
                <x-input-label for="name" value="Product Name" />
                <x-text-input id="name" name="name" required />
                <x-input-error field="name" />
            </div>

            <div>
                <x-input-label for="price" value="Price" />
                <x-text-input id="price" name="price" type="number" step="0.01" required />
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <x-secondary-button type="button" onclick="goBack()">Cancel</x-secondary-button>
            <x-primary-button type="submit">Save</x-primary-button>
        </div>
    </form>
</x-card>
```

---

## Color Reference

### TailwindCSS Color Classes Used

```
Primary Actions: bg-yellow-500 hover:bg-yellow-600
Secondary: bg-gray-600 hover:bg-gray-700
Danger: bg-red-600 hover:bg-red-500
Success: bg-green-500 text-green-600
Warning: bg-yellow-600 text-yellow-600
Info: bg-blue-600 text-blue-600

Dark Mode Variants:
- hover:dark:bg-yellow-700
- dark:text-white
- dark:bg-gray-800
- dark:border-gray-700
```

---

## Responsive Breakpoints

```
Mobile First (Default): < 640px
md:  768px  and up   (sm in Tailwind)
lg:  1024px and up   (md in Tailwind)
xl:  1280px and up   (lg in Tailwind)

Usage Example:
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
  - 1 column on mobile
  - 2 columns on tablet (768px+)
  - 3 columns on desktop (1024px+)
</div>
```

---

## Best Practices

1. **Always use `x-app-layout`** for all authenticated pages
2. **Use slot syntax** for nested components
3. **Leverage TailwindCSS classes** - no inline styles
4. **Keep spacing consistent** - use space-y-\* utilities
5. **Use meaningful colors** - match the design system
6. **Test responsiveness** - check mobile, tablet, desktop
7. **Accessible forms** - always pair inputs with labels
8. **Dark mode** - test all components in dark mode
9. **Loading states** - provide feedback to users
10. **Error handling** - show validation errors clearly

---

## Need Help?

Reference files:

- Component definitions: `resources/views/components/`
- Dashboard examples: `resources/views/dashboard.blade.php`
- Kasir views: `resources/views/kasir-view/`
- Profile page: `resources/views/profile.blade.php`

For more TailwindCSS: https://tailwindcss.com/docs
For Laravel Blade: https://laravel.com/docs/blade
