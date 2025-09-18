<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-slate-50 font-sans text-slate-800 leading-relaxed">
<!-- BERANDA PERPUS SEKOLAH -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-slate-200">
        <nav class="max-w-7xl mx-auto px-5 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">PerpusSekolah</a>
            <div class="hidden sm:flex items-center gap-4">
                @if(auth()->check())
                @if(auth()->user()->role === 'admin')
                <a href="{{ url('/admin') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600">Admin Dashboard</a>
                @else
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-0.5">Logout</button>
                </form>
                @else
                <a href="{{ route('public.dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600">Semua Buku</a>
                <button onclick="showLoginModal()" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md transition-all duration-300 hover:bg-blue-700 hover:-translate-y-0.5">Login</button>
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
                <!-- PESAN JIKA TIDAK ADA BUKU PILIHAN -->
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mt-6">Cari Buku</h3>
                    <p class="text-slate-500 mt-2">Gunakan fitur pencarian untuk menemukan buku yang Anda inginkan berdasarkan judul atau penulis.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg transform hover:-translate-y-2 transition-all duration-300 animate-fade-in" style="animation-delay: 0.9s;">
                    <div class="bg-blue-100 text-blue-600 rounded-full h-16 w-16 flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mt-6">Ajukan Peminjaman</h3>
                    <p class="text-slate-500 mt-2">Klik tombol pinjam pada halaman detail buku dan tunggu konfirmasi dari pustakawan.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg transform hover:-translate-y-2 transition-all duration-300 animate-fade-in" style="animation-delay: 1.1s;">
                    <div class="bg-blue-100 text-blue-600 rounded-full h-16 w-16 flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mt-6">Ambil & Baca</h3>
                    <p class="text-slate-500 mt-2">Ambil buku fisik di perpustakaan dan nikmati petualangan membaca Anda!</p>
                </div>
            </div>
        </section>
    </main>
<!--LOGIN POP UP 2 USER-->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 relative animate-fade-in">
            <button onclick="hideLoginModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Pilih Jenis Login</h2>
            <div class="space-y-4">
                <a href="{{ route('user.login') }}" class="flex items-center justify-center gap-3 p-4 w-full bg-blue-50 rounded-lg hover:bg-blue-100">
                    <span class="p-2 bg-blue-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <div class="text-left">
                        <h3 class="font-semibold text-slate-900">Login sebagai User</h3>
                        <p class="text-sm text-slate-500">Untuk siswa, guru, dan staf sekolah yang sudah terdaftar.</p>
                    </div>
                </a>

                <a href="/admin" class="flex items-center justify-center gap-3 p-4 w-full bg-blue-50 rounded-lg hover:bg-blue-100">
                    <span class="p-2 bg-blue-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    <div class="text-left">
                        <h3 class="font-semibold text-slate-900">Login sebagai Admin</h3>
                        <p class="text-sm text-slate-500">Untuk administrator dan staf perpustakaan.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <footer class="border-t border-slate-200 mt-20">
        <div class="max-w-7xl mx-auto px-5 py-6 text-center text-slate-500 text-sm">
            <p>&copy; {{ date('Y') }} Perpustakaan Sekolah. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
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

        function showLoginModal() {
            document.getElementById('loginModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function hideLoginModal() {
            document.getElementById('loginModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    </script>
</body>

</html>