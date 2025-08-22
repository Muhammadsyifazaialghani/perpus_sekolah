<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reminder Denda Peminjaman Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .fine-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Perpustakaan Sekolah</h1>
        <p>Reminder Denda Peminjaman Buku</p>
    </div>

    <div class="content">
        <p>Halo <strong>{{ $borrowing->user->name }}</strong>,</p>
        
        <p>Kami ingin mengingatkan Anda bahwa terdapat denda yang belum dibayar untuk peminjaman buku berikut:</p>
        
        <div class="fine-info">
            <h3>Detail Peminjaman:</h3>
            <p><strong>Judul Buku:</strong> {{ $borrowing->book->title }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d M Y') }}</p>
            <p><strong>Tanggal Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($borrowing->due_at)->format('d M Y') }}</p>
            <p><strong>Tanggal Dikembalikan:</strong> {{ $borrowing->returned_at ? \Carbon\Carbon::parse($borrowing->returned_at)->format('d M Y') : 'Belum dikembalikan' }}</p>
            
            <h3 style="color: #dc3545; margin-top: 15px;">Denda yang Harus Dibayar:</h3>
            <p style="font-size: 18px; color: #dc3545; font-weight: bold;">
                Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}
            </p>
        </div>

        <p>Silakan segera melakukan pembayaran denda ke petugas perpustakaan untuk menghindari sanksi lebih lanjut.</p>
        
        <p>Terima kasih atas perhatiannya.</p>
        
        <p>Salam,<br>
        <strong>Tim Perpustakaan Sekolah</strong></p>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} Perpustakaan Sekolah. All rights reserved.</p>
    </div>
</body>
</html>
