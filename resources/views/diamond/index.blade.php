@extends('layouts.app')

@section('dashboard_content')
<div class="max-w-5xl mx-auto space-y-8">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-gold/10 text-gold text-xs font-bold border border-gold/20 mb-2">
            <i class="fa-solid fa-gem"></i>
            <span>Solusi Bingung Pilih Jurusan Kuliah</span>
        </div>
        <h2 class="text-2xl font-bold text-white">Diamond — Deteksi Jurusan Kuliah Sesuai Potensimu</h2>
        <p class="text-gray-400 text-sm mt-1">Sistem otomatis mencocokkan nilai rapor dan skillmu untuk menemukan jurusan kuliah terbaik, opsi alternatif, serta tips tembus SNBT.</p>
    </div>

    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-300 text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-8 rounded-2xl bg-navyLight border border-white/10 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-white">Masih Ragu Menentukan Kuliah Ambil Jurusan Apa?</h3>
            <p class="text-xs text-gray-400 mt-1">Pastikan nilai rapor sudah diisi, lalu biarkan sistem Lentera. memindai jurusan yang paling pas untuk masa depanmu.</p>
        </div>
        <form action="{{ route('diamond.analyze') }}" method="POST" class="mt-4 md:mt-0">
            @csrf
            <button type="submit" class="px-6 py-3.5 rounded-xl bg-gold hover:bg-goldDark text-navy font-bold text-sm shadow-lg shadow-gold/20 transition flex items-center space-x-2">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>Temukan Jurusan Kuliahku</span>
            </button>
        </form>
    </div>

    @if($analysisResults->count() > 0)
        <div class="space-y-6">
            <h3 class="text-xl font-bold text-white">Hasil Analisis & Rekomendasi Jurusan</h3>

            <div class="grid grid-cols-1 gap-6">
                @foreach($analysisResults as $res)
                    <div class="p-6 rounded-2xl bg-navyLight border border-white/10 space-y-4">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-white/10 pb-4">
                            <div>
                                <span class="text-xs text-gray-400">Jurusan Kuliah:</span>
                                <h4 class="text-xl font-extrabold text-white">{{ $res->major->name }}</h4>
                                <p class="text-xs text-gray-300 mt-1 max-w-xl">{{ $res->major->description }}</p>
                            </div>
                            <div class="mt-3 md:mt-0">
                                <span class="px-4 py-1.5 rounded-full text-xs font-bold 
                                    {{ $res->category == 'Sangat Sesuai' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : ($res->category == 'Cukup Sesuai' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30') }}">
                                    {{ $res->category }} (Kecocokan: {{ $res->match_percentage }}%)
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                            <div class="p-4 rounded-xl bg-navy border border-white/5 space-y-2">
                                <p class="font-bold text-emerald-400"><i class="fa-solid fa-circle-check mr-1"></i> Aspek yang Sesuai:</p>
                                <ul class="list-disc pl-5 text-gray-300 space-y-1 text-xs">
                                    @forelse($res->matched_aspects as $match)
                                        <li>{{ $match }}</li>
                                    @empty
                                        <li>Nilai belum mencukupi standar minimum jurusan ini.</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="p-4 rounded-xl bg-navy border border-white/5 space-y-2">
                                <p class="font-bold text-amber-400"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Tantangan / Kekurangan Nilai:</p>
                                <ul class="list-disc pl-5 text-gray-300 space-y-1 text-xs">
                                    @forelse($res->improvement_aspects as $imp)
                                        <li>{{ $imp }}</li>
                                    @empty
                                        <li>Luar biasa! Seluruh syarat nilai terpenuhi sempurna.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        @if($res->recommendations->count() > 0 && $res->category != 'Sangat Sesuai')
                            <div class="p-4 rounded-xl bg-gold/5 border border-gold/20 space-y-3">
                                <p class="text-xs font-bold text-gold uppercase flex items-center">
                                    <i class="fa-solid fa-graduation-cap mr-2"></i> Tips & Trik Tembus Jurusan Ini Lewat Jalur SNBT (UTBK):
                                </p>
                                @foreach($res->recommendations as $rec)
                                    <p class="text-xs text-gray-300 leading-relaxed">
                                        {{ $rec->learning_tips }}
                                    </p>
                                    <p class="text-xs text-gray-300 leading-relaxed pt-1 border-t border-white/5">
                                        {{ $rec->resources }}
                                    </p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-12 p-8 rounded-2xl bg-navyLight border border-white/10">
            <i class="fa-solid fa-gem text-4xl text-gold/40 mb-3"></i>
            <h3 class="text-lg font-bold text-white">Belum Ada Analisis Kecocokan</h3>
            <p class="text-gray-400 text-xs mt-1">Klik tombol di atas untuk mulai mendeteksi jurusan kuliah impianmu.</p>
        </div>
    @endif
</div>
@endsection