<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Login - Perpustakaan Sekolah</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        .login-options-container {
            background: white;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        
        .login-options-container h1 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        
        .login-options-container p {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        
        .login-option {
            display: block;
            margin: 1.5rem 0;
            padding: 1.5rem;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 0.5rem;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }
        
        .login-option:hover {
            background: #e3f2fd;
            border-color: #2196f3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .login-option h3 {
            margin: 0 0 0.5rem 0;
            color: #1976d2;
            font-size: 1.3rem;
        }
        
        .login-option p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }
        
        .icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .back-link {
            margin-top: 2rem;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .back-link:hover {
            color: #1976d2;
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
