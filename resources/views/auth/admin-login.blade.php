<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login</title>
    {{-- Memuat file CSS eksternal Laravel --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/simple-styles.css') }}" rel="stylesheet" />

    {{-- CSS Kustom untuk Halaman Login --}}
    <style>
        /* Variabel CSS untuk kontrol tema RGB yang baru */
       :root {
            --rgb-primary: 255, 193, 7;      /* Emas hangat */
            --rgb-secondary: 13, 110, 253;   /* Biru yang dinamis */
            --rgb-accent: 108, 117, 125;     /* Abu-abu lembut */
            --rgb-bg: 33, 37, 41;            /* Abu-abu tua gelap */
            --transition-speed: 0.3s;
        }

    /* Reset dan gaya dasar */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg,
        rgba(var(--rgb-bg), 0.95),
        rgba(var(--rgb-bg), 0.85));
      color: #fff;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
    }

    /* Login container */
    .login-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .login-card {
      background: rgba(var(--rgb-bg), 0.6);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
      padding: 40px;
      width: 100%;
      max-width: 420px;
      text-align: center;
      border: 1px solid rgba(var(--rgb-primary), 0.3);
      position: relative;
      overflow: hidden;
      transition: all var(--transition-speed);
    }

    .login-card:hover {
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);
    }

    .logout-message {
      background: rgba(40, 167, 69, 0.2);
      color: #d4edda;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 30px;
      border-left: 4px solid #28a745;
      font-weight: 500;
      backdrop-filter: blur(5px);
    }

    .logout-message.error-message {
        background: rgba(220, 53, 69, 0.2);
        color: #f8d7da;
        border-left: 4px solid #dc3545;
    }

    .form-title {
      font-size: 28px;
      margin-bottom: 30px;
      background: linear-gradient(90deg,
        rgb(var(--rgb-primary)),
        rgb(var(--rgb-secondary)),
        rgb(var(--rgb-primary)));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-shadow: 0 0 15px rgba(var(--rgb-primary), 0.5);
    }

    .form-group {
      margin-bottom: 20px;
      text-align: left;
    }

    .form-label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: rgba(255, 255, 255, 0.8);
    }

    .form-input-lg {
        width: 100%;
        padding: 18px 20px;
        font-size: 18px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(var(--rgb-primary), 0.3);
        border-radius: 12px;
        color: white;
        transition: all var(--transition-speed);
        backdrop-filter: blur(5px);
    }

    .form-input-lg::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .form-input-lg:focus {
        outline: none;
        border-color: rgb(var(--rgb-primary));
        box-shadow: 0 0 20px rgba(var(--rgb-primary), 0.5);
        background: rgba(255, 255, 255, 0.15);
    }

    /* Kelas untuk tombol login dan daftar */
    .action-button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(90deg,
        rgba(var(--rgb-primary), 0.8),
        rgba(var(--rgb-secondary), 0.8));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all var(--transition-speed);
      margin-top: 10px;
      position: relative;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(var(--rgb-primary), 0.3);
      text-decoration: none; /* Hilangkan garis bawah pada link */
      display: inline-block; /* Agar bisa pakai width */
    }

    .action-button:hover {
      background: linear-gradient(90deg,
        rgba(var(--rgb-primary), 0.9),
        rgba(var(--rgb-secondary), 0.9));
      box-shadow: 0 8px 20px rgba(var(--rgb-primary), 0.5);
    }

    /* Karena kedua tombol menggunakan style yang sama, kita bisa
       membuat div wrapper untuk memberikan margin atas pada tombol kedua. */
    .button-group {
      margin-top: 10px;
    }
     .back-link {
            display: block; /* Membuatnya menempati satu baris */
            margin-top: 25px; /* Memberi jarak dari tombol di atasnya */
            color: rgba(255, 255, 255, 0.6); /* Warna abu-abu yang soft */
            text-decoration: none; /* Menghilangkan garis bawah */
            font-size: 14px;
            transition: color var(--transition-speed);
        }

        .back-link:hover {
            color: white; /* Warna menjadi putih saat di-hover */
        }

    /* Responsive design */
    @media (max-width: 768px) {
      .login-card {
        padding: 30px 20px;
      }
    }

    @media (max-width: 480px) {
      .login-card {
        max-width: 100%;
        border-radius: 0;
        box-shadow: none;
      }
      .form-title {
        font-size: 24px;
      }
    }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2 class="form-title">Log in</h2>
            @if ($errors->any())
                <div class="logout-message error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="logout-message">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">👤 Username</label>
                    <input id="email" type="email" name="email" required autofocus class="form-input-lg" placeholder="Enter your username" />
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">🔐 Password</label>
                    <input id="password" type="password" name="password" required class="form-input-lg" placeholder="Enter your password" />
                </div>
                <button type="submit" class="action-button">Login</button>
                <a href="/login" class="back-link">← Kembali ke Beranda</a>
            </form>
            </div>
        </div>
    </div>
</body>
</html>
