<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Peminjaman Buku</title>
</head>
<body>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
<style>
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --border: #e2e8f0;
        }

        body {
            background-color: #f1f5f9;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .logo i {
            font-size: 2rem;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 25px;
        }

        nav a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        nav a:hover {
            color: var(--primary);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Dashboard Section */
        .dashboard {
            padding: 30px 0;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            color: var(--gray);
            max-width: 700px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.books {
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary);
        }

        .stat-icon.borrowed {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--secondary);
        }

        .stat-icon.available {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-icon.overdue {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: var(--gray);
        }

        /* Book Section */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
        }

        .book-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .book-cover {
            height: 200px;
            background-color: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-info {
            padding: 15px;
        }

        .book-title {
            font-weight: 600;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-author {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .book-status {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
        }

        .status-available {
            color: var(--success);
        }

        .status-unavailable {
            color: var(--danger);
        }

        /* Search Section */
        .search-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .search-form {
            display: flex;
            gap: 15px;
        }

        .search-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
        }

        .search-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .search-btn:hover {
            background-color: var(--primary-dark);
        }

        /* Book Detail Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow-y: auto;
        }

        .modal-content {
            background-color: white;
            margin: 50px auto;
            padding: 30px;
            width: 90%;
            max-width: 800px;
            border-radius: 10px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray);
        }

        .book-detail {
            display: flex;
            gap: 30px;
        }

        .book-detail-cover {
            flex: 0 0 200px;
            height: 300px;
            background-color: var(--light);
            border-radius: 8px;
            overflow: hidden;
        }

        .book-detail-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-detail-info {
            flex: 1;
        }

        .book-detail-title {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .book-detail-meta {
            margin-bottom: 20px;
            color: var(--gray);
        }

        .book-detail-meta p {
            margin-bottom: 5px;
        }

        .book-description {
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .book-actions {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #d97706;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        /* Borrow Form */
        .borrow-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Confirmation */
        .confirmation-container {
            text-align: center;
            padding: 30px;
        }

        .confirmation-icon {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 20px;
        }

        .confirmation-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .confirmation-message {
            margin-bottom: 30px;
            color: var(--gray);
        }

        .confirmation-details {
            background-color: var(--light);
            border-radius: 10px;
            padding: 20px;
            text-align: left;
            margin-bottom: 30px;
        }

        .confirmation-details h3 {
            margin-bottom: 15px;
            color: var(--primary);
        }

        .confirmation-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
        }

        .confirmation-row:last-child {
            border-bottom: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }

            .book-detail {
                flex-direction: column;
            }

            .book-detail-cover {
                align-self: center;
            }
        }

        /* Utility Classes */
        .hidden {
            display: none;
        }

        .text-center {
            text-align: center;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .mt-20 {
            margin-top: 20px;
        }
</style>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-book-open"></i>
                    <span>Perpustakaan Digital</span>
                </div>
                <nav>
                    <ul>
                        <li><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
                        <li><a href="#"><i class="fas fa-book"></i> Katalog Buku</a></li>
                        <li><a href="#"><i class="fas fa-history"></i> Riwayat Peminjaman</a></li>
                        <li><a href="#"><i class="fas fa-user"></i> Profil</a></li>
                    </ul>
                </nav>
                <div class="user-profile">
                    <span>Ahmad Rizki</span>
                    <div class="user-avatar">AR</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="dashboard">
        <div class="container">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1>Dashboard Peminjaman Buku</h1>
                <p>Selamat datang di sistem peminjaman buku digital. Temukan dan pinjam buku favorit Anda dengan mudah.</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon books">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-info">
                        <h3>1,245</h3>
                        <p>Total Buku</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon borrowed">
                        <i class="fas fa-hand-holding"></i>
                    </div>
                    <div class="stat-info">
                        <h3>87</h3>
                        <p>Dipinjam</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon available">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>1,158</h3>
                        <p>Tersedia</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon overdue">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>5</h3>
                        <p>Telat Kembali</p>
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="search-container">
                <h2 class="section-title mb-20">Cari Buku</h2>
                <form class="search-form" id="searchForm">
                    <input type="text" class="search-input" placeholder="Cari berdasarkan judul, penulis, atau ISBN..." id="searchInput">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Cari Buku
                    </button>
                </form>
            </div>

            <!-- Available Books Section -->
            <div class="books-section">
                <div class="section-header">
                    <h2 class="section-title">Buku Tersedia</h2>
                    <a href="#" class="view-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="books-grid" id="booksGrid">
                    <!-- Books will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </main>

    <!-- Book Detail Modal -->
    <div id="bookDetailModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="book-detail" id="bookDetailContent">
                <!-- Book details will be dynamically loaded here -->
            </div>
        </div>
    </div>

    <!-- Borrow Form Modal -->
    <div id="borrowFormModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="section-title mb-20">Formulir Peminjaman Buku</h2>
            <form id="borrowForm">
                <div class="borrow-form">
                    <div class="form-group">
                        <label for="borrowerName">Nama Peminjam</label>
                        <input type="text" class="form-control" id="borrowerName" required>
                    </div>
                    <div class="form-group">
                        <label for="borrowerEmail">Email</label>
                        <input type="email" class="form-control" id="borrowerEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="borrowDate">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="borrowDate" required>
                    </div>
                    <div class="form-group">
                        <label for="returnDate">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="returnDate" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes">Catatan (Opsional)</label>
                    <textarea class="form-control" id="notes" rows="3"></textarea>
                </div>
                <div class="text-center mt-20">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Konfirmasi Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <div class="confirmation-container">
                <div class="confirmation-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 class="confirmation-title">Peminjaman Berhasil!</h2>
                <p class="confirmation-message">Anda telah berhasil meminjam buku. Silakan ambil buku di perpustakaan sesuai tanggal yang ditentukan.</p>
                <div class="confirmation-details" id="confirmationDetails">
                    <!-- Confirmation details will be dynamically loaded here -->
                </div>
                <button class="btn btn-primary" id="closeConfirmationBtn">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </button>
            </div>
        </div>
    </div>
</html>
