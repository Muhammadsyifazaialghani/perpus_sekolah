<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login - Sistem Perpustakaan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="{{ asset('css/filament/filament/app.css') }}" />

    @livewireStyles
</head>

<body class="antialiased font-sans bg-gray-50">

    <div class="relative">

        <div class="absolute inset-0 -z-10 h-full w-full bg-white bg-[linear-gradient(to_right,#f0f0f0_1px,transparent_1px),linear-gradient(to_bottom,#f0f0f0_1px,transparent_1px)] bg-[size:6rem_4rem]">
            <div class="absolute bottom-0 left-0 right-0 top-0 bg-[radial-gradient(circle_800px_at_100%_200px,#d5c5ff,transparent)]"></div>
        </div>


        <div class="min-h-screen w-full flex flex-col items-center justify-center p-4">

            <div class="w-full max-w-md mx-auto">
                <div class="text-center mb-8">
                    <svg class="mx-auto h-12 w-auto text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                    <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900">
                        Sistem Perpustakaan
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Login untuk Panel Admin
                    </p>
                </div>

                <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-xl border border-gray-200/50">
                    <form wire:submit.prevent="authenticate" class="space-y-6">
                        {{ $this->form }}

                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/20 text-sm font-semibold text-white bg-gradient-to-br from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-50 transition-all duration-300 ease-in-out transform hover:scale-[1.03] active:scale-100">
                            Login
                        </button>
                    </form>
                </div>

                <div class="mt-8 text-center">
                    <a href="/login" class="text-sm font-medium text-gray-500 transition-colors duration-300 hover:text-indigo-600">
                            &larr; Kembali ke Pilihan Login
                        </a>
                </div>
            </div>
        </div>

    </div> @livewireScripts
</body>

</html>