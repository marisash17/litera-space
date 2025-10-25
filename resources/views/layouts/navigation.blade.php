<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LiteraSpace')</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --success: #4bb543;
            --warning: #ffcc00;
            --bg-pastel: #ffffff; /* ganti jadi putih */
        }

        /* Background utama */
        body {
            background-color: var(--bg-pastel);
        }

        /* Navbar */
        .navbar {
            background-color: var(--bg-pastel) !important;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
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
        }
        .nav-link:hover, .nav-link.active {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary) !important;
        }

        /* User Avatar */
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        /* Logout Button */
        .logout-btn {
            color: #6c757d;
            border: none;
            background: none;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
        }

        /* Search Bar */
        .search-bar input:focus {
            box-shadow: none;
            border-color: var(--primary);
        }

        /* Banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        }

        /* Cards Hover */
        .stat-card, .book-card, .recent-book {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover, .book-card:hover, .recent-book:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .book-cover, .recent-cover {
            position: relative;
            overflow: hidden;
        }

        .add-to-shelf {
            transition: all 0.3s ease;
        }
        .add-to-shelf:hover {
            transform: scale(1.1);
        }

        /* Cards tetap putih */
        .card {
            background-color: #ffffff !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light border-bottom shadow-sm">
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
                        <i class="fas fa-sign-out-alt fs-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
