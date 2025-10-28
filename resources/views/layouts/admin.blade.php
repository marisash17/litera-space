<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard Admin Perpustakaan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom': {
                            'blue-light': '#E6F3FF',
                            'blue-medium': '#D4E7FF',
                            'blue-dark': '#B8D4FF',
                            'accent': '#3B82F6',
                            'accent-dark': '#2563EB'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
        }
        
        .nav-item {
            transition: all 0.2s ease;
        }
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 8px;
        }
        
        .table-row {
            transition: background-color 0.2s ease;
        }
        .table-row:hover {
            background-color: #f0f7ff;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
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
    </script>
</head>

<body class="bg-custom-blue-light font-sans flex flex-col min-h-screen">
    <!-- HEADER -->
    <header class="bg-custom-accent text-white shadow-sm py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="flex items-center">
                <button class="md:hidden mr-4 text-white" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-book-open"></i> 
                    <span>
                        Dashboard Admin
                    </span>
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="hidden md:flex items-center space-x-2 bg-blue-500/20 px-3 py-1 rounded-full text-white">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->name ?? 'Administrator' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-custom-accent-dark hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="flex flex-1">
        <!-- SIDEBAR -->
        <div id="sidebar" class="bg-custom-blue-medium text-gray-800 w-64 md:w-72 p-6 fixed h-full md:relative md:translate-x-0 transform -translate-x-full transition-transform duration-300 z-10 shadow-lg">
            <div class="mb-10">
                <h2 class="text-xl font-bold mb-4 text-blue-800">Menu Navigasi</h2>
                <ul class="space-y-1">
                    <li class="nav-item p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/60 shadow-sm' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-blue-800 hover:text-blue-700">
                            <i class="fas fa-tachometer-alt mr-3 text-blue-600 w-5"></i> 
                            <span class="font-medium">Dashboard Utama</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg {{ request()->routeIs('admin.buku.*') ? 'bg-white/60 shadow-sm' : '' }}">
                        <a href="{{ route('admin.buku.index') }}" class="flex items-center text-blue-800 hover:text-blue-700">
                            <i class="fas fa-book mr-3 text-blue-600 w-5"></i>
                            <span class="font-medium">Kelola Buku</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg {{ request()->routeIs('admin.member.*') ? 'bg-white/60 shadow-sm' : '' }}">
                        <a href="{{ route('admin.member.index') }}" class="flex items-center text-blue-800 hover:text-blue-700">
                            <i class="fas fa-users mr-3 text-blue-600 w-5"></i>
                            <span class="font-medium">Kelola Member</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg {{ request()->routeIs('admin.peminjaman.*') ? 'bg-white/60 shadow-sm' : '' }}">
                        <a href="{{ route('admin.peminjaman.index') }}" class="flex items-center text-blue-800 hover:text-blue-700">
                            <i class="fas fa-hand-holding mr-3 text-blue-600 w-5"></i>
                            <span class="font-medium">Peminjaman</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg {{ request()->routeIs('admin.pengembalian.*') ? 'bg-white/60 shadow-sm' : '' }}">
                        <a href="{{ route('admin.pengembalian.index') }}" class="flex items-center text-blue-800 hover:text-blue-700">
                            <i class="fas fa-undo-alt mr-3 text-blue-600 w-5"></i>
                            <span class="font-medium">Pengembalian</span>
                        </a>
                    </li>
                    <li class="nav-item p-3 rounded-lg {{ request()->routeIs('admin.denda.*') ? 'bg-white/60 shadow-sm' : '' }}">
                        <a href="{{ route('admin.denda.index') }}" class="flex items-center text-blue-800 hover:text-blue-700">
                            <i class="fas fa-money-bill-wave mr-3 text-blue-600 w-5"></i>
                            <span class="font-medium">Denda</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mt-10">
                <h2 class="text-xl font-bold mb-4 text-blue-800">Statistik Cepat</h2>
                <div class="space-y-3">
                    <div class="bg-white/60 p-3 rounded-lg shadow-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-700">Total Buku</span>
                            <span class="font-bold text-blue-800">{{ $totalBuku ?? '0' }}</span>
                        </div>
                    </div>
                    <div class="bg-white/60 p-3 rounded-lg shadow-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-700">Total Member</span>
                            <span class="font-bold text-blue-800">{{ $totalMember ?? '0' }}</span>
                        </div>
                    </div>
                    <div class="bg-white/60 p-3 rounded-lg shadow-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-blue-700">Total Peminjaman</span>
                            <span class="font-bold text-blue-800">{{ $peminjamanAktif ?? '0' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <main class="flex-grow p-6 md:p-8">
            <!-- Notifikasi -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 fade-in">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 fade-in">
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
    <footer class="bg-custom-accent text-white text-center py-4 mt-12 shadow-inner">
        <p class="font-medium">Oktober 2025 LiteraSpace | Kelompok Magang Polindra</p>
    </footer>

    @stack('scripts')
</body>
</html>