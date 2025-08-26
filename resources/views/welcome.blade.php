<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
            opacity: 0; /* Mulai dari transparan untuk mencegah FOUC */
            animation-fill-mode: forwards; /* Memastikan state akhir animasi tetap berlaku */
        }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 leading-relaxed">

    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-slate-200">
        <nav class="max-w-7xl mx-auto px-5 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">PerpusSekolah</a>
            <div class="hidden sm:flex items-center gap-4">
                 @if(auth()->check())
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-0.5">Logout</button>
                    </form>
                 @else
                    <a href="{{ route('public.dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Semua Buku</a>
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-0.5">Login</a>
                 @endif
            </div>
        </nav>
    </header>
    
    <main class="max-w-7xl mx-auto px-5 py-12 md:py-16">
        <div class="text-center py-16 md:py-24 animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4 leading-tight">Selamat Datang Di Perpustakaan</h1>
            <p class="text-base md:text-lg text-slate-500 mb-8 max-w-2xl mx-auto">Sistem perpustakaan sekolah yang sederhana dan mudah digunakan.</p>
            <a href="{{ route('public.dashboard') }}" class="inline-block px-8 py-3 text-base font-semibold text-white bg-blue-600 rounded-lg shadow-lg transition-all duration-300 hover:bg-blue-700 hover:-translate-y-1 hover:shadow-xl">
                Mulai Menjelajah
            </a>
        </div>

        <section class="mt-16 md:mt-20">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 text-center mb-12 animate-fade-in" style="animation-delay: 0.2s;">
                Buku Pilihan Kami ✨
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                {{-- Bagian ini sekarang dinamis dari controller --}}
                @if(isset($featuredBooks) && $featuredBooks->count())
                    @foreach($featuredBooks as $book)
                        @php
                            $delay = 0.4 + ($loop->index * 0.2);
                            $coverImage = $book->cover_image ? Storage::url($book->cover_image) : 'https://placehold.co/600x400/e2e8f0/4a5568?text=' . urlencode($book->title);
                        @endphp
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 animate-fade-in">
                        <img src="{{ $coverImage }}" alt="Sampul Buku {{ $book->title }}" class="w-full h-80 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 mb-2 truncate" title="{{ $book->title }}">{{ $book->title }}</h3>
                            <p class="text-slate-500 text-sm mb-4">Oleh: {{ $book->author }}</p>
                            <p class="text-slate-600 text-sm leading-relaxed mb-6 flex-grow">
                                {{ \Illuminate\Support\Str::limit($book->description, 120) }}
                            </p>
                            <a href="{{ route('public.book.detail', $book->id) }}" class="mt-auto block w-full text-center px-6 py-3 text-base font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:shadow-lg">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    {{-- Pesan jika tidak ada buku pilihan yang dikirim dari controller --}}
                    <div class="md:col-span-2 lg:col-span-3 text-center text-slate-500 py-10">
                        <p>Saat ini tidak ada buku pilihan untuk ditampilkan.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="mt-24 md:mt-32">
            <div class="text-center animate-fade-in" style="animation-delay: 0.5s;">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Meminjam Buku Semudah 1-2-3</h2>
                <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto">Proses peminjaman dirancang agar cepat dan tidak merepotkan bagi semua siswa.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 text-center">
                <div class="bg-white p-8 rounded-2xl shadow-lg transform hover:-translate-y-2 transition-all duration-300 animate-fade-in" style="animation-delay: 0.7s;">
                    <div class="bg-blue-100 text-blue-600 rounded-full h-16 w-16 flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mt-6">Cari Buku</h3>
                    <p class="text-slate-500 mt-2">Gunakan fitur pencarian untuk menemukan buku yang Anda inginkan berdasarkan judul atau penulis.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg transform hover:-translate-y-2 transition-all duration-300 animate-fade-in" style="animation-delay: 0.9s;">
                    <div class="bg-blue-100 text-blue-600 rounded-full h-16 w-16 flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mt-6">Ajukan Peminjaman</h3>
                    <p class="text-slate-500 mt-2">Klik tombol pinjam pada halaman detail buku dan tunggu konfirmasi dari pustakawan.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg transform hover:-translate-y-2 transition-all duration-300 animate-fade-in" style="animation-delay: 1.1s;">
                    <div class="bg-blue-100 text-blue-600 rounded-full h-16 w-16 flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mt-6">Ambil & Baca</h3>
                    <p class="text-slate-500 mt-2">Ambil buku fisik di perpustakaan dan nikmati petualangan membaca Anda!</p>
                </div>
            </div>
        </section>

        {{-- Sisa bagian lainnya tetap sama --}}
        
    </main>

    <footer class="border-t border-slate-200 mt-20">
        <div class="max-w-7xl mx-auto px-5 py-6 text-center text-slate-500 text-sm">
            <p>&copy; {{ date('Y') }} Perpustakaan Sekolah. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>