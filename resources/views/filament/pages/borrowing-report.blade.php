<x-filament-panels::page>
    <x-filament-panels::form wire:submit="filter">
        {{ $this->form }}
        
        <div class="flex justify-end mt-4">
            <x-filament::button type="submit" icon="heroicon-m-filter">
                Terapkan Filter
            </x-filament::button>
        </div>
    </x-filament-panels::form>

    {{ $this->table }}

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <!-- Buku Paling Sering Dipinjam -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">📚 Buku Paling Sering Dipinjam</h3>
            <div class="space-y-3">
                @forelse($this->getMostBorrowedBooks() as $book)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <span class="font-medium">{{ $book->title }}</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                            {{ $book->borrowings_count }}x dipinjam
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada data peminjaman</p>
                @endforelse
            </div>
        </div>

        <!-- Anggota Teraktif -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">👥 Anggota Teraktif</h3>
            <div class="space-y-3">
                @forelse($this->getMostActiveUsers() as $user)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <span class="font-medium">{{ $user->name }}</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                            {{ $user->borrowings_count }}x meminjam
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada data anggota</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">📊 Statistik Ringkasan</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded">
                <div class="text-2xl font-bold text-blue-600">
                    {{ $this->getTableQuery()->count() }}
                </div>
                <div class="text-sm text-blue-800">Total Peminjaman</div>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded">
                <div class="text-2xl font-bold text-green-600">
                    {{ $this->getTableQuery()->whereNotNull('returned_at')->count() }}
                </div>
                <div class="text-sm text-green-800">Sudah Dikembalikan</div>
            </div>
            
            <div class="text-center p-4 bg-yellow-50 rounded">
                <div class="text-2xl font-bold text-yellow-600">
                    {{ $this->getTableQuery()->whereNull('returned_at')->count() }}
                </div>
                <div class="text-sm text-yellow-800">Masih Dipinjam</div>
            </div>
            
            <div class="text-center p-4 bg-red-50 rounded">
                <div class="text-2xl font-bold text-red-600">
                    Rp {{ number_format($this->getTableQuery()->sum('fine_amount'), 0, ',', '.') }}
                </div>
                <div class="text-sm text-red-800">Total Denda</div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
