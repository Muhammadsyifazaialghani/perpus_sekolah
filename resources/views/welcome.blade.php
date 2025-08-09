<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah</title>
    <link rel="stylesheet" href="{{ asset('resource/css/custom.css') }}">
</head>
<style>
    /* Reset dan Variabel */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary-color: #2563eb;
    --primary-dark: #1d4ed8;
    --secondary-color: #64748b;
    --light-bg: #f8fafc;
    --white: #ffffff;
    --text-dark: #1e293b;
    --text-light: #64748b;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --transition: all 0.3s ease;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--light-bg);
    color: var(--text-dark);
    line-height: 1.6;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: var(--white);
    padding: 2rem 0;
    box-shadow: var(--shadow);
}

.header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Navigation */
.nav {
    background-color: var(--white);
    box-shadow: var(--shadow);
    position: sticky;
    top: 0;
    z-index: 100;
}

.nav ul {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 1rem 0;
}

.nav li {
    margin: 0 1.5rem;
}

.nav a {
    text-decoration: none;
    color: var(--text-dark);
    font-weight: 500;
    font-size: 1.1rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    transition: var(--transition);
    position: relative;
}

.nav a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background-color: var(--primary-color);
    transition: var(--transition);
}

.nav a:hover {
    color: var(--primary-color);
    background-color: rgba(37, 99, 235, 0.1);
}

.nav a:hover::after {
    width: 100%;
}

/* Main Content */
main {
    padding: 3rem 0;
}

/* Card */
.card {
    background-color: var(--white);
    border-radius: 0.75rem;
    padding: 2.5rem;
    box-shadow: var(--shadow-lg);
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    transition: var(--transition);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.card h2 {
    font-size: 2rem;
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-weight: 700;
}

.card p {
    color: var(--text-light);
    font-size: 1.1rem;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    margin: 0 0.5rem;
}

.btn-primary {
    background-color: var(--primary-color);
    color: var(--white);
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 7px 14px rgba(37, 99, 235, 0.4);
}

.btn-secondary {
    background-color: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.btn-secondary:hover {
    background-color: var(--primary-color);
    color: var(--white);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .header h1 {
        font-size: 2rem;
    }
    
    .nav ul {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .nav li {
        margin: 0.5rem;
    }
    
    .card {
        padding: 1.5rem;
    }
    
    .card h2 {
        font-size: 1.5rem;
    }
    
    .btn {
        display: block;
        width: 100%;
        margin: 0.5rem 0;
    }
}

/* Animasi */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeIn 0.8s ease-out;
}
</style>
<body>
    <header class="header">
        <div class="container">
            <h1>Perpustakaan Sekolah</h1>
        </div>
    </header>

    <!-- <nav class="nav">
        <div class="container">
            <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="{{ route('dashboard') }}">Buku</a></li>
                <li><a href="#">Kategori</a></li>
                <li><a href="#">Penulis</a></li>
            </ul>
        </div>
    </nav> -->

    <main class="container">
        <div class="card">
            <h2>Selamat Datang di Perpustakaan</h2>
            <p>Sistem perpustakaan sekolah yang sederhana dan mudah digunakan.</p>
            <a href="{{ route('public.dashboard') }}" class="btn btn-primary">Lihat Semua Buku</a>
            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
        </div>
    </main>
</body>
</html>
