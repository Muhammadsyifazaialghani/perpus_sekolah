@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-500 hover:shadow-3xl">
        <!-- Header Form -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white">
            <h1 class="text-2xl sm:text-3xl text-gray-700 font-bold mb-2 text-sm">Form Peminjaman Buku</h1>
            <p class="text-sm sm:text-base text-gray-500">Mohon kembalikan buku tepat waktu Keterlambatan akan dikenakan denda sesuai peraturan.</p>
        </div>
        
        <!-- Info Buku -->
        <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-indigo-100">
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center shadow-lg">
                    <!-- Icon placeholder -->
                </div>
                <div class="ml-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-700">{{ $book->title }}</h2>
                    <p class="text-sm sm:text-base text-gray-600 font-medium">Penulis: {{ $book->author }}</p>
                </div>
            </div>
        </div>
        
        <form action="{{ route('dashboard.book.borrow.confirm', $book->id) }}" method="POST" class="p-6">
            @csrf
            
            <!-- Data Peminjam -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center">
                    <!-- Icon placeholder -->
                    Data Peminjam
                </h3>
                <div class="space-y-4">
                    <div class="mb-5">
                        <label for="full_name" class="block text-gray-700 font-bold mb-2 text-sm">Nama Lengkap</label>
                        <div class="relative">
                            <input type="text" id="full_name" name="full_name" placeholder="Nama Lengkap Peminjam"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm" required>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label for="nis_nip" class="block text-gray-700 font-bold mb-2 text-sm">NIS / NIP</label>
                        <div class="relative">
                            <input type="text" id="nis_nip" name="nis_nip" placeholder="Nomor Induk Siswa/Pegawai"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm" required>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label for="class_major" class="block text-gray-700 font-bold mb-2 text-sm">Kelas / Jurusan</label>
                        <div class="relative">
                            <input type="text" id="class_major" name="class_major" placeholder="Kelas/Jurusan atau Unit Kerja"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm">
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label for="school_name" class="block text-gray-700 font-bold mb-2 text-sm">Nama Sekolah / Instansi</label>
                        <div class="relative">
                            <input type="text" id="school_name" name="school_name" placeholder="Nama Lengkap Sekolah / Instansi"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm" required>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label for="address_contact" class="block text-gray-700 font-bold mb-2 text-sm">Alamat / Kontak</label>
                        <div class="relative">
                            <input type="text" id="address_contact" name="address_contact" placeholder="Alamat atau Nomor Kontak"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tanggal Pinjam & Kembali -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="borrowed_at" class="block text-gray-700 font-bold mb-2 text-sm flex items-center">
                        <!-- Icon placeholder -->
                        Tanggal Pinjam
                    </label>
                    <div class="relative">
                        <input type="date" id="borrowed_at" name="borrowed_at" value="{{ old('borrowed_at', date('Y-m-d')) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm" required>
                    </div>
                </div>
                
                <div>
                    <label for="due_at" class="block text-gray-700 font-bold mb-2 text-sm flex items-center">
                        <!-- Icon placeholder -->
                        Tanggal Kembali
                    </label>
                    <div class="relative">
                        <input type="date" id="due_at" name="due_at" value="{{ old('due_at', date('Y-m-d', strtotime('+2 weeks'))) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm" required>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
                <a href="{{ route('dashboard.book.detail', $book->id) }}" 
                   class="w-full sm:w-auto text-center text-gray-600 font-medium py-3 px-6 rounded-full hover:bg-gray-100 hover:text-blue-600 transition-all duration-300 transform hover:scale-105 active:scale-95">
                    Kembali ke Detail Buku
                </a>
                <button type="submit" class="w-full sm:w-auto bg-green-500 text-white font-bold py-3 px-6 rounded-full hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 active:scale-95">
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
    /* Menghapus gaya kustom yang tidak diperlukan untuk menyederhanakan desain */
    .shadow-3xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    input:focus {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection
