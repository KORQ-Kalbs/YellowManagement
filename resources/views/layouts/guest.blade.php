<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="@yield('htmlClass')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $title ?? config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    @stack('guest-fonts')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('guest-head')
</head>
<body class="@yield('bodyClass', 'font-sans antialiased text-gray-900')">
    @if(trim($__env->yieldContent('content')))
        @yield('content')
    @else
        <!-- Header Bar -->
        <div class="bg-yellow-400 h-16 flex items-center px-6">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-yellow-700" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6z" />
                </svg>
                <span class="text-xl font-bold text-yellow-700">Yellow Drink</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-[calc(100vh-64px)] bg-yellow-50 px-4 py-8">
            <!-- Card -->
            <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Card Header with Logo -->
                <div class="bg-gradient-to-b from-yellow-50 to-white px-6 py-8 text-center border-b border-yellow-100">
                    <div class="flex justify-center mb-4">
                        <svg class="w-24 h-24" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Drink Cup -->
                            <path d="M25 30H75V75C75 80.5228 70.5228 85 65 85H35C29.4772 85 25 80.5228 25 75V30Z" fill="url(#paint0_linear)" stroke="#F59E0B" stroke-width="2"/>
                            <!-- Straw -->
                            <line x1="45" y1="10" x2="45" y2="35" stroke="#DC2626" stroke-width="3" stroke-linecap="round"/>
                            <!-- Bubbles -->
                            <circle cx="65" cy="45" r="3" fill="#FBBF24" opacity="0.6"/>
                            <circle cx="35" cy="55" r="2" fill="#FBBF24" opacity="0.6"/>
                            <defs>
                                <linearGradient id="paint0_linear" x1="50" y1="30" x2="50" y2="85" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="#FCD34D"/>
                                    <stop offset="100%" stop-color="#F59E0B"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-yellow-500 mb-1">Yellow Drink</h1>
                    <p class="text-sm text-gray-600">{{ $title ?? 'POS Management System' }}</p>
                </div>

                <!-- Card Content -->
                <div class="px-6 py-8">
                    {{ $slot ?? '' }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>© 2026 Yellow Drink</p>
            </div>
        </div>
    @endif

    @stack('guest-scripts')
</body>
</html>
