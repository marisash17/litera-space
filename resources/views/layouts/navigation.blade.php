<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LiteraSpace')</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts yang Sama dengan Login -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: rgb(128, 150, 77);     /* hijau dari login */
            --primary-dark: rgb(108, 130, 57); /* hijau dark dari login */
            --secondary: #e09c08;             /* gold/orange dari login */
            --bg-light: #f6f7fb;              /* background dari login */
            --bg-cream: #fbefe3;              /* cream dari login */
            --text-dark: #444;                /* text dari login */
            --text-light: #666;               /* text light dari login */
            --border: #ddd;                   /* border dari login */
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, white, var(--bg-cream)) !important;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--text-dark) !important;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand img {
            height: 35px;
            width: auto;
            margin-right: 10px;
            border-radius: 8px;
        }

        /* Navbar Links */
        .nav-link {
            font-weight: 500;
            margin: 0 5px;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: var(--text-dark) !important;
            font-family: 'Poppins', sans-serif;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--bg-cream);
            color: var(--primary) !important;
            transform: translateY(-1px);
        }

        .nav-link i {
            color: var(--secondary);
        }

        
        /* Logout Button */
        .logout-btn {
            color: #fff;
            border: 2px solid var(--primary);
            background: var(--primary);
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(224, 156, 8, 0.3);
        }

        /* Search Bar */
        .search-bar input:focus {
            box-shadow: 0 0 0 3px rgba(128, 150, 77, 0.1);
            border-color: var(--primary);
        }

        /* Banner */
        .welcome-banner {
            background: linear-gradient(135deg, white, var(--bg-cream));
            border: 1px solid var(--border);
            border-left: 4px solid var(--primary);
        }

        /* Cards */
        .stat-card, .book-card, .recent-book {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: linear-gradient(135deg, white, var(--bg-cream));
            border: 1px solid var(--border);
            border-left: 4px solid var(--primary);
        }

        .stat-card:hover, .book-card:hover, .recent-book:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(128, 150, 77, 0.15);
        }

        .book-cover, .recent-cover {
            position: relative;
            overflow: hidden;
        }

        .add-to-shelf {
            transition: all 0.3s ease;
            background: var(--primary);
            color: white;
            border: none;
        }

        .add-to-shelf:hover {
            transform: scale(1.1);
            background: var(--primary-dark);
        }

        /* Cards tetap putih dengan sentuhan login */
        .card {
            background: linear-gradient(135deg, white, var(--bg-cream)) !important;
            border: 1px solid var(--border);
            border-left: 4px solid var(--primary);
        }

        /* Button Styles sesuai login */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--bg-cream), var(--bg-cream));
            color: var(--primary);
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(128, 150, 77, 0.2);
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(128, 150, 77, 0.3);
        }

        /* Text Colors */
        .text-primary-custom {
            color: var(--primary) !important;
        }

        .text-secondary-custom {
            color: var(--secondary) !important;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, white, var(--bg-cream)) !important;
            color: var(--text-dark);
            border-top: 1px solid var(--border);
        }

        /* Typography Improvements */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--text-dark);
        }

        .text-body-custom {
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
        }

        /* Badge Styles */
        .badge-custom {
            background: var(--primary);
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/literaspace-logo.png') }}" alt="LiteraSpace Logo">
                LiteraSpace
            </a>

            <!-- Toggle Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rak.pinjam') ? 'active' : '' }}" href="{{ route('rak.pinjam') }}">
                            <i class="fas fa-bookmark me-1"></i> Rak Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('riwayat.peminjaman') ? 'active' : '' }}" href="{{ route('riwayat.peminjaman') }}">
                            <i class="fas fa-history me-1"></i> Riwayat
                        </a>
                    </li>
                </ul>

                <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn" title="Keluar">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Add fade-in animation to elements
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.card, .stat-card, .book-card');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
                element.classList.add('fade-in');
            });
        });

        // Add hover effects to navigation
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>