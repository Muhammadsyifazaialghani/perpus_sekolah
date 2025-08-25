<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800 leading-relaxed">

    <header class="bg-gradient-to-br from-blue-600 to-blue-700 text-white py-8 shadow-md">
        <div class="max-w-7xl mx-auto px-5">
            <h1 class="text-3xl md:text-4xl font-bold text-center">Perpustakaan Sekolah</h1>
        </div>
    </header>
    
   
    <main class="max-w-7xl mx-auto px-5 py-12 md:py-16">
        <div class="bg-white rounded-xl p-8 md:p-10 shadow-xl max-w-3xl mx-auto text-center transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl animate-fade-in">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">Selamat Datang di Perpustakaan</h2>
            <p class="text-base md:text-lg text-slate-500 mb-8 max-w-xl mx-auto">Sistem perpustakaan sekolah yang sederhana dan mudah digunakan.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('public.dashboard') }}" class="inline-block px-8 py-3 text-base font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg">
                    Lihat Semua Buku
                </a>
                <a href="{{ route('login') }}" class="inline-block px-8 py-3 text-base font-semibold text-blue-600 bg-transparent border-2 border-blue-600 rounded-lg transition-all duration-300 hover:bg-blue-600 hover:text-white hover:-translate-y-0.5">
                    Login
                </a>
            </div>
        </div>
    </main>

</body>
</html>