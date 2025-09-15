@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8">

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-blue-600 p-4 sm:p-6 text-white">
            <h1 class="text-xl sm:text-2xl font-bold">Detail Buku</h1>
            <p class="text-blue-100 mt-1 text-sm sm:text-base">Informasi lengkap tentang buku pilihan Anda</p>
        </div>

        <div class="p-4 sm:p-6 md:p-8 flex flex-col md:flex-row gap-6 md:gap-8">

            <div class="flex-shrink-0 mx-auto md:mx-0">
                <div class="relative group w-48 sm:w-56 md:w-64">
                    <img src="{{ Storage::url($book->cover_image) }}" alt="Cover {{ $book->title }}" class="w-full h-auto object-cover rounded-lg shadow-xl transition-transform duration-300 group-hover:scale-105">

                    @if($book->available)
                    <div class="absolute top-2 right-2 sm:top-3 sm:right-3 inline-flex items-center gap-1 sm:gap-1.5 bg-green-500 text-white text-xs font-bold px-2 sm:px-3 py-1 rounded-full">
                        <i class="fas fa-check-circle"></i> Tersedia
                    </div>
                    @else
                    <div class="absolute top-2 right-2 sm:top-3 sm:right-3 inline-flex items-center gap-1 sm:gap-1.5 bg-red-500 text-white text-xs font-bold px-2 sm:px-3 py-1 rounded-full">
                        <i class="fas fa-times-circle"></i> Tidak Tersedia
                    </div>
                    @endif
                </div>
            </div>

            <div class="flex-grow">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-800 mb-1">{{ $book->title }}</h2>
                <p class="text-lg sm:text-xl font-semibold text-gray-500 mb-4 sm:mb-6">Oleh: {{ $book->author }}</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="bg-blue-50/75 p-4 rounded-lg">
                        <h3 class="font-bold text-blue-800">Kategori</h3>
                        <p class="font-medium text-gray-700 mt-1">{{ $book->category->name ?? 'Tidak diketahui' }}</p>
                    </div>
                    <div class="bg-blue-50/75 p-4 rounded-lg">
                        <h3 class="font-bold text-blue-800">Tahun Terbit</h3>
                        <p class="font-medium text-gray-700 mt-1">{{ $book->year_published ?? 'Tidak diketahui' }}</p>
                    </div>
                    <div class="bg-blue-50/75 p-4 rounded-lg">
                        <h3 class="font-bold text-blue-800">Penerbit</h3>
                        <p class="font-medium text-gray-700 mt-1">{{ $book->publisher ?? 'Tidak diketahui' }}</p>
                    </div>
                    <div class="bg-blue-50/75 p-4 rounded-lg">
                        <h3 class="font-bold text-blue-800">Lokasi</h3>
                        <p class="font-medium text-gray-700 mt-1">{{ $book->location ?? 'Tidak diketahui' }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Deskripsi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $book->description ?? 'Deskripsi buku tidak tersedia.' }}
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    @if($book->available)
                    @if(auth()->check())
                    @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('dashboard.book.borrow.form', $book->id) }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-bold rounded-full transition-transform hover:scale-105 hover:bg-blue-700 active:scale-95">
                        <i class="fas fa-bookmark mr-2"></i> Pinjam Buku
                    </a>
                    @else
                    <button disabled class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-500 font-bold rounded-full cursor-not-allowed">
                        <i class="fas fa-times-circle mr-2"></i> Admin Tidak Dapat Pinjam
                    </button>
                    @endif
                    @else
                    <a href="{{ route('user.login') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-bold rounded-full transition-transform hover:scale-105 hover:bg-blue-700 active:scale-95">
                        <i class="fas fa-bookmark mr-2"></i> Login untuk Pinjam
                    </a>
                    @endif
                    @else
                    <button disabled class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-500 font-bold rounded-full cursor-not-allowed">
                        <i class="fas fa-bookmark mr-2"></i> Tidak Tersedia
                    </button>
                    @endif

                    <a href="{{ route('public.dashboard') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-white text-gray-700 font-bold rounded-full border border-gray-300 transition-transform hover:scale-105 hover:bg-gray-100 active:scale-95">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection