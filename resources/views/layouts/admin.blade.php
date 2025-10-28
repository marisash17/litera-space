<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Admin Perpustakaan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts yang Lebih Elegant -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Skema Warna yang Sama dengan Login -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            light: '#f6f7fb',
                            bg: '#fff',
                            text: '#444',
                            accent: 'rgb(128, 150, 77)',
                            border: '#ddd',
                            hover: '#fbefe3',
                            gold: '#e09c08'
                        }
                    },
                    fontFamily: {
                        'display': ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                        'body': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #f6f7fb;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        header, footer {
            background: linear-gradient(135deg, white, #fbefe3);
            color: #444;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-bottom: 1px solid #ddd;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }

        #sidebar {
            background: linear-gradient(135deg, white, #fbefe3);
            color: #444;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.03);
            border-right: 1px solid #ddd;
        }

        .nav-item a {
            color: #444;
            transition: all 0.3s ease;
            font-family: 'Inter', system-ui, sans-serif;
            font-weight: 500;
        }

        .nav-item a:hover {
            color: rgb(128, 150, 77);
            background-color: #fbefe3;
            border-radius: 8px;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #fbefe3, white);
            border-radius: 8px;
            border: 1px solid rgb(128, 150, 77);
        }

        .nav-item.active a {
            color: rgb(128, 150, 77);
            font-weight: 600;
        }

        .nav-item.active i {
            color: #e09c08;
        }

        .stat-card {
            background: linear-gradient(135deg, white, #fbefe3);
            border-left: 4px solid rgb(128, 150, 77);
            border-radius: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #ddd;
            font-family: 'Inter', system-ui, sans-serif;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(128, 150, 77, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #fbefe3, #fbefe3);
            color: rgb(128, 150, 77);
            border: 2px solid rgb(128, 150, 77);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(128, 150, 77, 0.2);
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background: rgb(128, 150, 77);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(128, 150, 77, 0.3);
        }

        .table-row:hover {
            background-color: #fbefe3;
            transform: translateX(3px);
            transition: all 0.2s ease;
        }

        .logout-btn {
            background: rgb(128, 150, 77);
            color: white;
            border: 2px solid rgb(128, 150, 77);
            transition: all 0.3s ease;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-weight: 600;
        }
        
        .logout-btn:hover {
            background: #e09c08;
            border-color: #e09c08;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(224, 156, 8, 0.3);
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Typography Scale */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .text-display {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-weight: 800;
            letter-spacing: -0.025em;
        }

        .text-body {
            font-family: 'Inter', system-ui, sans-serif;
            font-weight: 400;
            line-height: 1.6;
        }

        .text-accent {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            font-weight: 600;
            letter-spacing: -0.015em;
        }
    </style>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
            return confirm(message);
        }

        // Set active nav item based on current route
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navItems = document.querySelectorAll('.nav-item');
            
            navItems.forEach(item => {
                const link = item.querySelector('a');
                if (link && currentPath.includes(link.getAttribute('href'))) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</head>

<body class="flex flex-col min-h-screen font-body">
    <!-- HEADER -->
    <header class="shadow-sm py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="flex items-center">
                <button class="md:hidden mr-4 text-[#444] hover:text-[rgb(128,150,77)] transition-colors" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-2xl font-bold flex items-center gap-2 text-[#444] font-display">
                    <img src="{{ asset('images/literaspace-logo.png') }}" alt="Logo LiteraSpace" class="w-10 h-10 object-contain rounded-lg shadow-sm">
                    <span>Dashboard Admin</span>
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="hidden md:flex items-center space-x-2 bg-white/80 px-3 py-1 rounded-full text-[#444] border border-[#ddd] font-accent">
                    <i class="fas fa-user-circle text-[rgb(128,150,77)]"></i>
                    <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn px-4 py-2 rounded-lg font-semibold flex items-center transition-all duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="flex flex-1">
        <!-- SIDEBAR -->
        <div id="sidebar" class="w-64 md:w-72 p-6 fixed h-full md:relative md:translate-x-0 transform -translate-x-full transition-transform duration-300 z-10 shadow-lg">
            <div class="mb-10">
                <h2 class="text-xl font-bold mb-4 text-[#444] font-display">Menu Navigasi</h2>
                <ul class="space-y-1">
                    <li class="nav-item p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center font-medium text-body">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-[#e09c08]"></i>
                            <span>Dashboard Utama</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.buku.index') }}" class="flex items-center font-medium text-body">
                            <i class="fas fa-book mr-3 w-5 text-[#e09c08]"></i>
                            <span>Kelola Buku</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('admin.member.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.member.index') }}" class="flex items-center font-medium text-body">
                            <i class="fas fa-users mr-3 w-5 text-[#e09c08]"></i>
                            <span>Kelola Member</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.peminjaman.index') }}" class="flex items-center font-medium text-body">
                            <i class="fas fa-hand-holding mr-3 w-5 text-[#e09c08]"></i>
                            <span>Peminjaman</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.pengembalian.index') }}" class="flex items-center font-medium text-body">
                            <i class="fas fa-undo-alt mr-3 w-5 text-[#e09c08]"></i>
                            <span>Pengembalian</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg transition-all duration-300 {{ request()->routeIs('admin.denda.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.denda.index') }}" class="flex items-center font-medium text-body">
                            <i class="fas fa-money-bill-wave mr-3 w-5 text-[#e09c08]"></i>
                            <span>Denda</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mt-10">
                <h2 class="text-xl font-bold mb-4 text-[#444] font-display">Statistik Cepat</h2>
                <div class="space-y-3">
                    <div class="stat-card p-4 rounded-xl transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-[rgb(128,150,77)] text-body">Total Buku</span>
                            <span class="font-bold text-[rgb(128,150,77)] text-lg font-display">{{ $totalBuku ?? '0' }}</span>
                        </div>
                    </div>
                    <div class="stat-card p-4 rounded-xl transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-[rgb(128,150,77)] text-body">Total Member</span>
                            <span class="font-bold text-[rgb(128,150,77)] text-lg font-display">{{ $totalMember ?? '0' }}</span>
                        </div>
                    </div>
                    <div class="stat-card p-4 rounded-xl transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-[rgb(128,150,77)] text-body">Total Peminjaman</span>
                            <span class="font-bold text-[rgb(128,150,77)] text-lg font-display">{{ $peminjamanAktif ?? '0' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <main class="flex-grow p-6 md:p-8 bg-transparent">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg mb-6 fade-in text-body">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-lg mb-6 fade-in text-body">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- FOOTER -->
    <footer class="text-center py-4 mt-12 shadow-inner">
        <p class="font-medium text-[#444] font-accent">Oktober 2025 LiteraSpace | Kelompok Magang Polindra</p>
    </footer>

    @stack('scripts')
</body>
</html>