<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Perpustakaan Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter,sans-serif] text-gray-900 min-h-screen flex items-center justify-center">

    <div class="container mx-auto p-4">
        <div class="flex flex-col lg:flex-row w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- Left Column: Illustration & Welcome Text -->
            <div class="w-full lg:w-1/2 bg-gray-50 p-8 sm:p-12 flex flex-col items-center justify-center text-center">
                <!-- Admin-specific SVG illustration -->
                <svg class="w-2/3 mb-6" viewBox="0 0 200 150" xmlns="http://www.w3.org/2000/svg">
                    <rect x="10" y="30" width="180" height="100" rx="10" fill="#E5E7EB"/>
                    <path d="M 30 50 L 170 50 L 170 110 L 30 110 Z" fill="#FFFFFF" stroke="#D1D5DB" stroke-width="2"/>
                    <rect x="40" y="60" width="20" height="15" rx="2" fill="#A5B4FC"/>
                    <rect x="70" y="60" width="20" height="15" rx="2" fill="#A5B4FC"/>
                    <rect x="100" y="60" width="20" height="15" rx="2" fill="#A5B4FC"/>
                    <rect x="130" y="60" width="20" height="15" rx="2" fill="#A5B4FC"/>
                    <rect x="40" y="85" width="50" height="15" rx="2" fill="#C7D2FE"/>
                    <rect x="100" y="85" width="50" height="15" rx="2" fill="#C7D2FE"/>
                    <circle cx="160" cy="40" r="8" fill="#4F46E5"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Admin Control Panel</h2>
                <p class="text-gray-500">Silakan login untuk mengelola sistem perpustakaan.</p>
            </div>

            <!-- Right Column: Login Form -->
            <div class="w-full lg:w-1/2 p-8 sm:p-12">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">Admin Login</h1>

                <!-- Display Messages -->
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

                <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                        <input id="username" type="text" name="username" required autofocus 
                               class="block w-full px-4 py-3 text-base bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                               placeholder="Enter your admin username" />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" name="password" required 
                               class="block w-full px-4 py-3 text-base bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder:text-gray-400 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                               placeholder="Enter your password" />
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full py-3 text-base font-semibold text-white bg-indigo-600 rounded-lg shadow-md transition-all duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Login
                        </button>
                    </div>
                </form>

                 <div class="text-center mt-8">
                    <a href="/login" class="text-sm text-gray-500 transition-colors duration-300 hover:text-indigo-600">
                        &larr; Kembali ke Pilihan Login
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
