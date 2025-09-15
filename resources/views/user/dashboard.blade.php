@extends('layouts.app')

{{-- TIDAK PERLU BLOK STYLE LAGI --}}

@section('content')
{{-- Cukup tambahkan class 'animate-fadeIn' yang sudah dibuat di tailwind.config.js --}}
<div class="bg-gradient-to-br from-gray-50 to-slate-200 min-h-screen animate-fadeIn">
    <div class="container mx-auto p-4 md:p-6 lg:p-8">

        {{-- Header Section --}}
        <div class="text-center mb-6 sm:mb-10">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2 tracking-tight">Daftar Buku</h1>
            <p class="text-base sm:text-lg text-gray-500">Jelajahi koleksi buku kami dan temukan bacaan favorit Anda berikutnya.</p>
        </div>

        {{-- Search Form --}}
        <form action="{{ auth()->check() ? route('dashboard.search') : route('public.dashboard.search') }}" method="GET" class="mb-6 sm:mb-10 max-w-2xl mx-auto px-4">
            <div class="relative flex items-center">
                <input
                    type="text"
                    name="query"
                    placeholder="Cari berdasarkan judul atau penulis..."
                    class="w-full py-3 sm:py-4 pl-4 sm:pl-6 pr-24 sm:pr-32 text-sm sm:text-base text-gray-700 bg-white border-none rounded-full focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-300 shadow-lg"
                    value="{{ request('query') }}">
                <button
                    type="submit"
                    class="absolute top-1/2 right-2.5 transform -translate-y-1/2 px-4 sm:px-8 py-2 sm:py-2.5 text-sm sm:text-base text-white font-semibold bg-gradient-to-r from-blue-600 to-indigo-700 rounded-full hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300">
                    Cari
                </button>
            </div>
        </form>

        {{-- Session Messages --}}
        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-lg mb-6 shadow-md max-w-4xl mx-auto" role="alert">
            <p class="font-semibold">Oops!</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-md max-w-4xl mx-auto" role="alert">
            <p class="font-semibold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        {{-- Books Grid --}}
        @if($books->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($books as $book)
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:-translate-y-2 flex flex-col group">
                {{-- Book Cover Image --}}
                <div class="relative h-64 overflow-hidden">
                    @if($book->cover_image)
                    <img src="{{ Storage::url($book->cover_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Cover {{ $book->title }}">
                    @else
                    {{-- Fallback placeholder --}}
                    <img src="https://placehold.co/600x400/e2e8f0/4a5568?text={{ urlencode($book->title) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Placeholder Cover {{ $book->title }}">
                    @endif

                    {{-- Availability Badge --}}
                    @if($book->available)
                    <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Tersedia</span>
                    @else
                    <span class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">Tidak Tersedia</span>
                    @endif
                </div>

                {{-- Book Information --}}
                <div class="p-5 flex flex-col flex-grow">
                    <h5 class="text-lg font-bold text-gray-800 mb-1 truncate" title="{{ $book->title }}">{{ $book->title }}</h5>
                    <p class="text-sm text-gray-500 mb-5">Oleh: {{ $book->author }}</p>

                    {{-- Action Buttons --}}
                    <div class="mt-auto space-y-3">
                        <a href="{{ auth()->check() ? route('dashboard.book.detail', $book->id) : route('public.book.detail', $book->id) }}" class="block w-full text-center bg-blue-50 text-blue-600 font-semibold py-2.5 px-4 rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:scale-105">
                            Detail
                        </a>

                        @if($book->available)
                        @if(auth()->check())
                        @if(auth()->user()->role !== 'admin')
                        <a href="{{ route('dashboard.book.borrow.form', $book->id) }}" class="block w-full text-center bg-green-100 text-green-600 font-semibold py-2.5 px-4 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 transform hover:scale-105">
                            Pinjam
                        </a>
                        @else
                        <button class="w-full text-center bg-gray-200 text-gray-500 font-medium py-2.5 px-4 rounded-full cursor-not-allowed" disabled>
                            Admin Tidak Dapat Pinjam
                        </button>
                        @endif
                        @else
                        <a href="{{ route('user.login') }}" class="block w-full text-center bg-green-100 text-green-600 font-semibold py-2.5 px-4 rounded-full hover:bg-green-500 hover:text-white transition-all duration-300 transform hover:scale-105">
                            Login untuk Pinjam
                        </a>
                        @endif
                        @else
                        <button class="w-full text-center bg-gray-200 text-gray-500 font-medium py-2.5 px-4 rounded-full cursor-not-allowed" disabled>
                            Tidak Tersedia
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination Links --}}
        <div class="mt-12">
            {{ $books->links() }}
        </div>

        @else
        {{-- No Books Found Message --}}
        <div class="bg-white p-12 rounded-xl shadow-md text-center text-gray-500 mt-10">
            <svg class="mx-auto h-16 w-16 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v11.494m-9-5.747h18" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <p class="mt-4 text-lg font-medium">Tidak ada buku yang ditemukan.</p>
            <p class="text-sm">Coba gunakan kata kunci lain untuk mencari.</p>
        </div>
        @endif
    </div>
</div>
@endsection