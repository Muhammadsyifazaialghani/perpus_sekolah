@extends('layouts.app')

@section('content')
<style>
    /* Mengembalikan skema warna awal dari respons pertama */
    :root {
        --blue-main: #2563eb;
        --blue-light: #eff6ff;
        --gray-main: #4b5563;
        --gray-light: #e5e7eb;
        --accent-green: #22c55e;
        --accent-red: #ef4444;
    }

    /* Struktur dasar */
    body {
        font-family: sans-serif;
        background-color: #f0f4f8; /* Latar belakang abu-abu terang */
        margin: 0;
        padding: 2rem 0;
    }

    .container {
        max-width: 960px;
        margin-left: auto;
        margin-right: auto;
        padding: 1rem;
    }

    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Header Styling */
    .header {
        background-color: var(--blue-main);
        padding: 1.5rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
    }

    .header-link {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-weight: 500;
        transition: color 200ms;
    }

    .header-link:hover {
        color: white;
    }

    /* Main Content Styling */
    .main-content {
        display: flex;
        flex-direction: column;
        padding: 2rem;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .main-content {
            flex-direction: row;
        }
    }

    .image-section {
        flex-shrink: 0;
        display: flex;
        justify-content: center;
    }

    .book-image-container {
        position: relative;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .book-image {
        width: 250px;
        height: 350px;
        object-fit: cover;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .book-image-container:hover {
        transform: scale(1.05);
    }

    .info-section {
        flex-grow: 1;
    }

    .info-section h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--gray-main);
        margin-bottom: 0.5rem;
    }

    .info-section .author {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-main);
        opacity: 0.8;
        margin-bottom: 1rem;
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (min-width: 640px) {
        .detail-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .detail-card {
        padding: 1rem;
        background-color: var(--blue-light);
        border-radius: 0.5rem;
    }

    .detail-card h3 {
        font-weight: 700;
        color: var(--blue-main);
        margin: 0;
    }

    .detail-card p {
        font-weight: 500;
        color: var(--gray-main);
        margin: 0;
    }

    /* Description */
    .description-section {
        margin-bottom: 1.5rem;
    }

    .description-section h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-main);
        margin-bottom: 0.75rem;
    }

    .description-section p {
        color: var(--gray-main);
        line-height: 1.5;
    }

    /* Status & Buttons */
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        color: white;
    }

    .status-available {
        background-color: var(--accent-green);
    }

    .status-unavailable {
        background-color: var(--accent-red);
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .action-buttons a, .action-buttons button {
        flex: 1;
        min-width: 150px;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid var(--gray-light);
        transition: all 0.3s ease;
    }

    .borrow-button {
        background-color: var(--blue-main);
        color: white;
        border-color: var(--blue-main);
    }

    .borrow-button:hover {
        background-color: #1e40af;
        transform: scale(1.05);
    }
    
    .borrow-button:active {
        transform: scale(0.98);
    }

    .dashboard-button {
        background-color: white;
        color: var(--gray-main);
    }
    
    .dashboard-button:hover {
        background-color: var(--gray-light);
        transform: scale(1.05);
    }

    .unavailable-button {
        background-color: var(--gray-light);
        color: var(--gray-main);
        cursor: not-allowed;
        opacity: 0.7;
    }

    /* Icons */
    .icon {
        margin-right: 0.5rem;
        font-size: 1.25rem;
    }

</style>
<div class="container mx-auto p-4">

    <div class="card">
        <div class="header">
            <div>
                <h1>Detail Buku</h1>
                <p>Informasi lengkap tentang buku pilihan Anda</p>
            </div>
        </div>

        <div class="main-content">
            <div class="image-section">
                <div class="book-image-container">
                    <img src="{{ $book->cover_image ?? 'https://picsum.photos/seed/' . $book->title . '/400/600.jpg' }}" alt="{{ $book->title }}" class="book-image">
                    
                    @if($book->available)
                        <div class="status-badge status-available">
                            <i class="bi bi-check-circle-fill"></i> Tersedia
                        </div>
                    @else
                        <div class="status-badge status-unavailable">
                            <i class="bi bi-x-circle-fill"></i> Tidak Tersedia
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="info-section">
                <h2>{{ $book->title }}</h2>
                <p class="author">Oleh: {{ $book->author }}</p>
                
                <div class="detail-grid">
                    <div class="detail-card">
                        <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                            <i class="bi bi-book icon"></i>
                            <h3>Kategori</h3>
                        </div>
                        <p>{{ $book->category->name ?? 'Tidak diketahui' }}</p>
                    </div>
                    
                    <div class="detail-card">
                        <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                            <i class="bi bi-calendar3 icon"></i>
                            <h3>Tahun Terbit</h3>
                        </div>
                        <p>{{ $book->publication_year ?? 'Tidak diketahui' }}</p>
                    </div>
                    
                    <div class="detail-card">
                        <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                            <i class="bi bi-building icon"></i>
                            <h3>Penerbit</h3>
                        </div>
                        <p>{{ $book->publisher ?? 'Tidak diketahui' }}</p>
                    </div>
                    
                    <div class="detail-card">
                        <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                            <i class="bi bi-geo-alt icon"></i>
                            <h3>Lokasi</h3>
                        </div>
                        <p>{{ $book->location ?? 'Tidak diketahui' }}</p>
                    </div>
                </div>
                
                <div class="description-section">
                    <h3>
                        <i class="bi bi-file-text icon"></i> Deskripsi
                    </h3>
                    <p>
                        {{ $book->description ?? 'Deskripsi buku tidak tersedia.' }}
                    </p>
                </div>
                
                <div class="action-buttons">
                    @if($book->available)
                        <a href="{{ route('dashboard.book.borrow.form', $book->id) }}" class="borrow-button">
                            <i class="bi bi-bookmark-plus"></i> Pinjam Buku
                        </a>
                    @else
                        <button disabled class="unavailable-button">
                            <i class="bi bi-bookmark-plus"></i> Tidak Tersedia
                        </button>
                    @endif
                    
                    <a href="{{ route('dashboard') }}" class="dashboard-button">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        {{--
        <div class="related-books">
            <h2>
                <i class="bi bi-book-half icon"></i> Buku Terkait
            </h2>
            
            <div class="related-grid">
                @foreach($relatedBooks as $relatedBook)
                <a href="{{ route('dashboard.book.show', $relatedBook->id) }}" class="related-card">
                    <img src="{{ $relatedBook->cover_image ?? 'https://picsum.photos/seed/' . $relatedBook->title . '/400/300.jpg' }}" alt="{{ $relatedBook->title }}">
                    <div class="related-card-content">
                        <h3>{{ $relatedBook->title }}</h3>
                        <p>{{ $relatedBook->author }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        --}}
    </div>
</div>
@endsection