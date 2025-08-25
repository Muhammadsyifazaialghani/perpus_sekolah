@extends('layouts.app')

@section('content')
{{-- Wadah utama disesuaikan agar pas di dalam layout dasbor --}}
<div class="flex justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-3xl">
        
        <div class="p-8 bg-gray-50 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-center text-gray-800">Formulir Peminjaman</h1>
        </div>
        
        <div class="p-6">
            <div class="flex items-start sm:items-center gap-5">
                {{-- Ring warna biru untuk highlight --}}
                <div class="w-24 h-36 rounded-lg overflow-hidden shadow-lg flex-shrink-0 border-4 border-white -mt-16 ring-4 ring-blue-200">
                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 pt-2">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $book->title }}</h2>
                    <p class="text-sm sm:text-base text-gray-600 font-medium">Oleh: {{ $book->author }}</p>
                </div>
            </div>
        </div>
        
        <form id="borrowForm" action="{{ route('dashboard.book.borrow.confirm', $book->id) }}" method="POST" class="p-8 pt-4" novalidate>
            @csrf
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Detail Peminjam
                </h3>
                <div class="grid grid-cols-1">
                    @php
                        // Style untuk input fields
                        $inputClasses = "w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm focus:-translate-y-0.5 focus:shadow-lg";
                    @endphp
                    <div>
                        <label for="class_major" class="block text-sm font-medium text-gray-700 mb-1">Kelas / Jurusan</label>
                        <select id="class_major" name="class_major" class="{{ $inputClasses }}" required>
                            <option value="" disabled selected>Pilih salah satu</option>
                            <option value="RPL (PPLG)">RPL (PPLG)</option>
                            <option value="TKJ (TJKT)">TKJ (TJKT)</option>
                            <option value="MM (DKV)">MM (DKV)</option>
                            <option value="OTKP (MPLB)">OTKP (MPLB)</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="borrowed_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                    <input type="date" id="borrowed_at" name="borrowed_at" value="{{ old('borrowed_at', date('Y-m-d')) }}" class="{{ $inputClasses }}" required>
                </div>
                <div>
                    <label for="due_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                    <input type="date" id="due_at" name="due_at" value="{{ old('due_at', date('Y-m-d', strtotime('+2 weeks'))) }}" class="{{ $inputClasses }}" required>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row-reverse justify-between items-center gap-4 mt-8">
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    Konfirmasi Pinjam
                </button>
                <a href="{{ route('dashboard.book.detail', $book->id) }}" class="w-full sm:w-auto text-center text-gray-600 font-medium py-3 px-6 rounded-lg hover:bg-gray-100 hover:text-blue-600 transition-colors duration-300">
                    Kembali ke Detail Buku
                </a>
            </div>
        </form>
        
        <div class="bg-gray-50 px-6 py-4 text-center text-xs text-gray-500 border-t border-gray-100">
            Perpustakaan Digital © {{ date('Y') }}
        </div>
    </div>
</div>

<script>
    document.getElementById('borrowForm').addEventListener('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            this.reportValidity();
        }
    });
</script>
@endsection