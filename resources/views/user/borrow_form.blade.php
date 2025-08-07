@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Form Peminjaman Buku</h1>

    <div class="mb-4">
        <h2 class="text-xl font-semibold">{{ $book->title }}</h2>
        <p class="text-gray-700">Penulis: {{ $book->author }}</p>
    </div>

    <form action="{{ route('dashboard.book.borrow.confirm', $book->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="borrowed_at" class="block text-gray-700 font-semibold mb-2">Tanggal Pinjam</label>
            <input type="date" id="borrowed_at" name="borrowed_at" value="{{ old('borrowed_at', date('Y-m-d')) }}" class="border p-2 rounded w-full" required>
        </div>

        <div class="mb-4">
            <label for="due_at" class="block text-gray-700 font-semibold mb-2">Tanggal Kembali</label>
            <input type="date" id="due_at" name="due_at" value="{{ old('due_at', date('Y-m-d', strtotime('+2 weeks'))) }}" class="border p-2 rounded w-full" required>
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Konfirmasi Peminjaman</button>
    </form>

    <a href="{{ route('dashboard.book.detail', $book->id) }}" class="mt-4 inline-block text-gray-600 hover:underline">Kembali ke Detail Buku</a>
</div>
@endsection
