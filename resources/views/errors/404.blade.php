<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - Perpustakaan Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Anda bisa menambahkan font custom di sini jika perlu */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-300 font-sans flex items-center justify-center h-screen text-center p-4">

    <div class="container max-w-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>

        <h1 class="text-9xl font-black text-slate-700 mt-4">404</h1>
        
        <h2 class="text-2xl font-semibold text-slate-200 mt-2">Halaman Hilang dari Rak</h2>
        
        <p class="mt-2 text-slate-400">
            Oops! Kami tidak dapat menemukan halaman yang Anda cari. Mungkin salah ketik atau halamannya sudah dipindahkan ke arsip.
        </p>

        <a href="{{ url('/') }}" class="mt-8 inline-block bg-sky-500 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-sky-600 transition-transform transform hover:scale-105">
            Kembali ke Halaman Utama
        </a>
    </div>

</body>
</html>