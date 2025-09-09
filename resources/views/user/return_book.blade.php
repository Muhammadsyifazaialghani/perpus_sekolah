@extends('layouts.app')

@section('content')
{{-- Latar belakang halaman dibuat sedikit abu-abu agar card menonjol --}}
<div class="bg-gray-100 min-h-screen py-10 px-4 animate-fadeIn">

    {{-- Form dibungkus dalam sebuah 'card' yang modern --}}
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8">
        
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-8">Formulir Pengembalian Buku</h1>

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6" role="alert">
                <p class="font-bold">Oops!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if($borrowings->count() > 0)
            <form action="{{ route('dashboard.return.process') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Setiap field form diberi styling yang konsisten --}}
                <div>
                    <label for="borrowing_id" class="block text-sm font-medium text-gray-700">Pilih Buku yang Ingin Dikembalikan</label>
                    <select id="borrowing_id" name="borrowing_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Pilih dari buku pinjaman Anda --</option>
                        @foreach($borrowings as $borrowing)
                            <option value="{{ $borrowing->id }}">
                                {{ $borrowing->book->title }} (Jatuh tempo: {{ \Carbon\Carbon::parse($borrowing->due_at)->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="return_date" class="block text-sm font-medium text-gray-700">Tanggal Pengembalian</label>
                    <input type="date" id="return_date" name="return_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label for="book_condition" class="block text-sm font-medium text-gray-700">Kondisi Buku Saat Dikembalikan</label>
                    <select id="book_condition" name="book_condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                        <option value="hilang">Hilang</option>
                    </select>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan (Opsional)</label>
                    <textarea id="notes" name="notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="4" placeholder="Contoh: Ada sedikit coretan di halaman 5..."></textarea>
                </div>

                {{-- Tombol dibuat lebih menonjol dengan gradien dan efek hover --}}
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold py-3 px-4 rounded-md hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-transform duration-300">
                    Proses Pengembalian
                </button>
            </form>
        @else
            {{-- Pesan alternatif juga dibuat lebih menarik --}}
            <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-6 rounded-md text-center">
                <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <p class="mt-4 text-lg font-semibold">Semua Buku Sudah Dikembalikan</p>
                <p class="text-sm">Anda tidak memiliki buku yang sedang dalam masa pinjaman.</p>
            </div>
        @endif
    </div>
</div>
@endsection