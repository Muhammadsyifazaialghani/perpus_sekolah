@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl">
        <!-- Header Form -->
        <div class="bg-gray-200 p-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-center mb-2 text-gray-800">Form Peminjaman Buku</h1>
            <p class="text-sm sm:text-base text-center text-gray-500">Mohon kembalikan buku tepat waktu. Keterlambatan akan dikenakan denda sesuai peraturan.</p>
        </div>
        
        <!-- Info Buku -->
        <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-indigo-100">
            <div class="flex items-center mb-4">
                <div class="w-20 h-28 rounded-lg overflow-hidden shadow-lg flex-shrink-0">
                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" 
                         class="w-full h-full object-cover">
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-700">{{ $book->title }}</h2>
                    <p class="text-sm sm:text-base text-gray-600 font-medium">Penulis: {{ $book->author }}</p>
                </div>
            </div>
        </div>
        
        <form id="borrowForm" action="{{ route('dashboard.book.borrow.confirm', $book->id) }}" method="POST" class="p-6" novalidate>
            @csrf
            
            <!-- Data Peminjam -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center">
                    Data Peminjam
                </h3>
                <div class="space-y-4">
                    <div class="mb-5">
                        <label for="full_name" class="block text-gray-700 font-bold mb-2 text-sm">Nama Lengkap</label>
                        <input type="text" id="full_name" name="full_name" placeholder="Nama Lengkap Peminjam"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm"
                               required>
                    </div>
                    
                    <div class="mb-5">
                        <label for="nis_nip" class="block text-gray-700 font-bold mb-2 text-sm">NIS / NIP</label>
                        <input type="text" id="nis_nip" name="nis_nip" placeholder="Nomor Induk Siswa/Pegawai"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm"
                               required>
                    </div>
                    
                    <div class="mb-5">
                        <label for="class_major" class="block text-gray-700 font-bold mb-2 text-sm">Kelas / Jurusan</label>
                        <select id="class_major" name="class_major"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm"
                                required>
                            <option value="" disabled selected>Pilih Kelas / Jurusan</option>
                            <option value="RPL (PPLG)">RPL (PPLG)</option>
                            <option value="TKJ (TJKT)">TKJ (TJKT)</option>
                            <option value="MM (DKV)">MM (DKV)</option>
                            <option value="MPLB">MPLB</option>
                        </select>
                    </div>
                    
                    <div class="mb-5">
                        <label for="school_name" class="block text-gray-700 font-bold mb-2 text-sm">Nama Sekolah / Instansi</label>
                        <input type="text" id="school_name" name="school_name" placeholder="Nama Lengkap Sekolah / Instansi"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm"
                               required>
                    </div>
                    
                    <div class="mb-5">
                        <label for="address_contact" class="block text-gray-700 font-bold mb-2 text-sm">Alamat / Kontak</label>
                        <input type="text" id="address_contact" name="address_contact" placeholder="Alamat atau Nomor Kontak"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm"
                               required>
                    </div>
                </div>
            </div>
            
            <!-- Tanggal Pinjam & Kembali -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="borrowed_at" class="block text-gray-700 font-bold mb-2 text-sm">Tanggal Pinjam</label>
                    <input type="date" id="borrowed_at" name="borrowed_at" value="{{ old('borrowed_at', date('Y-m-d')) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm"
                           required>
                </div>
                
                <div>
                    <label for="due_at" class="block text-gray-700 font-bold mb-2 text-sm">Tanggal Kembali</label>
                    <input type="date" id="due_at" name="due_at" value="{{ old('due_at', date('Y-m-d', strtotime('+2 weeks'))) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm"
                           required>
                </div>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
                <a href="{{ route('dashboard.book.detail', $book->id) }}" 
                   class="w-full sm:w-auto text-center text-gray-600 font-medium py-3 px-6 rounded-full hover:bg-gray-100 hover:text-blue-600 transition-all duration-300 transform hover:scale-105 active:scale-95">
                    Kembali ke Detail Buku
                </a>
                <button type="submit"
                        class="w-full sm:w-auto bg-green-500 text-white font-bold py-3 px-6 rounded-full hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 active:scale-95">
                    Konfirmasi Peminjaman
                </button>
            </div>
        </form>
        
        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 text-center text-xs text-gray-500 border-t border-gray-100">
            Perpustakaan © {{ date('Y') }} - Semua hak dilindungi
        </div>
    </div>
</div>

<style>
    .shadow-3xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    input:focus, select:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                    0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>

<script>
    document.getElementById('borrowForm').addEventListener('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            this.reportValidity();
        }
    });
</script>
@endsection
