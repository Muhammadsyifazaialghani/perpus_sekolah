@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard - Daftar Buku</h1>

    <form action="{{ route('dashboard.search') }}" method="GET" class="mb-4">
        <input type="text" name="query" placeholder="Cari buku..." class="border p-2 rounded w-full" value="{{ request('query') }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Cari</button>
    </form>

    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($books->count())
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Judul</th>
                    <th class="py-2 px-4 border-b">Penulis</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $book->author }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($book->available)
                            <span class="text-green-600 font-semibold">Tersedia</span>
                        @else
                            <span class="text-red-600 font-semibold">Tidak tersedia</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('dashboard.book.detail', $book->id) }}" class="text-blue-600 hover:underline mr-2">Detail</a>
                        @if($book->available)
                        <a href="{{ route('dashboard.book.borrow.form', $book->id) }}" class="text-green-600 hover:underline">Pinjam</a>
                        @else
                        <span class="text-gray-400">Pinjam</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $books->links() }}
        </div>
    @else
        <p>Tidak ada buku ditemukan.</p>
    @endif
</div>
@endsection
