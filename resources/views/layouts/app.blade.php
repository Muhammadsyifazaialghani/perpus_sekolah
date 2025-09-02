<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center flex-wrap sm:flex-nowrap">
            
            <div class="flex items-center gap-3 w-full justify-center sm:w-auto sm:justify-start mb-2 sm:mb-0">
                <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <i class="fas fa-book-open text-3xl"></i>
                    <h1 class="text-2xl font-semibold tracking-wide">Perpustakaan Sekolah</h1>
                </a>
            </div>

            <nav class="flex gap-2 order-3 w-full justify-around mt-2 pt-2 border-t border-white/20 sm:order-none sm:w-auto sm:mt-0 sm:pt-0 sm:border-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-book text-lg"></i>
                    <span class="text-base font-medium hidden lg:inline">Buku</span>
                </a>
                <a href="{{ route ('dashboard.categories') }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-tags text-lg"></i>
                    <span class="text-base font-medium hidden lg:inline">Kategori</span>
                </a>
                <a href="{{ route('dashboard.return.form') }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-undo-alt text-lg"></i>
                    <span class="text-base font-medium hidden lg:inline">Pengembalian</span>
                </a>
            </nav>

            <div class="relative order-2 sm:order-none absolute top-3.5 right-4 sm:relative sm:top-auto sm:right-auto">
                @if(auth()->check())
                    <button id="profile-button" class="flex items-center gap-2.5 p-1.5 rounded-full transition-colors duration-300 hover:bg-white/15">
                        <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center font-semibold text-base">
                            <span>{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <span class="text-base font-medium hidden md:inline">{{ auth()->user()->name }}</span>
                        <svg id="dropdown-icon" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="profile-dropdown" class="absolute top-full right-0 mt-2.5 w-72 bg-white rounded-xl shadow-2xl z-50 overflow-hidden border border-gray-200/50 hidden">
                        <div class="p-5 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center font-bold text-xl">
                                    <span>{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-lg">{{ auth()->user()->name }}</p>
                                    <p class="text-sm opacity-90">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="py-2 text-gray-700">
<a href="{{ url('/user/profile') }}" class="flex items-center gap-3 px-5 py-3 text-base hover:bg-gray-100 transition-colors">
    <i class="fas fa-user-cog w-5 text-center text-gray-500"></i>
    <span>Pengaturan Akun</span>
</a>
                            <a href="{{ route('dashboard.borrow.history') }}" class="flex items-center gap-3 px-5 py-3 text-base hover:bg-gray-100 transition-colors">
                                <i class="fas fa-history w-5 text-center text-gray-500"></i>
                                <span>Riwayat Peminjaman</span>
                            </a>
                        </div>
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="flex items-center gap-3 px-5 py-3 text-base font-medium text-red-600 hover:bg-red-50 transition-colors border-t border-gray-100">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 rounded-md transition-colors duration-300 hover:bg-white/15">
                        <i class="fas fa-sign-in-alt"></i>
                        <span class="font-medium text-base">Login</span>
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>
    
    <script>
        // Memilih elemen yang diperlukan
        const profileButton = document.getElementById('profile-button');
        const dropdown = document.getElementById('profile-dropdown');
        const icon = document.getElementById('dropdown-icon');

        // Fungsi untuk membuka/menutup dropdown
        function toggleDropdown() {
            dropdown.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Menambahkan event listener ke tombol profil (jika ada)
        if (profileButton) {
            profileButton.addEventListener('click', function(event) {
                // Mencegah event 'click' menyebar ke document
                event.stopPropagation();
                toggleDropdown();
            });
        }

        // Menutup dropdown jika pengguna mengklik di luar area dropdown
        document.addEventListener('click', function(event) {
            if (dropdown && !dropdown.classList.contains('hidden')) {
                // Cek apakah target klik bukan dropdown itu sendiri atau tombol profil
                if (!dropdown.contains(event.target) && !profileButton.contains(event.target)) {
                    toggleDropdown();
                }
            }
        });
    </script>
</body>
</html>