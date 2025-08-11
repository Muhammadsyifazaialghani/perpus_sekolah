<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Login - Perpustakaan Sekolah</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        /* Variabel CSS untuk konsistensi tema */
        :root {
            --rgb-primary: 255, 193, 7;      /* Emas hangat */
            --rgb-secondary: 13, 110, 253;   /* Biru yang dinamis */
            --rgb-accent: 108, 117, 125;     /* Abu-abu lembut */
            --rgb-bg: 33, 37, 41;            /* Abu-abu tua gelap */
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,
                rgba(var(--rgb-bg), 0.95),
                rgba(var(--rgb-bg), 0.85));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #f8f9fa; /* Warna teks utama yang cerah */
        }
        
        .login-options-container {
            background: rgba(var(--rgb-bg), 0.6);
            backdrop-filter: blur(20px);
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border: 1px solid rgba(var(--rgb-primary), 0.3);
            transition: all var(--transition-speed);
        }

        .login-options-container:hover {
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }
        
        .login-options-container h1 {
            color: rgb(var(--rgb-primary));
            margin-bottom: 1rem;
            font-size: 2rem;
            text-shadow: 0 0 10px rgba(var(--rgb-primary), 0.5);
        }
        
        .login-options-container p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        
        .login-option {
            display: block;
            margin: 1.5rem 0;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(var(--rgb-primary), 0.3);
            border-radius: 0.5rem;
            text-decoration: none;
            color: #f8f9fa;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        .login-option:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgb(var(--rgb-secondary));
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .login-option h3 {
            margin: 0 0 0.5rem 0;
            color: rgb(var(--rgb-primary));
            font-size: 1.3rem;
        }
        
        .login-option p {
            margin: 0;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        .icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .back-link {
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: rgb(var(--rgb-primary));
        }
    </style>
</head>
<body>
    <div class="login-options-container">
        <h1>Pilih Jenis Login</h1>
        <p>Silakan pilih jenis akun Anda untuk masuk ke sistem perpustakaan</p>
        
        <a href="{{ route('user.login') }}" class="login-option">
            <div class="icon">👤</div>
            <h3>Login sebagai User</h3>
            <p>Untuk siswa, guru, dan staf sekolah yang sudah terdaftar</p>
        </a>
        
        <a href="{{ route('admin.login') }}" class="login-option">
            <div class="icon">🔐</div>
            <h3>Login sebagai Admin</h3>
            <p>Untuk administrator dan staf perpustakaan</p>
        </a>
        
        <a href="/" class="back-link">← Kembali ke Beranda</a>
    </div>
</body>
</html>
