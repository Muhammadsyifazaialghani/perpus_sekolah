<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSS Sederhana - Demo</title>
    <link rel="stylesheet" href="{{ asset('resource/css/custom.css') }}">
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Perpustakaan Sekolah</h1>
        </div>
    </header>

    <nav class="nav">
        <div class="container">
            <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Buku</a></li>
                <li><a href="#">Kategori</a></li>
                <li><a href="#">Penulis</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <div class="card">
            <h2>Selamat Datang di Perpustakaan</h2>
            <p>Sistem perpustakaan sekolah yang sederhana dan mudah digunakan.</p>
            <button class="btn btn-primary">Lihat Semua Buku</button>
            <button class="btn btn-secondary">Login</button>
        </div>

        <div class="card">
            <h3>Form Login</h3>
            <form>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" placeholder="Masukkan email">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-input" placeholder="Masukkan password">
                </div>
                <button type="submit" class="btn btn-primary">Masuk</button>
            </form>
        </div>

        <div class="alert alert-success">
            Login berhasil! Selamat datang di sistem perpustakaan.
        </div>

        <div class="alert alert-error">
            Terjadi kesalahan. Silakan coba lagi.
        </div>
    </main>
</body>
</html>
