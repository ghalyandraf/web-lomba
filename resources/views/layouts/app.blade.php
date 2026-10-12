<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lentera.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#0B132B',
                        navyLight: '#1C2541',
                        gold: '#F4D35E',
                        goldDark: '#E9C46A',
                        offwhite: '#F8F9FA'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-navy text-white antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Mobile Overlay Backdrop -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-40 hidden md:hidden backdrop-blur-sm transition-opacity"></div>

    <!-- Sidebar (Desktop & Mobile Drawer) -->
    <aside id="sidebar" class="w-64 bg-navyLight border-r border-white/10 flex flex-col justify-between fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:inset-auto">
        <div>
            <div class="h-20 flex items-center justify-between px-6 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-gold to-goldDark flex items-center justify-center shadow-md shadow-gold/20">
                        <i class="fa-solid fa-fire text-navy text-lg"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-white">Lentera<span class="text-gold">.</span></span>
                </div>
                <!-- Tombol Tutup Sidebar Khusus Mobile -->
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-white p-2">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <nav class="p-4 space-y-2 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-gold text-navy font-bold shadow-md shadow-gold/10' : 'text-gray-300 hover:bg-white/5 hover:text-gold transition' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('report-cards.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('report-cards.*') ? 'bg-gold text-navy font-bold shadow-md shadow-gold/10' : 'text-gray-300 hover:bg-white/5 hover:text-gold transition' }}">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Input Rapor</span>
                </a>
                <a href="{{ route('diamond.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('diamond.*') ? 'bg-gold text-navy font-bold shadow-md shadow-gold/10' : 'text-gray-300 hover:bg-white/5 hover:text-gold transition' }}">
                    <i class="fa-solid fa-gem"></i>
                    <span>Analisis Diamond</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center justify-between">
                <div class="truncate mr-2">
                    <p class="text-xs text-gray-400">Masuk sebagai</p>
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg bg-white/5 hover:bg-red-500/20 text-gray-400 hover:text-red-400 transition" title="Keluar">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Navbar dengan Tombol Hamburger Mobile -->
        <header class="h-20 bg-navyLight/50 border-b border-white/10 px-6 flex items-center justify-between backdrop-blur-md sticky top-0 z-30">
            <div class="flex items-center space-x-3">
                <!-- Tombol Buka Sidebar Mobile -->
                <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg bg-white/5 text-gold hover:bg-white/10 transition">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h1 class="text-base md:text-lg font-bold truncate">Dashboard Siswa - Pejuang SNBT</h1>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 rounded-full bg-gold/10 text-gold text-xs font-bold border border-gold/20 hidden sm:inline-block">
                    <i class="fa-solid fa-sparkles mr-1"></i> Fokus SNBT
                </span>
            </div>
        </header>

        <main class="flex-1 p-6 md:p-10 overflow-y-auto">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('dashboard_content')
        </main>
    </div>

    <!-- Script Toggle Sidebar Mobile -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

</body>
</html>