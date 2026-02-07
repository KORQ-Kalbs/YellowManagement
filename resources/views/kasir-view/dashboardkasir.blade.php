<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <title>Yellow Drink Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-yellow-50">

 <aside class="w-64 p-6 text-white bg-yellow-400">
        <h1 class="mb-8 text-2xl font-bold">YellowDrink</h1>

        <nav class="space-y-4">
            <a href="#" class="block p-2 rounded hover:bg-yellow-500">Dashboard</a>
            <a href="#" class="block p-2 rounded hover:bg-yellow-500">Produk</a>
            <a href="#" class="block p-2 rounded hover:bg-yellow-500">Transaksi</a>
            <a href="#" class="block p-2 rounded hover:bg-yellow-500">Laporan</a>
        </nav>
    </aside>
    
    <main class="flex-1 p-8">


<div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold">Dashboard</h2>
            <div class="px-4 py-2 bg-white rounded shadow">
                Admin
            </div>
        </div>

  <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="p-6 bg-white shadow rounded-xl">
                <p class="text-gray-500">Total Produk</p>
                <h3 class="text-2xl font-bold">24</h3>
            </div>

            <div class="p-6 bg-white shadow rounded-xl">
                <p class="text-gray-500">Transaksi Hari Ini</p>
                <h3 class="text-2xl font-bold">12</h3>
            </div>

            <div class="p-6 bg-white shadow rounded-xl">
                <p class="text-gray-500">Pendapatan</p>
                <h3 class="text-2xl font-bold">Rp 350.000</h3>
            </div>
        </div>       
    </main>
</body> 
</html>
