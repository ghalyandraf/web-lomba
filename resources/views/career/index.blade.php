@extends('layouts.app')

@section('dashboard_content')
<div class="max-w-5xl mx-auto space-y-8">
    <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-purple-500/10 text-purple-300 text-xs font-bold border border-purple-500/20 mb-2">
            <i class="fa-solid fa-route"></i>
            <span>Peta Masa Depan</span>
        </div>
        <h2 class="text-2xl font-bold text-white">Perencanaan Karier & Target</h2>
        <p class="text-gray-400 text-sm mt-1">Susun tahapan langkah nyata dari bangku sekolah hingga persiapan terjun ke dunia profesional.</p>
    </div>

    <!-- Form Buat Rencana Karier -->
    <div class="p-8 rounded-2xl bg-navyLight border border-white/10">
        <h3 class="text-lg font-bold text-white mb-4">Buat Rencana Karier Baru</h3>
        <form action="{{ route('career.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Target Karier Masa Depan</label>
                    <input type="text" name="target_career" placeholder="Contoh: Web Developer / Software Engineer" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Jalur Pendidikan</label>
                    <input type="text" name="education_path" placeholder="Contoh: S1 Informatika / Bootcamp Profesional" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Target Jangka Pendek</label>
                    <textarea name="short_term_goals" rows="3" placeholder="Contoh: Menguasai dasar HTML, CSS, dan Algoritma" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Target Jangka Menengah</label>
                    <textarea name="medium_term_goals" rows="3" placeholder="Contoh: Membuat portofolio project web & ikut magang" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Target Jangka Panjang</label>
                    <textarea name="long_term_goals" rows="3" placeholder="Contoh: Bekerja sebagai Senior Developer di perusahaan teknologi" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold"></textarea>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-2">Progress Pencapaian Saat Ini (%)</label>
                <input type="number" name="progress_percentage" min="0" max="100" value="10" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold">
            </div>

            <button type="submit" class="px-6 py-3 rounded-xl bg-gold hover:bg-goldDark text-navy font-bold text-sm shadow-lg shadow-gold/20 transition">
                Simpan Rencana Karier
            </button>
        </form>
    </div>

    <!-- Daftar Rencana Karier Tersimpan -->
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-white">Rencana Karier Aktif</h3>
        @forelse($careerPlans as $cp)
            <div class="p-6 rounded-2xl bg-navyLight border border-white/10 space-y-4">
                <div class="flex justify-between items-center border-b border-white/10 pb-4">
                    <div>
                        <h4 class="text-xl font-extrabold text-gold">{{ $cp->target_career }}</h4>
                        <p class="text-xs text-gray-400 mt-1">Jalur: {{ $cp->education_path }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs font-bold border border-purple-500/30">
                        Progress: {{ $cp->progress_percentage }}%
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-gray-300">
                    <div class="p-3 rounded-xl bg-navy border border-white/5">
                        <strong class="text-gold block mb-1">Jangka Pendek:</strong>
                        {{ $cp->short_term_goals }}
                    </div>
                    <div class="p-3 rounded-xl bg-navy border border-white/5">
                        <strong class="text-gold block mb-1">Jangka Menengah:</strong>
                        {{ $cp->medium_term_goals }}
                    </div>
                    <div class="p-3 rounded-xl bg-navy border border-white/5">
                        <strong class="text-gold block mb-1">Jangka Panjang:</strong>
                        {{ $cp->long_term_goals }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Belum ada rencana karier yang disusun.</p>
        @endforelse
    </div>
</div>
@endsection