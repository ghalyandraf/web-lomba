<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lentera. - Solusi Bingung Pilih Jurusan Kuliah SNBT</title>
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
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glow-effect {
            box-shadow: 0 0 40px rgba(244, 211, 94, 0.25);
        }
    </style>
</head>
<body class="bg-navy text-white antialiased">

    <!-- Navbar Landing Page -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-navy/90 backdrop-blur-md border-b border-white/15">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 flex items-center justify-center overflow-hidden">
                    <img
                        src="{{ asset('images/logo-lantera.png') }}"
                        alt="Logo Lentera"
                        class="w-full h-full object-contain"
                    >
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-white">Lentera<span class="text-gold">.</span></span>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-300">
                <a href="#fitur" class="hover:text-gold transition">Cara Kerja</a>
                <a href="{{ route('login') }}" class="hover:text-gold transition">Input Rapor</a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-gold hover:bg-goldDark text-navy font-bold text-sm shadow-lg shadow-gold/20 transition">
                    Mulai Perjalananmu
                </a>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-[#070D1F] border-t border-white/10 py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
            <div class="flex items-center space-x-3 mb-4 md:mb-0">
                <div class="w-8 h-8 flex items-center justify-center overflow-hidden">
                    <img
                        src="{{ asset('images/logo-lantera.png') }}"
                        alt="Logo Lentera"
                        class="w-full h-full object-contain"
                    >
                </div>
                <span class="text-lg font-bold text-white">Lentera<span class="text-gold">.</span></span>
            </div>
            <p>&copy; 2026 Lentera. Solusi Tepat Pejuang SNBT Memilih Jurusan Kuliah.</p>
        </div>
    </footer>

</body>
</html>