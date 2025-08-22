<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <div class="logo-section">
                <i class="fas fa-book-open logo-icon"></i>
                <h1>Perpustakaan Sekolah</h1>
            </div>
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-book"></i>
                    <span>Buku</span>
                </a>
                <a href="{{ route ('dashboard.categories') }}" class="nav-link">
                    <i class="fas fa-tags"></i>
                    <span>Kategori</span>
                </a>
                <!-- <a href="{{ route('return.book') }}" class="nav-link">
                    <i class="fas fa-user-edit"></i>
                    <span>Penulis</span>
                </a> -->
                <a href="{{ route('return.book') }}" class="nav-link">
                    <i class="fas fa-undo-alt"></i>
                    <span>Pengembalian</span>
                </a>
            </nav>
            @if(auth()->check())
            <div class="profile-section">
                <button class="profile-button" onclick="toggleDropdown()">
                    <div class="profile-avatar">
                        <span class="avatar-initial">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="profile-dropdown" class="dropdown-menu">
                    <div class="dropdown-header">
                        <div class="profile-info">
                            <div class="profile-avatar-large">
                                <span class="avatar-initial-large">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <div class="user-details">
                                <p class="user-fullname">{{ auth()->user()->name }}</p>
                                <p class="user-email">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-actions">
                    <a href="#" class="dropdown-action-link">
                        <i class="fas fa-user-cog"></i>
                        <span>Pengaturan Akun</span>
                    </a>
                    <a href="{{ route('dashboard.borrow.history') }}" class="dropdown-action-link">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Peminjaman</span>
                    </a>
                    </div>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="logout-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            @else
            <div class="profile-section">
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
            </div>
            @endif
        </div>
    </header>
    <main class="main-content">
        @yield('content')
    </main>
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        
        /* Header Styles */
        .main-header {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        /* Logo Section */
        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-icon {
            font-size: 1.8rem;
            color: #ffffff;
        }
        .main-header h1 {
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        /* Navigation Menu */
        .nav-menu {
            display: flex;
            gap: 0.5rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        .nav-link i {
            font-size: 1rem;
        }
        
        .nav-link span {
            font-size: 0.95rem;
        }
        
        /* Profile Section */
        .profile-section {
            position: relative;
        }
        .profile-button {
            display: flex;
            align-items: center;
            gap: 10px;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .profile-button:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        /* Profile Avatar */
        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .avatar-initial {
            font-size: 0.9rem;
        }
        
        .user-name {
            font-size: 0.9rem;
            font-weight: 500;
        }
        .dropdown-icon {
            width: 16px;
            height: 16px;
            transition: transform 0.3s ease;
        }
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            width: 280px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            z-index: 1000;
            display: none;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }
        .dropdown-menu.show {
            display: block;
            animation: dropdownFade 0.3s ease;
        }
        
        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-header {
            background: linear-gradient(135deg, #0066cc, #0052a3);
            color: white;
            padding: 20px;
        }
        
        .profile-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .profile-avatar-large {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .avatar-initial-large {
            font-size: 1.4rem;
        }
        
        .user-details {
            flex: 1;
        }
        
        .user-fullname {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 4px;
        }
        
        .user-email {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        
        .dropdown-actions {
            padding: 8px 0;
        }
        
        .dropdown-action-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }
        
        .dropdown-action-link:hover {
            background-color: #f5f7fa;
        }
        
        .dropdown-action-link i {
            color: #6c757d;
            width: 20px;
            text-align: center;
        }
        
        .logout-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #e74c3c;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border-top: 1px solid #f0f0f0;
        }
        
        .logout-link:hover {
            background-color: #fff5f5;
        }
        
        .logout-link i {
            font-size: 1rem;
        }
        
        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .nav-menu {
                gap: 0.3rem;
            }
            
            .nav-link {
                padding: 0.5rem 0.8rem;
            }
            
            .nav-link span {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                padding: 0 15px;
            }
            
            .logo-section {
                gap: 8px;
            }
            
            .logo-icon {
                font-size: 1.5rem;
            }
            
            .main-header h1 {
                font-size: 1.3rem;
            }
            
            .user-name {
                display: none;
            }
            
            .dropdown-menu {
                width: 260px;
                right: -10px;
            }
        }
        
        @media (max-width: 576px) {
            .header-container {
                flex-wrap: wrap;
            }
            
            .logo-section {
                width: 100%;
                justify-content: center;
                margin-bottom: 10px;
            }
            
            .nav-menu {
                order: 3;
                width: 100%;
                justify-content: space-around;
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .profile-section {
                order: 2;
                position: absolute;
                top: 15px;
                right: 20px;
            }
            
            .main-content {
                padding-top: 80px;
            }
        }
        
        @media (max-width: 480px) {
            .main-header h1 {
                font-size: 1.1rem;
            }
            
            .nav-link {
                padding: 0.4rem 0.6rem;
            }
            
            .dropdown-menu {
                width: 240px;
            }
        }
    </style>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            const icon = document.querySelector('.dropdown-icon');
            
            dropdown.classList.toggle('show');
            
            // Rotate icon when dropdown is open
            if (dropdown.classList.contains('show')) {
                icon.style.transform = 'rotate(180deg)';
            } else {
                icon.style.transform = 'rotate(0deg)';
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileSection = document.querySelector('.profile-section');
            const dropdown = document.getElementById('profile-dropdown');
            const icon = document.querySelector('.dropdown-icon');
            
            if (!profileSection.contains(event.target)) {
                dropdown.classList.remove('show');
                icon.style.transform = 'rotate(0deg)';
            }
        });
    </script>
</body>
</html>