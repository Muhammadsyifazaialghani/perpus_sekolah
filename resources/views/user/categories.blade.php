@extends('layouts.app')

@section('content')
{{-- Menambahkan class animasi fade-in di sini --}}
<div class="container mx-auto px-4 py-6 animate-fadeIn">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Kategori Buku</h1>
    
    @if($categories->count())
        <!-- Diubah: dari <ul> menjadi grid layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <!-- Diubah: dari <li> menjadi <div> dengan gaya kartu -->
                <div class="bg-white rounded-xl shadow-md p-6 transition-transform hover:-translate-y-1 hover:shadow-lg">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $category->name }}</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $category->description }}</p>
                </div>
            @endforeach
        </div>

        <!-- Bagian pagination tetap sama -->
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    @else
        <p class="text-base text-gray-600">Tidak ada kategori yang tersedia.</p>
    @endif
</div>
@endsection