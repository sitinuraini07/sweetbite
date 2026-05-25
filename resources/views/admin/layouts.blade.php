<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - SweetBite</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex">

    <div class="w-64 bg-gray-800 text-white min-h-screen p-4">
        <h2 class="text-xl mb-4">ADMIN</h2>
        <a href="/admin/products" class="block mb-2 hover:text-blue-300">📦 Produk</a>
        <a href="/admin/categories" class="block mb-2 hover:text-blue-300">📂 Kategori</a>
        <a href="/admin/orders" class="block mb-2 hover:text-blue-300">📜 Pesanan</a>
    </div>

    <div class="flex-1 p-6">
        @if(session('success'))
            <div class="bg-green-200 p-3 mb-4">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

</div>

</body>
</html>