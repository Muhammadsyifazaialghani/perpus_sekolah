@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Buku</h1>
    <form action="{{ auth()->check() ? route('dashboard.search') : route('public.dashboard.search') }}" method="GET" class="mb-4">
        <div class="search-container">
            <input type="text" name="query" placeholder="Cari buku atau penulis..." class="search-box" value="{{ request('query') }}">
            <button type="submit" class="search-btn">Cari</button>
        </div>
    </form>
    
    <style>
        /* CSS Utama */
        :root {
          --primary: #4361ee;
          --primary-dark: #3a0ca3;
          --secondary: #7209b7;
          --success: #06ffa5;
          --danger: #ff006e;
          --light: #f8f9fa;
          --dark: #212529;
          --gray: #6c757d;
          --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
          --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
          background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
          min-height: 100vh;
          color: var(--dark);
          line-height: 1.6;
        }
        .container {
          max-width: 1200px;
          margin: 0 auto;
          padding: 20px;
        }
        /* Header Dashboard */
        .dashboard-header {
          background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
          color: white;
          padding: 2rem;
          border-radius: 15px;
          box-shadow: var(--shadow);
          margin-bottom: 2rem;
          text-align: center;
        }
        .dashboard-header h1 {
          font-size: 2.5rem;
          margin-bottom: 0.5rem;
          text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        /* Search Box */
        .search-container {
          display: flex;
          gap: 10px;
          margin-bottom: 2rem;
        }
        .search-box {
          flex: 1;
          padding: 15px 20px;
          border: none;
          border-radius: 50px;
          background: white;
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
          font-size: 1rem;
          transition: var(--transition);
        }
        .search-box:focus {
          outline: none;
          box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.3);
          transform: translateY(-2px);
        }
        .search-btn {
          padding: 15px 30px;
          background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
          color: white;
          border: none;
          border-radius: 50px;
          font-weight: bold;
          cursor: pointer;
          transition: var(--transition);
          box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        .search-btn:hover {
          transform: translateY(-3px);
          box-shadow: 0 7px 20px rgba(67, 97, 238, 0.4);
        }
        
        /* Book Cards */
        .books-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
          gap: 2rem;
          margin-bottom: 2rem;
        }
        
        .book-card {
          background: white;
          border-radius: 15px;
          overflow: hidden;
          box-shadow: var(--shadow);
          transition: var(--transition);
          height: 100%;
          display: flex;
          flex-direction: column;
        }
        
        .book-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .book-img-container {
          position: relative;
          height: 220px;
          overflow: hidden;
        }
        
        .book-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.5s ease;
        }
        
        .book-card:hover .book-img {
          transform: scale(1.05);
        }
        
        .status-badge {
          position: absolute;
          top: 15px;
          right: 15px;
          padding: 0.4rem 0.8rem;
          border-radius: 20px;
          font-size: 0.8rem;
          font-weight: 600;
          box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        
        .badge-available {
          background-color: #28a745;
          color: white;
        }
        
        .badge-unavailable {
          background-color: #dc3545;
          color: white;
        }
        
        .book-info {
          padding: 1.5rem;
          flex-grow: 1;
          display: flex;
          flex-direction: column;
        }
        
        .book-title {
          font-weight: 700;
          font-size: 1.25rem;
          color: #333;
          margin-bottom: 0.5rem;
        }
        
        .book-author {
          color: #6c757d;
          font-size: 0.95rem;
          margin-bottom: 1.2rem;
        }
        
        .book-actions {
          margin-top: auto;
          display: flex;
          flex-direction: column;
          gap: 0.8rem;
        }
        
        .btn-action {
          border-radius: 20px;
          font-weight: 500;
          padding: 0.5rem 1.2rem;
          transition: all 0.3s ease;
          text-align: center;
          cursor: pointer;
          border: none;
          font-size: 0.9rem;
        }
        
        .btn-detail {
          background: rgba(67, 97, 238, 0.1);
          color: var(--primary);
        }
        
        .btn-detail:hover {
          background: var(--primary);
          color: white;
          transform: translateY(-2px);
        }
        
        .btn-borrow {
          background: rgba(6, 255, 165, 0.1);
          color: #06c26b;
        }
        
        .btn-borrow:hover {
          background: var(--success);
          color: white;
          transform: translateY(-2px);
        }
        
        .btn-borrow:disabled {
          background: #e9ecef;
          color: #6c757d;
          cursor: not-allowed;
          transform: none;
        }
        
        /* Halaman Detail Buku */
        .detail-container {
          background: white;
          border-radius: 15px;
          box-shadow: var(--shadow);
          overflow: hidden;
          max-width: 800px;
          margin: 0 auto;
        }
        .detail-header {
          background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
          color: white;
          padding: 2rem;
          text-align: center;
        }
        .detail-header h2 {
          font-size: 2rem;
          margin-bottom: 1rem;
        }
        .detail-content {
          padding: 2rem;
        }
        .book-info {
          margin-bottom: 2rem;
        }
        .book-info h3 {
          color: var(--primary);
          margin-bottom: 1rem;
          font-size: 1.5rem;
        }
        .book-meta {
          display: flex;
          flex-direction: column;
          gap: 10px;
          margin-bottom: 1.5rem;
        }
        .book-meta p {
          display: flex;
          align-items: center;
          gap: 10px;
        }
        .book-meta strong {
          color: var(--dark);
          min-width: 120px;
        }
        .detail-actions {
          display: flex;
          gap: 15px;
          justify-content: center;
          margin-top: 2rem;
        }
        .btn-primary {
          padding: 12px 30px;
          background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
          color: white;
          border: none;
          border-radius: 50px;
          font-weight: bold;
          cursor: pointer;
          transition: var(--transition);
          box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        .btn-primary:hover {
          transform: translateY(-3px);
          box-shadow: 0 7px 20px rgba(67, 97, 238, 0.4);
        }
        .btn-secondary {
          padding: 12px 30px;
          background: transparent;
          color: var(--gray);
          border: 2px solid var(--gray);
          border-radius: 50px;
          font-weight: bold;
          cursor: pointer;
          transition: var(--transition);
        }
        .btn-secondary:hover {
          background: var(--gray);
          color: white;
          transform: translateY(-2px);
        }
        /* Form Peminjaman */
        .form-container {
          background: white;
          border-radius: 15px;
          box-shadow: var(--shadow);
          max-width: 600px;
          margin: 2rem auto;
          overflow: hidden;
        }
        .form-header {
          background: linear-gradient(135deg, #06ffa5 0%, #06c26b 100%);
          color: white;
          padding: 2rem;
          text-align: center;
        }
        .form-header h2 {
          font-size: 1.8rem;
        }
        .form-content {
          padding: 2rem;
        }
        .form-group {
          margin-bottom: 1.5rem;
        }
        .form-group label {
          display: block;
          margin-bottom: 8px;
          font-weight: 600;
          color: var(--dark);
        }
        .form-control {
          width: 100%;
          padding: 12px 15px;
          border: 2px solid #eee;
          border-radius: 10px;
          font-size: 1rem;
          transition: var(--transition);
        }
        .form-control:focus {
          outline: none;
          border-color: var(--primary);
          box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        .form-actions {
          display: flex;
          gap: 15px;
          justify-content: center;
          margin-top: 2rem;
        }
        .btn-success {
          padding: 12px 30px;
          background: linear-gradient(135deg, var(--success) 0%, #06c26b 100%);
          color: var(--dark);
          border: none;
          border-radius: 50px;
          font-weight: bold;
          cursor: pointer;
          transition: var(--transition);
          box-shadow: 0 4px 15px rgba(6, 255, 165, 0.3);
        }
        .btn-success:hover {
          transform: translateY(-3px);
          box-shadow: 0 7px 20px rgba(6, 255, 165, 0.4);
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
        .dashboard-header, .book-card, .detail-container, .form-container {
          animation: fadeIn 0.6s ease-out;
        }
        /* Responsive */
        @media (max-width: 768px) {
          .dashboard-header h1 {
            font-size: 2rem;
          }
          
          .search-container {
            flex-direction: column;
          }
          
          .search-btn {
            width: 100%;
          }
          
          .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
          }
          
          .detail-actions, .form-actions {
            flex-direction: column;
          }
        }
    </style>
    
    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-4 rounded-lg mb-4 shadow-md">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded-lg mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif
    
    @if($books->count())
        <div class="books-grid">
            @foreach($books as $book)
                <div class="book-card">
                    <div class="book-img-container">
                        <!-- Menggunakan gambar placeholder berdasarkan judul buku -->
                        <img src="https://picsum.photos/seed/{{ urlencode($book->title) }}/600/400.jpg" class="book-img" alt="{{ $book->title }}">
                        @if($book->available)
                            <span class="status-badge badge-available">Tersedia</span>
                        @else
                            <span class="status-badge badge-unavailable">Tidak Tersedia</span>
                        @endif
                    </div>
                    <div class="book-info">
                        <h5 class="book-title">{{ $book->title }}</h5>
                        <p class="book-author"><i class="bi bi-person me-1"></i>Oleh: {{ $book->author }}</p>
                        <div class="book-actions">
                            <a href="{{ auth()->check() ? route('dashboard.book.detail', $book->id) : route('public.book.detail', $book->id) }}" class="btn-action btn-detail">
                                <i class="bi bi-info-circle me-1"></i> Detail
                            </a>
                            @if($book->available)
                                @if(auth()->check())
                                    <a href="{{ route('dashboard.book.borrow.form', $book->id) }}" class="btn-action btn-borrow">
                                        <i class="bi bi-bookmark-plus me-1"></i> Pinjam
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-action btn-borrow">
                                        <i class="bi bi-bookmark-plus me-1"></i> Login untuk Pinjam
                                    </a>
                                @endif
                            @else
                                <button class="btn-action btn-borrow" disabled>
                                    <i class="bi bi-bookmark-plus me-1"></i> Pinjam
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6 flex justify-center">
            {{ $books->links() }}
        </div>
    @else
        <div class="bg-white p-8 rounded-xl shadow-md text-center">
            <i class="bi bi-book text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg">Tidak ada buku ditemukan.</p>
        </div>
    @endif
</div>
@endsection