@extends('layouts.app')

@section('dashboard_content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    <div class="p-8 md:p-10 rounded-3xl bg-gradient-to-br from-navyLight via-[#161F38] to-[#111A30] border border-white/10 relative overflow-hidden shadow-2xl">
        <div class="absolute -right-12 -bottom-12 w-72 h-72 bg-gold/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-0 right-1/4 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-gold/10 text-gold text-xs font-bold border border-gold/20">
                    <i class="fa-solid fa-compass-drafting animate-spin" style="animation-duration: 8s;"></i>
                    <span>Pusat Navigasi & Deteksi Jurusan SNBT</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight flex items-center space-x-2">
                    <span>Halo, {{ $user->name }}!</span>
                    <i class="fa-solid fa-hand-wave text-gold"></i>
                </h2>
                <p class="text-gray-300 text-sm md:text-base leading-relaxed">
                    Bingung menentukan pilihan kampus dan jurusan untuk SNBT? Jangan khawatir. Lentera. hadir untuk membaca potensi nilaimu secara akurat dan memberikan rekomendasi terbaik beserta strategi tembusnya.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <a href="{{ route('report-cards.index') }}" class="px-6 py-3.5 rounded-xl bg-gold hover:bg-goldDark text-navy font-bold text-sm shadow-lg shadow-gold/20 transition flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Input / Update Rapor</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-6 md:p-8 rounded-3xl bg-navyLight border border-white/10 relative overflow-hidden group hover:border-gold/40 transition duration-300">
            <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-blue-500/10 rounded-full blur-xl group-hover:bg-blue-500/20 transition"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Status Data Akademik</span>
                <div class="w-12 h-12 rounded-2xl bg-blue-500/15 text-blue-400 flex items-center justify-center text-lg shadow-inner">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
            </div>
            <div class="relative z-10 space-y-2">
                @if($latestReportCard)
                    <h3 class="text-2xl font-extrabold text-white">{{ $latestReportCard->semester }}</h3>
                    <p class="text-xs text-emerald-400 flex items-center font-medium">
                        <i class="fa-solid fa-circle-check mr-1.5"></i> Data Rapor Tersimpan & Siap Dianalisis
                    </p>
                @else
                    <h3 class="text-xl font-bold text-gray-400">Belum Ada Data Rapor</h3>
                    <p class="text-xs text-amber-300 flex items-center">
                        <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Kamu perlu memasukkan nilai rapor terlebih dahulu.
                    </p>
                @endif
                <div class="pt-3">
                    <a href="{{ route('report-cards.index') }}" class="inline-flex items-center text-xs font-bold text-gold hover:underline">
                        <span>Kelola Rapor & Skill</span>
                        <i class="fa-solid fa-arrow-right ml-1.5"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 rounded-3xl bg-navyLight border border-white/10 relative overflow-hidden group hover:border-gold/40 transition duration-300">
            <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-gold/10 rounded-full blur-xl group-hover:bg-gold/20 transition"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Rekomendasi Jurusan Utama</span>
                <div class="w-12 h-12 rounded-2xl bg-gold/20 text-gold flex items-center justify-center text-lg shadow-inner">
                    <i class="fa-solid fa-gem"></i>
                </div>
            </div>
            <div class="relative z-10 space-y-2">
                @if($latestAnalysis)
                    <h3 class="text-2xl font-extrabold text-white">{{ $latestAnalysis->major->name }}</h3>
                    <p class="text-xs text-gold font-bold flex items-center">
                        <i class="fa-solid fa-fire mr-1.5"></i> Tingkat Kecocokan: {{ $latestAnalysis->match_percentage }}% ({{ $latestAnalysis->category }})
                    </p>
                @else
                    <h3 class="text-xl font-bold text-gray-400">Belum Ada Deteksi Jurusan</h3>
                    <p class="text-xs text-amber-300 flex items-center">
                        <i class="fa-solid fa-circle-info mr-1.5"></i> Jalankan analisis Diamond untuk menemukan jurusanmu.
                    </p>
                @endif
                <div class="pt-3">
                    <a href="{{ route('diamond.index') }}" class="inline-flex items-center text-xs font-bold text-gold hover:underline">
                        <span>Buka Analisis Diamond & Tips SNBT</span>
                        <i class="fa-solid fa-arrow-right ml-1.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="p-8 rounded-3xl bg-navyLight/60 border border-white/10 space-y-6">
        <h3 class="text-lg font-bold text-white flex items-center">
            <i class="fa-solid fa-signs-post text-gold mr-2.5"></i> 3 Langkah Mudah Menentukan Pilihan Kuliah di Lentera.
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
            <div class="p-5 rounded-2xl bg-navy border border-white/5 space-y-2">
                <div class="w-8 h-8 rounded-xl bg-gold/20 text-gold font-bold flex items-center justify-center text-xs">1</div>
                <h4 class="font-bold text-white flex items-center"><i class="fa-solid fa-book-open mr-2 text-gold"></i> Input Nilai Rapor</h4>
                <p class="text-xs text-gray-400 leading-relaxed">Masukkan nilai mata pelajaran yang kamu kuasai beserta minat dan keterampilanmu secara fleksibel.</p>
            </div>
            <div class="p-5 rounded-2xl bg-navy border border-white/5 space-y-2">
                <div class="w-8 h-8 rounded-xl bg-gold/20 text-gold font-bold flex items-center justify-center text-xs">2</div>
                <h4 class="font-bold text-white flex items-center"><i class="fa-solid fa-gem mr-2 text-gold"></i> Deteksi Diamond</h4>
                <p class="text-xs text-gray-400 leading-relaxed">Sistem secara otomatis mendeteksi jurusan kuliah mana saja yang paling cocok dengan persentase nilaimu.</p>
            </div>
            <div class="p-5 rounded-2xl bg-navy border border-white/5 space-y-2">
                <div class="w-8 h-8 rounded-xl bg-gold/20 text-gold font-bold flex items-center justify-center text-xs">3</div>
                <h4 class="font-bold text-white flex items-center"><i class="fa-solid fa-graduation-cap mr-2 text-gold"></i> Strategi & Tips SNBT</h4>
                <p class="text-xs text-gray-400 leading-relaxed">Jika nilai kurang dari syarat murni, dapatkan tips & trik khusus agar tetap bisa menembus jurusan tersebut lewat jalur UTBK SNBT.</p>
            </div>
        </div>
    </div>
</div>
@endsection