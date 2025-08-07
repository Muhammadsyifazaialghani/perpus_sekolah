@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detail Buku</h1>

    <div class="mb-4">
        <h2 class="text-xl font-semibold">{{ $book->title }}</h2>
        <p class="text-gray-700">Penulis: {{ $book->author }}</p>
        <p class="text-gray-700">
            Status: 
            @if($book->available)
                <span class="text-green-600 font-semibold">Tersedia</span>
            @else
                <span class="text-red-600 font-semibold">Tidak tersedia</span>
            @endif
        </p>
    </div>

    <a href="{{ route('dashboard.book.borrow.form', $book->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Pinjam Buku
    </a>

    <a href="{{ route('dashboard') }}" class="ml-4 text-gray-600 hover:underline">Kembali ke Dashboard</a>
</div>
@endsection
