@extends('layouts.app')

@section('content')
{{-- Menambahkan class animasi fade-in di sini --}}
<div class="container mx-auto px-4 py-4 sm:py-6 animate-fadeIn">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">Kategori Buku</h1>

    @if($categories->count())
        <!-- Diubah: dari <ul> menjadi grid layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($categories as $category)
                <!-- Diubah: dari <li> menjadi <a> dengan gaya kartu dan link -->
                <a href="{{ route('dashboard.category.books', $category->id) }}" class="block bg-white rounded-xl shadow-md p-4 sm:p-6 transition-transform hover:-translate-y-1 hover:shadow-lg">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ $category->name }}</h2>
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed">{{ $category->description }}</p>
                </a>
            @endforeach
        </div>

        <!-- Bagian pagination tetap sama -->
        <div class="mt-6 sm:mt-8">
            {{ $categories->links() }}
        </div>
    @else
        <p class="text-sm sm:text-base text-gray-600">Tidak ada kategori yang tersedia.</p>
    @endif
</div>
@endsection
