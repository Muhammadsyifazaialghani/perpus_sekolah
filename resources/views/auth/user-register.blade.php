<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Registration</title>
    {{-- Memuat file CSS eksternal Laravel --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/simple-styles.css') }}" rel="stylesheet" />
</head>
<style>
    /* Skema Warna yang sama dengan formulir login */
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

    .register-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .register-card {
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

    .register-card:hover {
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);
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

    .error-message {
      background: rgba(220, 53, 69, 0.2);
      color: #f8d7da;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 30px;
      border-left: 4px solid #dc3545;
      font-weight: 500;
      backdrop-filter: blur(5px);
      text-align: left;
    }

    .error-message ul {
        list-style-type: none;
        padding-left: 0;
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
      text-decoration: none;
      display: inline-block;
    }

    .action-button:hover {
      background: linear-gradient(90deg,
        rgba(var(--rgb-primary), 0.9),
        rgba(var(--rgb-secondary), 0.9));
      box-shadow: 0 8px 20px rgba(var(--rgb-primary), 0.5);
    }

    .login-section {
      margin-top: 25px;
      text-align: center;
      font-size: 15px;
      color: rgba(255, 255, 255, 0.7);
    }

    .login-link {
      color: rgb(var(--rgb-primary));
      text-decoration: none;
      font-weight: 600;
      margin-left: 5px;
      transition: all var(--transition-speed);
      position: relative;
    }

    .login-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg,
        rgb(var(--rgb-primary)),
        rgb(var(--rgb-secondary)));
      transition: width var(--transition-speed);
    }

    .login-link:hover::after {
      width: 100%;
    }

    .login-link:hover {
      color: white;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .register-card {
        padding: 30px 20px;
      }
    }

    @media (max-width: 480px) {
      .register-card {
        max-width: 100%;
        border-radius: 0;
        box-shadow: none;
      }
      .form-title {
        font-size: 24px;
      }
    }
  </style>
<body>
    <div class="register-container">
        <div class="register-card">
            <h2 class="form-title">Daftar Akun Baru</h2>
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
<form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="form-group">
        <label for="username" class="form-label">👤 Nama Lengkap</label>
        <input type="text" id="username" name="username" class="form-input-lg" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required>
        </div>

        <div class="form-group">
        <label for="email" class="form-label">📧 Alamat Email</label>
        <input type="email" id="email" name="email" class="form-input-lg" value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
        </div>

        <div class="form-group">
        <label for="password" class="form-label">🔐 Kata Sandi</label>
        <input type="password" id="password" name="password" class="form-input-lg" placeholder="Buat kata sandi" required>
        </div>

        <div class="form-group">
        <label for="password_confirmation" class="form-label">🔒 Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input-lg" placeholder="Ulangi kata sandi" required>
        </div>
        <button type="submit" class="action-button">Daftar</button>
    </form>
    <div class="login-section">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="login-link">Login sekarang</a>
    </div>
        </div>
    </div>
</body>
</html>
