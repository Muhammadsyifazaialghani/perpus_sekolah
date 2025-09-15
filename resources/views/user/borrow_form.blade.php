@extends('layouts.app')

@section('content')
@if(auth()->check() && auth()->user()->role === 'admin')
    <script>
        window.location.href = '{{ route("dashboard") }}';
    </script>
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center">
            <p class="text-red-600 font-semibold">Admin tidak diperbolehkan meminjam buku</p>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
        </div>
    </div>
@else
<div class="flex items-center justify-center min-h-screen p-4 bg-gradient-to-br from-gray-50 via-gray-50 to-blue-50 animate-fadeIn">

    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-3xl">

        <div class="p-8 bg-gray-50 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-center text-gray-800">Formulir Peminjaman</h1>
        </div>

        <div class="p-6 bg-white">
            <div class="flex items-start sm:items-center gap-5">
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

            <input type="hidden" name="class_major" id="class_major" value="">

            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Detail Peminjam
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                    @php
                    $inputClasses = "w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 shadow-sm focus:-translate-y-0.5 focus:shadow-lg";
                    @endphp
                    
                    {{-- Diubah: Ditambahkan sm:col-span-2 agar field ini mengambil lebar penuh --}}
                    <div class="sm:col-span-2">
                        <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Status Peminjam</label>
                        <select name="role" id="role" class="{{ $inputClasses }}" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="student">Siswa</option>
                            <option value="teacher">Guru</option>
                            <option value="staff">Staf Sekolah</option>
                        </select>
                    </div>

                    {{-- Diubah: Wrapper diubah menjadi grid terpisah yang juga mengambil lebar penuh --}}
                    <div id="student-details" class="hidden sm:col-span-2 grid sm:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <label for="class" class="block text-gray-700 text-sm font-bold mb-2">Kelas</label>
                            <select name="class" id="class" class="{{ $inputClasses }}">
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>

                        <div>
                            <label for="major" class="block text-gray-700 text-sm font-bold mb-2">Jurusan</label>
                            <select name="major" id="major" class="{{ $inputClasses }}">
                                <option value="" disabled selected>Pilih Jurusan</option>
                                <option value="RPL">RPL (Rekayasa Perangkat Lunak)</option>
                                <option value="DKV">DKV (Desain Komunikasi Visual)</option>
                                <option value="MPLB">MPLB (Manajemen Perkantoran dan Layanan Bisnis)</option>
                                <option value="TJKT">TJKT (Teknik Jaringan Komputer dan Telekomunikasi)</option>
                            </select>
                        </div>
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
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
            document.addEventListener('DOMContentLoaded', function () {
                const roleSelect = document.getElementById('role');
                const studentDetails = document.getElementById('student-details');
                const classSelect = document.getElementById('class');
                const majorSelect = document.getElementById('major');
                const classMajorInput = document.getElementById('class_major');

                function toggleStudentDetails(isStudent) {
                    if (isStudent) {
                        studentDetails.classList.remove('hidden');
                        classSelect.setAttribute('required', 'required');
                        majorSelect.setAttribute('required', 'required');
                    } else {
                        studentDetails.classList.add('hidden');
                        classSelect.removeAttribute('required');
                        majorSelect.removeAttribute('required');
                        classSelect.value = '';
                        majorSelect.value = '';
                    }
                }

                function updateClassMajor() {
                    let role = roleSelect.value;
                    let classVal = classSelect.value;
                    let majorVal = majorSelect.value;

                    if (role === 'student') {
                        classMajorInput.value = role + ' - ' + classVal + ' - ' + majorVal;
                    } else {
                        classMajorInput.value = role;
                    }
                }
                
                toggleStudentDetails(roleSelect.value === 'student');
                updateClassMajor();

                roleSelect.addEventListener('change', function() {
                    toggleStudentDetails(this.value === 'student');
                    updateClassMajor();
                });

                classSelect.addEventListener('change', updateClassMajor);
                majorSelect.addEventListener('change', updateClassMajor);

                document.getElementById('borrowForm').addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        this.reportValidity();
                    }
                });
            });
        </script>
@endif
@endsection
