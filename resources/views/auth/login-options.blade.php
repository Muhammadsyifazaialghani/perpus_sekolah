<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Login - Perpustakaan Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for a modern, clean look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter,sans-serif] text-gray-800 min-h-screen flex items-center justify-center p-4">

    <!-- Login Options Container -->
    <div class="w-full max-w-sm sm:max-w-md md:max-w-lg text-center bg-white p-6 sm:p-8 md:p-12 rounded-2xl border border-gray-200 shadow-xl">

        <!-- Header -->
        <h1 class="text-2xl sm:text-3xl font-bold text-indigo-600 mb-2">
            Pilih Jenis Login
        </h1>
        <p class="text-sm sm:text-base text-gray-500 mb-6 sm:mb-10">
            Silakan pilih jenis akun Anda untuk masuk ke sistem perpustakaan.
        </p>

        <!-- User Login Option -->
        <a href="{{ route('user.login') }}"
           class="block my-4 sm:my-6 p-4 sm:p-6 bg-white border-2 border-gray-200 rounded-lg transition-all duration-300 ease-in-out hover:bg-gray-50 hover:border-indigo-600 hover:-translate-y-1 hover:shadow-md">
            <div class="text-2xl sm:text-3xl mb-2">👤</div>
            <h3 class="text-lg sm:text-xl font-semibold text-indigo-600 mb-1">
                Login sebagai User
            </h3>
            <p class="text-xs sm:text-sm text-gray-500">
                Untuk siswa, guru, dan staf sekolah yang sudah terdaftar.
            </p>
        </a>

        <!-- Admin Login Option -->
        <a href="/admin"
           class="block my-4 sm:my-6 p-4 sm:p-6 bg-white border-2 border-gray-200 rounded-lg transition-all duration-300 ease-in-out hover:bg-gray-50 hover:border-indigo-600 hover:-translate-y-1 hover:shadow-md">
            <div class="text-2xl sm:text-3xl mb-2">🔐</div>
            <h3 class="text-lg sm:text-xl font-semibold text-indigo-600 mb-1">
                Login sebagai Admin
            </h3>
            <p class="text-xs sm:text-sm text-gray-500">
                Untuk administrator dan staf perpustakaan.
            </p>
        </a>
        
        <!-- Back Link -->
        <a href="/" class="inline-block mt-8 text-sm text-gray-500 transition-colors duration-300 hover:text-indigo-600">
            &larr; Kembali ke Beranda
        </a>
    </div>

</body>
</html>
