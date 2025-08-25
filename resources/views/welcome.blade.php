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
                @if(auth()->check())
                    {{-- User is logged in --}}
                    <a href="{{ route('dashboard') }}" class="inline-block px-8 py-3 text-base font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <button type="submit" class="inline-block px-8 py-3 text-base font-semibold text-blue-600 bg-transparent border-2 border-blue-600 rounded-lg transition-all duration-300 hover:bg-blue-600 hover:text-white hover:-translate-y-0.5">
                            Logout
                        </button>
                    </form>
                @else
                    {{-- User is not logged in --}}
                    <a href="{{ route('public.dashboard') }}" class="inline-block px-8 py-3 text-base font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-0.5 hover:shadow-lg">
                        Lihat Semua Buku
                    </a>
                    <a href="{{ route('login') }}" class="inline-block px-8 py-3 text-base font-semibold text-blue-600 bg-transparent border-2 border-blue-600 rounded-lg transition-all duration-300 hover:bg-blue-600 hover:text-white hover:-translate-y-0.5">
                        Login
                    </a>
                @endif
            </div>
        </div>

        <section class="mt-20">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 text-center mb-12 animate-fade-in">
                Buku Pilihan Kami ✨
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 animate-fade-in" style="animation-delay: 0.2s;">
                    <img src="https://placehold.co/400x600/60a5fa/white?text=Bumi" alt="Sampul Buku Bumi" class="w-full h-64 object-cover">
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Bumi</h3>
                        <p class="text-slate-500 text-sm mb-4">Oleh: Tere Liye</p>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6 flex-grow">Novel ini menceritakan petualangan tiga remaja yang menemukan dunia paralel dan kekuatan unik dalam diri mereka.</p>
                        <a href="#" class="mt-auto block w-full text-center px-6 py-3 text-base font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
                            Lihat Detail
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 animate-fade-in" style="animation-delay: 0.4s;">
                    <img src="https://placehold.co/400x600/34d399/white?text=Laskar\nPelangi" alt="Sampul Buku Laskar Pelangi" class="w-full h-64 object-cover">
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Laskar Pelangi</h3>
                        <p class="text-slate-500 text-sm mb-4">Oleh: Andrea Hirata</p>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6 flex-grow">Kisah inspiratif tentang perjuangan sekelompok anak di Belitung untuk mendapatkan pendidikan yang layak.</p>
                        <a href="#" class="mt-auto block w-full text-center px-6 py-3 text-base font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
                            Lihat Detail
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 animate-fade-in" style="animation-delay: 0.6s;">
                    <img src="https://placehold.co/400x600/fbbf24/white?text=Sapiens" alt="Sampul Buku Sapiens" class="w-full h-64 object-cover">
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Sapiens</h3>
                        <p class="text-slate-500 text-sm mb-4">Oleh: Yuval Noah Harari</p>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6 flex-grow">Sebuah riwayat singkat umat manusia, dari zaman batu hingga prediksi masa depan spesies kita.</p>
                        <a href="#" class="mt-auto block w-full text-center px-6 py-3 text-base font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </section>
        </main>

</body>
</html>