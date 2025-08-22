@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Riwayat Peminjaman</h1>

    @if($borrowings->count())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr class="bg-blue-600 text">
                        <th class="py-3 px-6 text-left">Judul Buku</th>
                        <th class="py-3 px-6 text-left">Tanggal Pinjam</th>
                        <th class="py-3 px-6 text-left">Tanggal Kembali</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Keterangan Admin</th>
                        <th class="py-3 px-6 text-left">Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $borrowing)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-4 px-6">{{ $borrowing->book->title ?? 'Tidak diketahui' }}</td>
                        <td class="py-4 px-6">{{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d M Y') }}</td>
                        <td class="py-4 px-6">{{ \Carbon\Carbon::parse($borrowing->due_at)->format('d M Y') }}</td>
                        <td class="py-4 px-6">
                            @if($borrowing->status == 'pending')
                                <span class="text-yellow-600 font-semibold">Pending</span>
                            @elseif($borrowing->status == 'approved')
                                <span class="text-green-600 font-semibold">Disetujui</span>
                            @elseif($borrowing->status == 'rejected')
                                <span class="text-red-600 font-semibold">Ditolak</span>
                            @elseif($borrowing->status == 'returned')
                                <span class="text-gray-600 font-semibold">Dikembalikan</span>
                            @else
                                <span class="text-gray-600 font-semibold">{{ ucfirst($borrowing->status) }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            {{ $borrowing->admin_notes ?? '-' }}<br>
                            <strong>Catatan User:</strong> {{ $borrowing->return_notes ?? '-' }}
                        </td>
                        <td class="py-4 px-6">
                            @if($borrowing->fine_amount > 0)
                                <div class="text-red-600 font-semibold">
                                    Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}
                                </div>
                                @if($borrowing->fine_paid)
                                    <span class="text-green-600 text-sm">✓ Sudah dibayar</span>
                                @else
                                    <span class="text-red-600 text-sm">✗ Belum dibayar</span>
                                @endif
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $borrowings->links() }}
        </div>
    @else
        <p class="text-gray-600">Anda belum memiliki riwayat peminjaman.</p>
    @endif
</div>
@endsection
