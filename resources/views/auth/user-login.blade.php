<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Perpustakaan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-[Inter,sans-serif] text-gray-900 min-h-screen flex items-center justify-center">

    <div class="container mx-auto p-4">
        <div class="flex flex-col lg:flex-row w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">

            <div class="w-full lg:w-1/2 bg-gray-50 p-8 sm:p-12 flex flex-col items-center justify-center text-center">
                <i class="fas fa-book-open text-3xl"></i>
                <rect x="10" y="30" width="180" height="100" rx="10" fill="#E5E7EB" />
                <rect x="25" y="45" width="150" height="70" rx="5" fill="#FFFFFF" stroke="#D1D5DB" stroke-width="2" />
                <line x1="40" y1="60" x2="160" y2="60" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" />
                <line x1="40" y1="75" x2="130" y2="75" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" />
                <line x1="40" y1="90" x2="160" y2="90" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" />
                <circle cx="150" cy="105" r="8" fill="#6366F1" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang Kembali!</h2>
                <p class="text-gray-500">Masuk untuk mengakses koleksi perpustakaan digital kami.</p>
            </div>

            <div class="w-full lg:w-1/2 p-8 sm:p-12">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Login</h1>
                <p class="text-gray-500 mb-8">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:underline">Daftar di sini</a>
                </p>

                @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 border border-red-200 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 border border-green-200 text-sm font-medium">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                        <input id="username" type="text" name="username" required autofocus
                            class="block w-full px-4 py-3 text-base bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your username" />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required
                            class="block w-full px-4 py-3 text-base bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your password" />
                    </div>

                    <div class="text-right">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">Lupa password?</a>
                    </div>

                    <button type="submit"
                        class="w-full py-3 text-base font-semibold text-white bg-indigo-600 rounded-lg shadow-md transition-all duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Login
                    </button>
                </form>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                    
                    </div>
                </div>
                <div class="text-center mt-8">
                    <a href="/" class="text-sm text-gray-500 transition-colors duration-300 hover:text-indigo-600">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>