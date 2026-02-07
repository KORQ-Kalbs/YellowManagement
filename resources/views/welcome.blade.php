<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yellow Drink - Minuman Segar Pilihan Terbaik</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'yellow-brand': '#FFD700',
                        'yellow-light': '#FFF4CC',
                        'yellow-dark': '#FFA500',
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #FFD700;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #FFA500;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>

<body class="min-h-screen antialiased bg-gradient-to-br from-yellow-50 via-white to-orange-50">
    
    <!-- Floating Login Button -->
    @if (Route::has('login'))
        <div class="fixed z-50 top-4 right-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold rounded-full shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold rounded-full shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                    Login Kasir
                </a>
            @endauth
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative flex items-center justify-center min-h-screen px-4 py-20 overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute bg-yellow-200 rounded-full -top-40 -right-40 w-80 h-80 mix-blend-multiply filter blur-3xl opacity-30 float-animation"></div>
            <div class="absolute bg-orange-200 rounded-full -bottom-40 -left-40 w-80 h-80 mix-blend-multiply filter blur-3xl opacity-30 float-animation" style="animation-delay: 1s;"></div>
        </div>

        <div class="relative max-w-6xl mx-auto text-center fade-in">
            <!-- Logo/Brand -->
            <div class="mb-8">
                <h1 class="mb-4 text-6xl font-bold text-transparent md:text-8xl bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-500 to-orange-400">
                    Yellow Drink
                </h1>
                <p class="text-xl font-medium text-gray-700 md:text-2xl">
                    🥤 Semua Berhak Minum Enak
                </p>
            </div>

            <!-- Store Image -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl transform hover:scale-[1.02] transition-transform duration-500">
                    <img src="/api/placeholder/1200/600" alt="Yellow Drink Store" class="w-full h-auto">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col items-center justify-center gap-4 mb-16 sm:flex-row">
                <a href="#menu" class="flex items-center gap-2 px-8 py-4 font-bold text-gray-900 transition-all duration-300 transform rounded-full shadow-lg group bg-gradient-to-r from-yellow-400 to-yellow-500 hover:shadow-xl hover:scale-105">
                    <span>Lihat Menu</span>
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#location" class="px-8 py-4 font-bold text-gray-900 transition-all duration-300 transform bg-white border-2 border-yellow-400 rounded-full shadow-lg hover:shadow-xl hover:scale-105">
                    Lokasi Kami
                </a>
            </div>

            <!-- Stats -->
            <div class="grid max-w-3xl grid-cols-3 gap-8 mx-auto">
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-yellow-500 md:text-5xl">10+</div>
                    <div class="text-sm text-gray-600 md:text-base">Varian Menu</div>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-yellow-500 md:text-5xl">100%</div>
                    <div class="text-sm text-gray-600 md:text-base">Segar</div>
                </div>
                <div class="text-center">
                    <div class="mb-2 text-4xl font-bold text-yellow-500 md:text-5xl">⭐ 4.8</div>
                    <div class="text-sm text-gray-600 md:text-base">Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Best Seller Section -->
    <section id="menu" class="px-4 py-20 bg-white">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="mb-16 text-center">
                <span class="inline-block px-6 py-2 mb-4 text-sm font-semibold text-yellow-600 bg-yellow-100 rounded-full">
                    🔥 POPULER
                </span>
                <h2 class="mb-4 text-4xl font-bold text-gray-900 md:text-5xl">
                    Best Seller
                </h2>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">
                    Menu favorit pelanggan yang paling banyak dipesan
                </p>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 gap-6 mb-12 md:grid-cols-2 lg:grid-cols-4">
                <!-- Product Card 1 - Boba & Cream -->
                <div class="relative p-8 overflow-hidden transition-all duration-300 transform shadow-lg cursor-pointer group bg-gradient-to-br from-pink-400 to-pink-500 rounded-3xl hover:scale-105 hover:shadow-2xl">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-br from-white/10 to-transparent group-hover:opacity-100"></div>
                    
                    <div class="relative z-10">
                        <!-- Product Image Placeholder -->
                        <div class="flex items-center justify-center w-40 h-40 mx-auto mb-6 bg-pink-200 rounded-full">
                            <svg class="w-20 h-20 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="mb-2 text-2xl font-bold text-center text-white">
                            Boba & Cream
                        </h3>
                        <p class="mb-4 text-sm text-center text-pink-100">
                            Perpaduan boba kenyal dengan cream lembut
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-white">
                                Rp 18K
                            </span>
                            <button class="px-4 py-2 font-semibold text-pink-500 transition-colors bg-white rounded-full hover:bg-pink-50">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 - Mangga Yakult -->
                <div class="relative p-8 overflow-hidden transition-all duration-300 transform shadow-lg cursor-pointer group bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-3xl hover:scale-105 hover:shadow-2xl">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-br from-white/10 to-transparent group-hover:opacity-100"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-center w-40 h-40 mx-auto mb-6 bg-yellow-200 rounded-full">
                            <svg class="w-20 h-20 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="mb-2 text-2xl font-bold text-center text-gray-900">
                            Mangga Yakult
                        </h3>
                        <p class="mb-4 text-sm text-center text-gray-700">
                            Segar manisnya mangga dengan yakult
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-gray-900">
                                Rp 15K
                            </span>
                            <button class="px-4 py-2 font-semibold text-yellow-500 transition-colors bg-white rounded-full hover:bg-yellow-50">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 - Brown Sugar -->
                <div class="relative p-8 overflow-hidden transition-all duration-300 transform shadow-lg cursor-pointer group bg-gradient-to-br from-amber-600 to-amber-700 rounded-3xl hover:scale-105 hover:shadow-2xl">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-br from-white/10 to-transparent group-hover:opacity-100"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-center w-40 h-40 mx-auto mb-6 rounded-full bg-amber-300">
                            <svg class="w-20 h-20 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="mb-2 text-2xl font-bold text-center text-white">
                            Brown Sugar
                        </h3>
                        <p class="mb-4 text-sm text-center text-amber-100">
                            Manis legit brown sugar milk
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-white">
                                Rp 16K
                            </span>
                            <button class="px-4 py-2 font-semibold transition-colors bg-white rounded-full text-amber-600 hover:bg-amber-50">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 4 - Taro Latte -->
                <div class="relative p-8 overflow-hidden transition-all duration-300 transform shadow-lg cursor-pointer group bg-gradient-to-br from-purple-400 to-purple-500 rounded-3xl hover:scale-105 hover:shadow-2xl">
                    <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-br from-white/10 to-transparent group-hover:opacity-100"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-center w-40 h-40 mx-auto mb-6 bg-purple-200 rounded-full">
                            <svg class="w-20 h-20 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="mb-2 text-2xl font-bold text-center text-white">
                            Taro Latte
                        </h3>
                        <p class="mb-4 text-sm text-center text-purple-100">
                            Creamy taro dengan susu segar
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-white">
                                Rp 17K
                            </span>
                            <button class="px-4 py-2 font-semibold text-purple-500 transition-colors bg-white rounded-full hover:bg-purple-50">
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Menu Button -->
            <div class="text-center">
                <button class="px-8 py-4 font-bold text-gray-900 transition-all duration-300 transform rounded-full shadow-lg bg-gradient-to-r from-yellow-400 to-orange-400 hover:shadow-xl hover:scale-105">
                    Lihat Semua Menu
                </button>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="px-4 py-20 bg-gradient-to-br from-yellow-50 to-orange-50">
        <div class="max-w-6xl mx-auto">
            <div class="grid items-center gap-12 md:grid-cols-2">
                <!-- Image Side -->
                <div class="order-2 md:order-1">
                    <div class="relative overflow-hidden shadow-2xl rounded-3xl">
                        <img src="/api/placeholder/600/700" alt="Tentang Yellow Drink" class="w-full h-auto">
                    </div>
                </div>

                <!-- Content Side -->
                <div class="order-1 md:order-2">
                    <span class="inline-block px-6 py-2 mb-4 text-sm font-semibold text-yellow-600 bg-yellow-100 rounded-full">
                        Tentang Kami
                    </span>
                    <h2 class="mb-6 text-4xl font-bold text-gray-900 md:text-5xl">
                        Yellow Drink
                    </h2>
                    <p class="mb-6 text-lg leading-relaxed text-gray-600">
                        Yellow Drink adalah UMKM minuman kekinian yang berkomitmen menyajikan minuman berkualitas dengan harga terjangkau. Kami menggunakan bahan-bahan pilihan dan resep original untuk menciptakan rasa yang unik dan menyegarkan.
                    </p>
                    <p class="mb-8 text-lg leading-relaxed text-gray-600">
                        Dengan visi "Semua Berhak Minum Enak", kami ingin memberikan pengalaman minum yang menyenangkan untuk semua kalangan.
                    </p>

                    <!-- Features -->
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-yellow-400 rounded-full">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-gray-900">Bahan Berkualitas</h3>
                                <p class="text-gray-600">100% menggunakan bahan pilihan terbaik</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-yellow-400 rounded-full">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-gray-900">Harga Terjangkau</h3>
                                <p class="text-gray-600">Minuman enak dengan harga ramah di kantong</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-yellow-400 rounded-full">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-gray-900">Pelayanan Cepat</h3>
                                <p class="text-gray-600">Proses pemesanan yang efisien dan ramah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section id="location" class="px-4 py-20 bg-white">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="mb-16 text-center">
                <span class="inline-block px-6 py-2 mb-4 text-sm font-semibold text-yellow-600 bg-yellow-100 rounded-full">
                    📍 Kunjungi Kami
                </span>
                <h2 class="mb-4 text-4xl font-bold text-gray-900 md:text-5xl">
                    Lokasi Toko
                </h2>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">
                    Temukan kami dan nikmati minuman segar favorit Anda
                </p>
            </div>

            <div class="grid gap-12 md:grid-cols-2">
                <!-- Map -->
                <div class="overflow-hidden shadow-xl rounded-3xl">
                    <div class="flex items-center justify-center w-full bg-gray-200 h-96">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-gray-600">Google Maps Integration</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="space-y-6">
                    <div class="p-8 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-3xl">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-yellow-400 rounded-full">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-bold text-gray-900">Alamat</h3>
                                <p class="text-gray-600">
                                    Jl. Contoh No. 123<br>
                                    Jakarta Selatan, DKI Jakarta<br>
                                    Indonesia 12345
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 mb-6">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-yellow-400 rounded-full">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-bold text-gray-900">Jam Operasional</h3>
                                <p class="text-gray-600">
                                    Senin - Jumat: 09.00 - 21.00<br>
                                    Sabtu - Minggu: 10.00 - 22.00
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-yellow-400 rounded-full">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-2 text-lg font-bold text-gray-900">Kontak</h3>
                                <p class="text-gray-600">
                                    Telepon: +62 812-3456-7890<br>
                                    Email: info@yellowdrink.com
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="p-8 text-center bg-gradient-to-br from-yellow-400 to-orange-400 rounded-3xl">
                        <h3 class="mb-4 text-2xl font-bold text-gray-900">
                            Follow Us
                        </h3>
                        <div class="flex justify-center gap-4">
                            <a href="#" class="flex items-center justify-center w-12 h-12 transition-transform bg-white rounded-full hover:scale-110">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="flex items-center justify-center w-12 h-12 transition-transform bg-white rounded-full hover:scale-110">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="#" class="flex items-center justify-center w-12 h-12 transition-transform bg-white rounded-full hover:scale-110">
                                <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="px-4 py-12 text-white bg-gray-900">
        <div class="max-w-6xl mx-auto">
            <div class="grid gap-8 mb-8 md:grid-cols-4">
                <div class="md:col-span-2">
                    <h3 class="mb-4 text-3xl font-bold text-yellow-400">Yellow Drink</h3>
                    <p class="mb-4 text-gray-400">
                        UMKM minuman kekinian dengan komitmen menyajikan minuman berkualitas untuk semua kalangan.
                    </p>
                </div>
                
                <div>
                    <h4 class="mb-4 text-lg font-bold">Menu</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#menu" class="transition-colors hover:text-yellow-400">Best Seller</a></li>
                        <li><a href="#menu" class="transition-colors hover:text-yellow-400">Semua Menu</a></li>
                        <li><a href="#about" class="transition-colors hover:text-yellow-400">Tentang Kami</a></li>
                        <li><a href="#location" class="transition-colors hover:text-yellow-400">Lokasi</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="mb-4 text-lg font-bold">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>+62 812-3456-7890</li>
                        <li>info@yellowdrink.com</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 text-center text-gray-400 border-t border-gray-800">
                <p>&copy; {{ date('Y') }} Yellow Drink. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281234567890" target="_blank" class="fixed z-50 flex items-center justify-center transition-all duration-300 transform bg-green-500 rounded-full shadow-lg bottom-6 right-6 w-14 h-14 hover:bg-green-600 hover:shadow-xl hover:scale-110">
        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>

</body>
</html>