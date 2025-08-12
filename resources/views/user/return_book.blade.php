@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Pengembalian Buku</h1>
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($borrowings->count() > 0)
        <form action="{{ route('dashboard.return.process') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Buku yang Ingin Dikembalikan</label>
                <select name="borrowing_id" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($borrowings as $borrowing)
                        <option value="{{ $borrowing->id }}">
                            {{ $borrowing->book->title }} - Jatuh tempo: {{ \Carbon\Carbon::parse($borrowing->due_at)->format('d/m/Y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pengembalian</label>
                <input type="date" name="return_date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi Buku</label>
                <select name="book_condition" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="baik">Baik</option>
                    <option value="rusak_ringan">Rusak Ringan</option>
                    <option value="rusak_berat">Rusak Berat</option>
                    <option value="hilang">Hilang</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Catatan (Opsional)</label>
                <textarea name="notes" class="w-full px-3 py-2 border rounded-lg" rows="3" placeholder="Tambahkan catatan jika perlu..."></textarea>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Kirim Pengembalian
            </button>
        </form>
    @else
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            Anda tidak memiliki buku yang sedang dipinjam untuk dikembalikan.
        </div>
    @endif
</div>
@endsection
