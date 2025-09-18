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
                    <i class="fas fa-book-open text-2xl sm:text-3xl"></i>
                    <h1 class="text-xl sm:text-2xl font-semibold tracking-wide">Perpustakaan Sekolah</h1>
                </a>
            </div>

            <nav class="flex gap-1 sm:gap-2 order-3 w-full justify-around mt-2 pt-2 border-t border-white/20 sm:order-none sm:w-auto sm:mt-0 sm:pt-0 sm:border-0">
                @if(auth()->check() && auth()->user()->role === 'admin')
                <!-- ADMIN NAVBAR -->
                <a href="{{ route('dashboard') }}" id="nav-buku" class="flex items-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-book text-base sm:text-lg"></i>
                    <span class="text-sm sm:text-base font-medium hidden md:inline">Buku</span>
                </a>
                <a href="{{ route('dashboard.categories') }}" id="nav-kategori" class="flex items-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-tags text-base sm:text-lg"></i>
                    <span class="text-sm sm:text-base font-medium hidden md:inline">Kategori</span>
                </a>
                <a href="{{ route('dashboard.return.form') }}" id="nav-dashboard" class="flex items-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-undo-alt text-base sm:text-lg"></i>
                    <span class="text-sm sm:text-base font-medium hidden md:inline">Pengembalian</span>
                </a>
                @else
                <!-- USER NAVBAR -->
                <a href="{{ route('dashboard') }}" id="nav-buku" class="flex items-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-book text-base sm:text-lg"></i>
                    <span class="text-sm sm:text-base font-medium hidden md:inline">Buku</span>
                </a>
                <a href="{{ route ('dashboard.categories') }}" id="nav-kategori" class="flex items-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-tags text-base sm:text-lg"></i>
                    <span class="text-sm sm:text-base font-medium hidden md:inline">Kategori</span>
                </a>
                <a href="{{ route('dashboard.return.form') }}" id="nav-pengembalian" class="flex items-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 rounded-md transition-all duration-300 hover:bg-white/15 hover:-translate-y-0.5">
                    <i class="fas fa-undo-alt text-base sm:text-lg"></i>
                    <span class="text-sm sm:text-base font-medium hidden md:inline">Pengembalian</span>
                </a>
                @endif
            </nav>

            <div class="relative order-2 sm:order-none w-full flex justify-center sm:w-auto sm:block">
                @if(auth()->check())
                @if(auth()->user()->role === 'admin')
                <button id="profile-button" class="flex items-center gap-2.5 p-1.5 rounded-full transition-colors duration-300 hover:bg-white/15">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center font-semibold text-base">
                        <span>{{ substr(auth()->user()->username, 0, 1) }}</span>
                    </div>
                    <span class="text-base font-medium hidden md:inline">{{ auth()->user()->username }}</span>
                    <svg id="dropdown-icon" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="profile-dropdown" class="absolute top-full left-1/2 transform -translate-x-1/2 sm:left-auto sm:translate-x-0 sm:right-0 mt-2.5 w-72 bg-white rounded-xl shadow-2xl z-50 overflow-hidden border border-gray-200/50 hidden">
                    <div class="p-5 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center font-bold text-xl">
                                <span>{{ substr(auth()->user()->username, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-lg">{{ auth()->user()->username }}</p>
                                <p class="text-sm opacity-90">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- HIDE PENGATURAN AKUN DI ADMIN -->
                    <!-- <div class="py-2 text-gray-700">
                                <a href="/admin/profile" class="flex items-center gap-3 px-5 py-3 text-base hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user-cog w-5 text-center text-gray-500"></i>
                                    <span>Pengaturan Akun</span>
                                </a>
                            </div> -->
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
                <button id="profile-button" class="flex items-center gap-2.5 p-1.5 rounded-full transition-colors duration-300 hover:bg-white/15">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center font-semibold text-base">
                        <span>{{ substr(auth()->user()->username, 0, 1) }}</span>
                    </div>
                    <span class="text-base font-medium hidden md:inline">{{ auth()->user()->username }}</span>
                    <svg id="dropdown-icon" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="profile-dropdown" class="absolute top-full left-1/2 transform -translate-x-1/2 sm:left-auto sm:translate-x-0 sm:right-0 mt-2.5 w-72 bg-white rounded-xl shadow-2xl z-50 overflow-hidden border border-gray-200/50 hidden">
                    <div class="p-5 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center font-bold text-xl">
                                <span>{{ substr(auth()->user()->username, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-lg">{{ auth()->user()->username }}</p>
                                <p class="text-sm opacity-90">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-2 text-gray-700">
                        <a href="{{ url('/user/profile') }}" class="flex items-center gap-3 px-5 py-3 text-base hover:bg-gray-100 transition-colors relative">
                            <i class="fas fa-user-cog w-5 text-center text-gray-500"></i>
                            <span>Pengaturan Akun</span>
                            @if(isset($fineCount) && $fineCount > 0)
                            <span class="absolute top-2 right-3 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                +{{ $fineCount }}
                            </span>
                            @endif
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
                @endif
                @else
                <button id="login-button" class="flex items-center gap-2 px-4 py-2 rounded-md transition-colors duration-300 hover:bg-white/15 focus:outline-none">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="font-medium text-base">Login</span>
                </button>

                <!-- LOGIN POP UP 2 USER -->
                <div id="login-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 relative">
                        <button id="login-modal-close" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none" aria-label="Close modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <h2 class="text-2xl font-bold text-slate-900 mb-6">Pilih Jenis Login</h2>
                        <div class="space-y-4">
                            <a href="{{ route('user.login') }}" class="flex w-full items-center gap-4 rounded-lg border border-slate-200 bg-white p-4 hover:bg-slate-50 transition-colors">
                                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-blue-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <div class="text-left">
                                    <h3 class="font-semibold text-slate-900">Login sebagai User</h3>
                                    <p class="text-sm text-slate-500">Untuk siswa, guru, dan staf sekolah yang sudah terdaftar.</p>
                                </div>
                            </a>

                            <a href="/admin" class="flex w-full items-center gap-4 rounded-lg border border-slate-200 bg-white p-4 hover:bg-slate-50 transition-colors">
                                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-blue-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
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
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <script>
        // BUAT NAVBAR DIATAS KALO DI KLIK PROFILE
        const profileButton = document.getElementById('profile-button');
        const dropdown = document.getElementById('profile-dropdown');
        const icon = document.getElementById('dropdown-icon');

        function toggleDropdown() {
            dropdown.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        if (profileButton) {
            profileButton.addEventListener('click', function(event) {
                event.stopPropagation();
                toggleDropdown();
            });
        }

        document.addEventListener('click', function(event) {
            if (dropdown && !dropdown.classList.contains('hidden')) {
                if (!dropdown.contains(event.target) && !profileButton.contains(event.target)) {
                    toggleDropdown();
                }
            }
        });

        // UNTUK OPSI LOGIN 2 USER
        const loginButton = document.getElementById('login-button');
        const loginModal = document.getElementById('login-modal');
        const loginModalClose = document.getElementById('login-modal-close');

        function toggleLoginModal() {
            loginModal.classList.toggle('hidden');
        }

        if (loginButton) {
            loginButton.addEventListener('click', function(event) {
                event.stopPropagation();
                toggleLoginModal();
            });
        }

        if (loginModalClose) {
            loginModalClose.addEventListener('click', function() {
                toggleLoginModal();
            });
        }

        if (loginModal) {
            loginModal.addEventListener('click', function(event) {
                if (event.target === loginModal) {
                    toggleLoginModal();
                }
            });
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && loginModal && !loginModal.classList.contains('hidden')) {
                toggleLoginModal();
            }
        });
        
        // UNTUK NAVBAR BUKU, KATEGORI, PENGEMBALIAN KALO BELUM LOGIN
        const isLoggedIn = JSON.parse('@json(auth()->check())');

        if (!isLoggedIn) {
            const navBuku = document.getElementById('nav-buku');
            const navKategori = document.getElementById('nav-kategori');
            const navPengembalian = document.getElementById('nav-pengembalian');

            [navBuku, navKategori, navPengembalian].forEach(navItem => {
                if (navItem) {
                    navItem.addEventListener('click', function(event) {
                        event.preventDefault();
                        toggleLoginModal();
                    });
                }
            });
        }
    </script>
</body>

</html>