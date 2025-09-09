<x-filament::page>
    <div class="max-w-3xl bg-gray-900 p-8 rounded-lg shadow-lg">
        @if ($totalUnpaidFines > 0)
        <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
            <strong>Perhatian:</strong> Anda memiliki denda keterlambatan sebesar
            <span class="font-semibold">Rp {{ number_format($totalUnpaidFines, 0, ',', '.') }}</span>.
            Harap segera melakukan pembayaran.
        </div>
        <x-filament::button wire:click="payNow" class="mb-4 w-full">
            Bayar Sekarang
        </x-filament::button>
        @endif
        {{ $this->form }}
        <x-filament::button wire:click="submit" class="mt-6 w-full">
            Save
        </x-filament::button>
    </div>

    {{-- Payment Method Popup Modal --}}
    @if ($showPaymentPopup)
    {{-- Ganti kode modal Anda yang kosong dengan kode ini --}}

    {{-- Latar belakang overlay --}}
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm"
        aria-labelledby="payment-modal-title"
        role="dialog"
        aria-modal="true">

        {{-- Panel Modal --}}
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm transform transition-all text-gray-800">

            {{-- Header Modal --}}
            <div class="flex items-center justify-between p-5 border-b border-gray-200">
                <h2 id="payment-modal-title" class="text-sm text-gray-600">
                    Pindai untuk Membayar
                </h2>
                <button wire:click="closePaymentPopup" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Isi Modal (Konten Pembayaran) --}}
            <div class="p-6 text-center">
                <p class="text-sm text-gray-600">Total Tagihan Pembayaran</p>
                <p class="text-sm text-gray-600">Rp {{ number_format($totalPaymentAmount, 0, ',', '.') }}</p>

                {{-- Tempat untuk gambar QR Code --}}
                <div class="my-6 flex justify-center">
                    {{-- GANTI "src" DENGAN GAMBAR QR DARI PAYMENT GATEWAY ANDA --}}
                    <img src="/qris.jpeg"
                        alt="QR Code Pembayaran"
                        class="rounded-lg border-4 border-gray-200">
                </div>

                {{-- Instruksi Pembayaran --}}
                <div class="text-left text-sm text-gray-500 bg-gray-50 p-4 rounded-lg">
                    <p class="font-semibold text-gray-700 mb-2">Cara Pembayaran:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Buka aplikasi e-wallet (GoPay, DANA, OVO, dll) atau Mobile Banking.</li>
                        <li>Pilih menu <strong>Bayar / Pindai / QRIS</strong>.</li>
                        <li>Pindai kode QR yang ditampilkan di atas.</li>
                        <li>Pastikan jumlah tagihan sudah sesuai.</li>
                        <li>Selesaikan transaksi Anda.</li>
                    </ol>
                </div>
            </div>

            {{-- Footer Modal --}}
            <div class="px-6 pb-6 text-center">
                <button
                    wire:click="closePaymentPopup"
                    type="button"
                    class="w-full px-5 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</x-filament::page>