<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Lentera.</title>
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
<body class="bg-navy text-white antialiased min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute w-[500px] h-[500px] bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md p-8 md:p-10 rounded-3xl bg-navyLight border border-white/10 shadow-2xl relative z-10 space-y-6">
        <div class="text-center space-y-2">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br from-gold to-goldDark flex items-center justify-center shadow-lg shadow-gold/20">
                <i class="fa-solid fa-fire text-navy text-2xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-white">Daftar Akun Lentera.</h2>
            <p class="text-xs text-gray-400">Mulai tentukan masa depan kuliahmu hari ini</p>
        </div>

        @if($errors->any())
            <div class="p-3.5 rounded-xl bg-red-500/20 border border-red-500/30 text-red-300 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-300 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Kamu" class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white text-sm focus:outline-none focus:border-gold">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-300 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white text-sm focus:outline-none focus:border-gold">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-300 mb-1.5">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white text-sm focus:outline-none focus:border-gold">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-300 mb-1.5">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white text-sm focus:outline-none focus:border-gold">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gold hover:bg-goldDark text-navy font-bold text-sm shadow-lg shadow-gold/20 transition">
                Daftar & Masuk
            </button>
        </form>

        <p class="text-center text-xs text-gray-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-gold font-bold hover:underline">Masuk di sini</a>
        </p>
    </div>

</body>
</html>