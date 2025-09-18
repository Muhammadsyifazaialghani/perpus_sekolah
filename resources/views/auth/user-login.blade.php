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

<body class="bg-white-100 font-[Inter,sans-serif] text-gray-900 min-h-screen flex items-center justify-center p-4">

    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row w-full max-w-5xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">

            <div id="loginLeftSide" class="w-full lg:w-1/2 relative hidden lg:flex flex-col items-center justify-center text-center text-white p-12 transition-opacity duration-500">
                <div class="absolute inset-0 bg-blue-600 opacity-60"></div>
                <div class="relative z-10">
                    <i class="fas fa-book-open text-5xl mb-6"></i>
                    <h2 class="text-4xl font-bold mb-3">Selamat Datang Kembali!</h2>
                    <p class="text-gray-200 text-lg">Masuk untuk mengakses dunia pengetahuan di perpustakaan digital kami.</p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 p-8 sm:p-12">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Login</h1>
                <p class="text-gray-500 mb-8">
                    Belum punya akun?
                    <button type="button" onclick="openRegisterModal()" class="font-semibold text-indigo-600 hover:underline focus:outline-none">Daftar di sini</button>
                </p>

                @if ($errors->any() && !session('registration_error'))
                <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 border border-red-200 text-sm flex items-start">
                    <i class="fas fa-exclamation-circle mr-3 mt-1"></i>
                    <div>
                        <span class="font-bold">Terjadi Kesalahan:</span>
                        <ul class="list-disc list-inside mt-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                @if (session('success'))
                <div class="bg-green-50 text-green-800 p-4 rounded-lg mb-6 border border-green-200 text-sm font-medium flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-user text-gray-400"></i>
                            </span>
                            <input id="username" type="text" name="username" required autofocus
                                class="block w-full pl-10 px-4 py-3 text-base bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Masukkan username Anda" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </span>
                            <input id="password" type="password" name="password" required
                                class="block w-full pl-10 pr-10 px-4 py-3 text-base bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="••••••••" />
                            <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:underline">Lupa password?</a>
                    </div>

                    <button type="submit"
                        class="w-full py-3 text-base font-semibold text-white bg-indigo-600 rounded-lg shadow-md transition-all duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Login
                    </button>
                </form>

                <div class="text-center mt-8">
                    <a href="/" class="text-sm text-gray-500 transition-colors duration-300 hover:text-indigo-600">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="registerModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300 ease-in-out flex items-center justify-center p-4">
        <div id="registerModalContent" class="relative mx-auto border w-full max-w-lg shadow-lg rounded-xl bg-white transform transition-all duration-300 ease-in-out scale-95 opacity-0">
            <div class="p-8">
                <button onclick="closeRegisterModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl focus:outline-none" aria-label="Close modal">&times;</button>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Buat Akun Baru</h3>
                <p class="text-gray-600 mb-6">
                    Sudah punya akun?
                    <button type="button" onclick="closeRegisterModal()" class="text-indigo-600 hover:underline font-semibold focus:outline-none">Login di sini</button>
                </p>

                @if ($errors->any() && session('registration_error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p class="font-bold">Oops! Registrasi Gagal:</p>
                    <ul class="list-disc list-inside text-sm mt-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="modal_username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                        <input type="text" id="modal_username" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('username') }}" placeholder="Masukkan username Anda" required>
                    </div>

                    <div>
                        <label for="modal_email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" id="modal_email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                    </div>

                    <div>
                        <label for="modal_password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="modal_password" name="password" class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="••••••••" required>
                            <button type="button" onclick="togglePasswordVisibility('modal_password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="modal_password-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="modal_password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                        <input type="password" id="modal_password_confirmation" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:shadow-outline transition-colors duration-300 mt-4">
                        Daftar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRegisterModal() {
            const modal = document.getElementById('registerModal');
            const modalContent = document.getElementById('registerModalContent');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Mencegah scroll di background

            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeRegisterModal() {
            const modal = document.getElementById('registerModal');
            const modalContent = document.getElementById('registerModalContent');
            document.body.classList.remove('overflow-hidden');

            modalContent.classList.add('scale-95', 'opacity-0');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Sesuaikan dengan durasi transisi
        }

        // Fungsi baru untuk toggle visibilitas password
        function togglePasswordVisibility(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Menutup modal saat menekan tombol Escape
        window.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRegisterModal();
            }
        });

        // Menutup modal saat mengklik di luar konten modal
        document.getElementById('registerModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeRegisterModal();
            }
        });

        // Otomatis membuka modal registrasi jika ada error registrasi dari server
        // Menggunakan sintaks Blade yang lebih bersih
    </script>

    @if(session('registration_error'))
    <script>
        openRegisterModal();
    </script>
    @endif

</body>
</html>