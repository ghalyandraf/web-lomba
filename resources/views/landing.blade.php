@extends('layouts.landing')

@section('content')
<section class="pt-36 pb-24 md:pt-48 md:pb-36 px-6 relative overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
        <div class="space-y-6">
            <div class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-gold text-xs font-bold tracking-wide">
                <i class="fa-solid fa-sparkles"></i>
                <span>Platform Pendamping Khusus Pejuang SNBT</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight">
                Bingung Pilih Jurusan Kuliah SNBT? <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold via-yellow-200 to-amber-300">Temukan Arahmu Bersama Lentera.</span>
            </h1>
            <p class="text-gray-300 text-base md:text-lg leading-relaxed">
                Lentera. menganalisis nilai rapor dan potensimu secara cerdas untuk mencarikan jurusan kuliah terbaik, opsi alternatif, serta strategi jitu tembus UTBK SNBT.
            </p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 pt-4">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl bg-gold hover:bg-goldDark text-navy font-extrabold text-center shadow-xl shadow-gold/25 transition transform hover:-translate-y-0.5 flex items-center justify-center space-x-3">
                    <span>Mulai Deteksi Jurusanku</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="#fitur" class="px-8 py-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 text-white font-semibold text-center transition flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-circle-info text-gold"></i>
                    <span>Pelajari Cara Kerja</span>
                </a>
            </div>
        </div>

        <!-- Dynamic Preview Card Berdasarkan Data Rapor / Analisis Asli -->
        <div class="relative flex justify-center">
            <div class="w-full max-w-md p-8 rounded-3xl bg-navyLight/70 border border-white/15 backdrop-blur-xl glow-effect relative space-y-6 shadow-2xl">
                <div class="absolute -top-6 -right-6 w-24 h-24 bg-gold/20 rounded-full blur-2xl"></div>
                <div class="text-center space-y-2">
                    <div class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-tr from-gold to-yellow-300 flex items-center justify-center shadow-lg shadow-gold/30">
                        <i class="fa-solid fa-fire text-navy text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Analisis Diamond SNBT</h3>
                    <p class="text-xs text-gray-400">Pemindaian Berdasarkan Nilai Rapor & Skill Asli</p>
                </div>

                <div class="space-y-3">
                    @php
                        $user = Auth::user();
                        $latestAnalysis = $user ? $user->analysisResults()->with('major')->latest()->take(2)->get() : collect();
                        $latestReport = $user ? $user->reportCards()->latest()->first() : null;
                    @endphp

                    @if($latestAnalysis->count() > 0)
                        @foreach($latestAnalysis as $item)
                            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-between text-sm">
                                <span class="text-gray-300 font-medium">{{ $item->major->name }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $item->category == 'Sangat Sesuai' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-blue-500/20 text-blue-300 border border-blue-500/30' }}">
                                    {{ $item->match_percentage }}% {{ $item->category }}
                                </span>
                            </div>
                        @endforeach
                    @elseif($latestReport)
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 space-y-2 text-xs">
                            <p class="text-emerald-400 font-bold"><i class="fa-solid fa-circle-check mr-1"></i> Data Rapor {{ $latestReport->semester }} Tersimpan!</p>
                            <p class="text-gray-300">Segera jalankan Analisis Diamond di dashboard untuk memunculkan rekomendasi jurusan.</p>
                        </div>
                    @else
                        <div class="p-4 rounded-2xl bg-white/5 border border-white/10 text-center text-xs text-gray-300 space-y-1">
                            <p class="font-semibold text-gold">Belum ada data nilai rapor yang dimasukkan.</p>
                            <p class="text-gray-400">Login dan input nilaimu untuk melihat kecocokan jurusan SNBT.</p>
                        </div>
                    @endif
                </div>

                <div class="p-3 rounded-xl bg-gold/5 border border-gold/20 text-center">
                    <p class="text-xs text-gold font-semibold">Dilengkapi Tips & Trik Khusus Jalur UTBK SNBT</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="fitur" class="py-24 bg-navyLight/30 border-t border-white/10 px-6">
    <div class="max-w-7xl mx-auto space-y-16">
        <div class="text-center max-w-2xl mx-auto space-y-4">
            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Bagaimana Lentera. Membantu Pejuang SNBT?</h2>
            <p class="text-gray-400 text-sm md:text-base">Tiga tahapan sistematis untuk mengakhiri kebingunganmu dalam memilih jurusan kuliah.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 rounded-3xl bg-navyLight border border-white/10 space-y-4 hover:border-gold/40 transition">
                <div class="w-14 h-14 rounded-2xl bg-gold/15 flex items-center justify-center text-gold text-2xl shadow-inner">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h3 class="text-xl font-bold">1. Input Nilai Rapor Fleksibel</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Masukkan nilai mata pelajaran yang kamu miliki dari berbagai kurikulum sekolah secara mudah dan transparan.</p>
            </div>
            <div class="p-8 rounded-3xl bg-navyLight border border-white/10 space-y-4 hover:border-gold/40 transition">
                <div class="w-14 h-14 rounded-2xl bg-gold/15 flex items-center justify-center text-gold text-2xl shadow-inner">
                    <i class="fa-solid fa-gem"></i>
                </div>
                <h3 class="text-xl font-bold">2. Analisis Diamond Otomatis</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Sistem memindai seluruh jurusan yang tersedia dan memetakannya ke dalam kategori tingkat kecocokan nilaimu.</p>
            </div>
            <div class="p-8 rounded-3xl bg-navyLight border border-white/10 space-y-4 hover:border-gold/40 transition">
                <div class="w-14 h-14 rounded-2xl bg-gold/15 flex items-center justify-center text-gold text-2xl shadow-inner">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 class="text-xl font-bold">3. Solusi & Tips Trik SNBT</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Jika nilai kurang dari syarat murni, dapatkan panduan strategi khusus dan tips belajar untuk menembus jurusan tersebut lewat UTBK.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 px-6 relative overflow-hidden">
    <div class="max-w-5xl mx-auto p-10 md:p-14 rounded-3xl bg-gradient-to-r from-navyLight via-[#161F38] to-navyLight border border-gold/30 text-center space-y-6 relative shadow-2xl">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 space-y-4 max-w-2xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white">Jangan Tunda Keputusan Masa Depanmu</h2>
            <p class="text-gray-300 text-sm md:text-base">Bergabunglah bersama ribuan siswa lainnya dan tentukan pilihan jurusan SNBT secara akurat sekarang juga.</p>
            <div class="pt-4">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl bg-gold hover:bg-goldDark text-navy font-extrabold text-base shadow-xl shadow-gold/25 transition inline-flex items-center space-x-3">
                    <i class="fa-solid fa-rocket"></i>
                    <span>Mulai Sekarang (Gratis & Demo)</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection