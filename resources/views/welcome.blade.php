<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lentera. - Solusi Pilih Jurusan Kuliah SNBT</title>
        
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            navy: '#0B132B',
                            navyLight: '#1C2541',
                            gold: '#F4D35E',
                            goldDark: '#E9C46A'
                        }
                    }
                }
            }
        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
    </head>
    <body class="bg-navy text-white min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8 relative overflow-x-hidden">

        <!-- Background Glow Effect Responsif -->
        <div class="absolute w-72 h-72 sm:w-96 sm:h-96 lg:w-[500px] lg:h-[500px] bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Loading Screen (Tampil Pas Pertama Buka Web) -->
        <div id="loading-screen" class="fixed inset-0 bg-navy z-50 flex flex-col items-center justify-center space-y-4 px-4 transition-opacity duration-700">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-gradient-to-br from-gold to-goldDark flex items-center justify-center shadow-2xl shadow-gold/30 animate-pulse">
                <i class="fa-solid fa-fire text-navy text-3xl sm:text-4xl"></i>
            </div>
            <div class="flex items-center space-x-2 text-gold text-xs sm:text-sm font-semibold">
                <i class="fa-solid fa-circle-notch animate-spin"></i>
                <span>Memuat Lentera...</span>
            </div>
        </div>

        <!-- Konten Utama Welcome Page (Responsive Layout) -->
        <div class="max-w-xl w-full text-center space-y-6 sm:space-y-8 relative z-10 opacity-0 transition-opacity duration-1000 px-2 sm:px-0" id="main-content">
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full bg-gold/10 text-gold text-xs font-bold border border-gold/20">
                <i class="fa-solid fa-sparkles"></i>
                <span>Platform Pendamping Pejuang SNBT</span>
            </div>

            <div class="space-y-3 sm:space-y-4">
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                    Selamat Datang di <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold to-yellow-200">Lentera.</span>
                </h1>
                <p class="text-gray-300 text-xs sm:text-sm md:text-base leading-relaxed max-w-md sm:max-w-lg mx-auto">
                    Kami akan membantu kamu memilih jurusan yang cocok untuk kamu melalui analisis nilai rapor yang akurat dan strategi jitu tembus UTBK SNBT.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4 pt-2 sm:pt-4 w-full">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 rounded-2xl bg-gold hover:bg-goldDark text-navy font-bold text-xs sm:text-sm shadow-xl shadow-gold/20 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Masuk ke Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 rounded-2xl bg-gold hover:bg-goldDark text-navy font-bold text-xs sm:text-sm shadow-xl shadow-gold/20 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Masuk ke Akun</span>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-6 sm:px-8 py-3.5 sm:py-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/15 text-white font-bold text-xs sm:text-sm transition flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Daftar Akun Baru</span>
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Script untuk Menghilangkan Loading Screen Otomatis Pas Baru Buka -->
        <script>
            window.addEventListener('load', function () {
                setTimeout(function () {
                    const loadingScreen = document.getElementById('loading-screen');
                    const mainContent = document.getElementById('main-content');

                    loadingScreen.style.opacity = '0';
                    setTimeout(() => {
                        loadingScreen.style.display = 'none';
                        mainContent.style.opacity = '1';
                    }, 600);
                }, 1200);
            });
        </script>

    </body>
</html>