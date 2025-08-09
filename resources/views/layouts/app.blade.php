<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <h1>Perpustakaan Sekolah</h1>
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-link">Buku</a>
                <a href="#" class="nav-link">Kategori</a>
                <a href="#" class="nav-link">Penulis</a>
                <a href="{{ route('return.book') }}" class="nav-link">Pengembalian</a>
            </nav>
            <div class="profile-section">
                <button class="profile-button" onclick="toggleDropdown()">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <svg class="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="profile-dropdown" class="dropdown-menu">
                    <div class="dropdown-header">
                        <p class="user-fullname">{{ auth()->user()->name }}</p>
                        <p class="user-email">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="logout-link">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
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
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        /* Header Styles */
        .main-header {
            background-color: #0080ffff;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .main-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-right: 2rem;
        }
        
        /* Navigation Menu */
        .nav-menu {
            display: flex;
            gap: 1.5rem;
            flex-grow: 1;
            justify-content: center;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Profile Section */
        .profile-section {
            position: relative;
            margin-left: 1rem;
        }
        .profile-button {
            display: flex;
            align-items: center;
            gap: 10px;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .profile-button:hover {
            background-color: rgba(255, 255, 255, 0.1);
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
            margin-top: 8px;
            width: 250px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
            display: none;
            border: 1px solid #e0e0e0;
        }
        .dropdown-menu.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }
        .dropdown-header {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .user-fullname {
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
        }
        .user-email {
            font-size: 0.85rem;
            color: #666;
        }
        .logout-link {
            display: block;
            padding: 12px 15px;
            color: #e74c3c;
            text-decoration: none;
            transition: background-color 0.3s ease;
            border-radius: 0 0 8px 8px;
        }
        .logout-link:hover {
            background-color: #f8f9fa;
        }
        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                padding: 0 15px;
            }
            .main-header h1 {
                font-size: 1.4rem;
                margin-right: 1rem;
            }
            .nav-menu {
                gap: 1rem;
            }
            .user-name {
                display: none;
            }
            .dropdown-menu {
                width: 200px;
                right: -10px;
            }
        }
        
        @media (max-width: 576px) {
            .header-container {
                flex-wrap: wrap;
            }
            
            .main-header h1 {
                width: 100%;
                margin-bottom: 0.5rem;
                margin-right: 0;
                text-align: center;
            }
            
            .nav-menu {
                order: 3;
                width: 100%;
                justify-content: space-around;
                margin-top: 0.5rem;
                padding-top: 0.5rem;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .profile-section {
                order: 2;
                margin-left: 0;
            }
        }
        
        @media (max-width: 480px) {
            .main-header h1 {
                font-size: 1.2rem;
            }
            .nav-link {
                font-size: 0.85rem;
                padding: 0.4rem 0.5rem;
            }
        }
    </style>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('show');
        }
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileSection = document.querySelector('.profile-section');
            const dropdown = document.getElementById('profile-dropdown');
            
            if (!profileSection.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html>