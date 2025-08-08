@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard - Daftar Buku</h1>

    <form action="{{ route('dashboard.search') }}" method="GET" class="mb-4">
        <input type="text" name="query" placeholder="Cari buku..." class="border p-2 rounded w-full" value="{{ request('query') }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Cari</button>
    </form>
    <nav class="nav">
        <div class="container">
            <ul>
                <li><a href="{{ route('dashboard') }}">Buku</a></li>
                <li><a href="#">Kategori</a></li>
                <li><a href="#">Penulis</a></li>
            </ul>
        </div>
    </nav>

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

/* Tabel Buku */
.book-table {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: var(--shadow);
}

.table-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 1.2rem;
  text-align: center;
  font-size: 1.3rem;
  font-weight: bold;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 1.2rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

th {
  background-color: #f8f9fa;
  font-weight: 600;
  color: var(--dark);
  text-transform: uppercase;
  font-size: 0.9rem;
  letter-spacing: 0.5px;
}

tr:hover {
  background-color: #f8f9fa;
  transform: scale(1.01);
  transition: var(--transition);
}

.status {
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: bold;
  text-align: center;
}

.status-available {
  background: rgba(6, 255, 165, 0.15);
  color: #06c26b;
}

.status-unavailable {
  background: rgba(255, 0, 110, 0.15);
  color: var(--danger);
}

.action-btn {
  padding: 8px 16px;
  margin: 0 5px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  transition: var(--transition);
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

.dashboard-header, .book-table, .detail-container, .form-container {
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
  
  table {
    font-size: 0.9rem;
  }
  
  th, td {
    padding: 0.8rem 0.5rem;
  }
  
  .action-btn {
    padding: 6px 12px;
    font-size: 0.8rem;
  }
  
  .detail-actions, .form-actions {
    flex-direction: column;
  }
}
        </style>

    @if(session('error'))
        <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($books->count())
        <table class="book-table">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Judul</th>
                    <th class="py-2 px-4 border-b">Penulis</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $book->author }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($book->available)
                            <span class="text-green-600 font-semibold">Tersedia</span>
                        @else
                            <span class="text-red-600 font-semibold">Tidak tersedia</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('dashboard.book.detail', $book->id) }}" class="text-blue-600 hover:underline mr-2">Detail</a>
                        @if($book->available)
                        <a href="{{ route('dashboard.book.borrow.form', $book->id) }}" class="text-green-600 hover:underline">Pinjam</a>
                        @else
                        <span class="text-gray-400">Pinjam</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $books->links() }}
        </div>
    @else
        <p>Tidak ada buku ditemukan.</p>
    @endif
</div>
@endsection
