@extends('layouts.app')

@section('dashboard_content')
<div class="max-w-5xl mx-auto space-y-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Input & Manajemen Nilai Rapor (Fleksibel)</h2>
        <p class="text-gray-400 text-sm mt-1">Isi nilai mata pelajaran yang tersedia di rapor sekolahmu. Bagian yang tidak ada bisa dikosongkan (opsional).</p>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-300 text-sm">
            <p class="font-bold mb-1">Terjadi kesalahan validasi:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Input Opsional -->
    <div class="p-8 rounded-2xl bg-navyLight border border-white/10">
        <form action="{{ route('report-cards.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-2">Semester Rapor</label>
                <input type="text" name="semester" placeholder="Contoh: Kelas 10 Semester 1" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-300 mb-2">Daftar Mata Pelajaran (Isi yang ada saja, kosongkan jika tidak ada)</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($availableSubjects as $mapel)
                    <div class="p-4 rounded-xl bg-navy border border-white/5">
                        <label class="block text-xs font-semibold text-gray-300 mb-1">{{ str_replace('_', ' ', $mapel) }}</label>
                        <input type="number" step="0.01" name="scores[{{ $mapel }}]" min="0" max="100" placeholder="Opsional (0-100)" class="w-full px-3 py-2 rounded-lg bg-navyLight border border-white/10 text-white text-sm focus:outline-none focus:border-gold">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Minat Utama</label>
                    <textarea name="interests" rows="3" placeholder="Contoh: Teknologi, sains, seni desain, atau ekonomi bisnis" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Keterampilan yang Dikuasai</label>
                    <textarea name="skills" rows="3" placeholder="Contoh: Logika pemecahan masalah, public speaking, coding dasar" required class="w-full px-4 py-3 rounded-xl bg-navy border border-white/10 text-white focus:outline-none focus:border-gold"></textarea>
                </div>
            </div>

            <button type="submit" class="px-6 py-3 rounded-xl bg-gold hover:bg-goldDark text-navy font-bold text-sm shadow-lg shadow-gold/20 transition">
                Simpan Nilai Rapor Fleksibel
            </button>
        </form>
    </div>

    <!-- Riwayat Rapor Tersimpan -->
    <div class="space-y-4">
        <h3 class="text-xl font-bold text-white">Riwayat Nilai Rapor Tersimpan</h3>
        @forelse($reportCards as $rc)
            <div class="p-6 rounded-2xl bg-navyLight border border-white/10 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h4 class="text-lg font-bold text-gold">{{ $rc->semester }}</h4>
                    <p class="text-xs text-gray-400 mt-1">Minat: {{ $rc->interests }}</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @if(is_array($rc->scores))
                            @foreach($rc->scores as $m => $val)
                                <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/5 text-xs text-gray-300">
                                    {{ str_replace('_', ' ', $m) }}: <strong class="text-gold">{{ $val }}</strong>
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
                <span class="text-xs text-gray-500 mt-4 md:mt-0">Disimpan pada {{ $rc->created_at->format('d M Y') }}</span>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Belum ada data nilai rapor yang dimasukkan.</p>
        @endforelse
    </div>
</div>
@endsection