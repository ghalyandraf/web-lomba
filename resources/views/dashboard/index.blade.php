
@extends('layouts.lantera')

@section('title', 'Beranda — LANTERA')
@section('judul', 'Selamat datang, ' . (auth()->user()->name ?? 'Siswa') . '!')
@section('subjudul', 'Yuk, kenali potensimu dan rancang masa depanmu.')

@push('styles')
    .hero { background: var(--navy); color: #fff; border-radius: 18px; padding: 28px 28px 26px; margin-bottom: 24px; }
    .hero small { display: block; font-size: 9px; color: var(--sky); font-weight: 600; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 12px; }
    .hero h2 { font-size: 28px; font-weight: 700; line-height: 1.3; margin-bottom: 8px; }
    .hero h2 span { display: block; font-size: 22px; }
    .hero p { font-size: 11px; color: #cfdcf0; margin-bottom: 16px; }

    .journey { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 26px; }
    .journey .card { padding: 16px 18px 20px; }
    .journey .label { font-size: 10px; color: var(--muted); }
    .journey .value { font-size: 17px; font-weight: 700; color: var(--navy); margin: 6px 0 8px; overflow-wrap: anywhere; }
    .journey .value small { font-size: 11px; font-weight: 500; color: var(--muted); }
    .journey .hint { font-size: 9px; color: var(--muted); }

    .major-detail {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 24px;
        margin-bottom: 28px;
    }
    .major-detail .eyebrow {
        color: var(--primary);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .08em;
        margin-bottom: 8px;
    }
    .major-detail h2 {
        color: var(--navy);
        font-size: 24px;
        margin-bottom: 8px;
    }
    .major-detail .field {
        color: var(--muted);
        font-size: 12px;
        margin-bottom: 16px;
    }
    .major-detail .description {
        font-size: 12px;
        line-height: 1.8;
        margin-bottom: 22px;
    }
    .major-detail h3 {
        color: var(--navy);
        font-size: 13px;
        margin-bottom: 10px;
    }
    .detail-list {
        padding-left: 20px;
        margin-bottom: 22px;
        font-size: 12px;
        line-height: 1.9;
    }
    .detail-empty {
        color: var(--muted);
        font-size: 11px;
        margin-bottom: 22px;
    }
    .detail-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .detail-actions .btn { width: auto; text-decoration: none; }
    .btn-outline {
        display: inline-block;
        padding: 10px 14px;
        border: 1px solid var(--line);
        border-radius: 8px;
        color: var(--navy);
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
    }
    .btn-outline:hover { background: var(--primary-soft); }

    .reco { display: grid; grid-template-columns: 1.7fr 1fr; gap: 16px; margin-bottom: 22px; }
    .reco-main { padding: 22px; min-height: 140px; }
    .reco-main h3 { font-size: 13px; font-weight: 700; color: var(--navy); margin-bottom: 10px; }
    .reco-main p { font-size: 11px; color: var(--muted); line-height: 2; margin-bottom: 14px; max-width: 460px; }
    .reco-tips { padding: 14px; }
    .tips-head { background: var(--sky-soft); border-radius: 10px; padding: 12px 14px; margin-bottom: 14px; }
    .tips-head h4 { font-size: 12px; font-weight: 700; color: var(--navy); }
    .tips-head p { font-size: 10px; color: var(--muted); }
    .tips-list { list-style: none; display: grid; gap: 10px; padding: 0 4px; }
    .tips-list li { font-size: 10px; display: flex; gap: 8px; align-items: center; }
    .tips-list li::before { content: ''; width: 4px; height: 4px; border-radius: 50%; background: var(--text); flex-shrink: 0; }

    @media (max-width: 760px) {
        .journey, .reco { grid-template-columns: 1fr; }
        .major-detail { padding: 18px; }
        .major-detail h2 { font-size: 21px; }
    }
@endpush

@section('content')
@php
    // Nilai rapor terbaru
    $kartuTerakhir = auth()->user()->reportCards()->latest()->first();

    $skorTerakhir = $kartuTerakhir
        ? (is_array($kartuTerakhir->scores)
            ? $kartuTerakhir->scores
            : (json_decode($kartuTerakhir->scores, true) ?? []))
        : [];

    $semuaNilai = collect($skorTerakhir)->values();
    $jumlahNilai = $semuaNilai->count();
    $rataRapor = $jumlahNilai > 0 ? $semuaNilai->avg() : null;

    // Rencana karier terbaru
    $rencanaTerakhir = auth()->user()->careerPlans()->latest()->first();
    $jurusanPilihan = $jurusanPilihan ?? null;
    $rencanaKarier = $rencanaKarier ?? ($rencanaTerakhir->target_career ?? null);
@endphp

<section class="hero">
    <small>Langkah pertamamu dimulai di sini</small>
    <h2>
        Masa depan cerah,
        <span>dimulai dari mengenal diri.</span>
    </h2>
    <p>Lihat kemampuanmu, temukan jurusan yang cocok, dan susun langkah berikutnya.</p>
    <a href="{{ route('majors.index') }}" class="btn btn-sky">Mulai eksplorasi &rarr;</a>
</section>

{{-- DETAIL JURUSAN YANG DIPILIH --}}
@if(isset($selectedMajor) && $selectedMajor)
    <section class="major-detail">
        <div class="eyebrow">DETAIL JURUSAN PILIHANMU</div>

        <h2>{{ $selectedMajor->name }}</h2>

        <p class="field">
            Bidang: {{ $selectedMajor->field ?? 'Belum tersedia' }}
        </p>

        <p class="description">
            {{ $selectedMajor->description ?? 'Deskripsi jurusan belum tersedia.' }}
        </p>

        <h3>Keterampilan yang Dibutuhkan</h3>

        @if(is_array($selectedMajor->required_skills) && count($selectedMajor->required_skills) > 0)
            <ul class="detail-list">
                @foreach($selectedMajor->required_skills as $skill)
                    <li>{{ $skill }}</li>
                @endforeach
            </ul>
        @else
            <p class="detail-empty">Informasi keterampilan belum tersedia.</p>
        @endif

        <h3>Nilai Minimum</h3>

        @if(is_array($selectedMajor->min_scores) && count($selectedMajor->min_scores) > 0)
            <ul class="detail-list">
                @foreach($selectedMajor->min_scores as $mapel => $nilai)
                    <li>
                        {{ is_string($mapel) ? $mapel : 'Mata pelajaran' }}:
                        {{ is_scalar($nilai) ? $nilai : json_encode($nilai) }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="detail-empty">Informasi nilai minimum belum tersedia.</p>
        @endif

        <div class="detail-actions">
            <a href="{{ route('majors.index') }}" class="btn btn-primary">
                Pilih Jurusan Lain
            </a>
            <a href="{{ url('/dashboard') }}" class="btn-outline">
                Tutup Detail
            </a>
        </div>
    </section>
@endif

<h2 class="section-title">Perjalananmu</h2>
<p class="section-sub">Pantau perkembangan persiapan jurusanmu.</p>

<section class="journey">
    <a href="{{ route('report-cards.index') }}" class="card">
        <div class="label">Nilai rapor</div>
        @if ($jumlahNilai > 0)
            <div class="value">{{ number_format($rataRapor, 1, ',', '.') }} <small>rata-rata</small></div>
            <div class="hint">{{ $jumlahNilai }} nilai tercatat &bull; Klik untuk menambah atau mengubah</div>
        @else
            <div class="value">Belum diisi</div>
            <div class="hint">Mulai dari data akademikmu</div>
        @endif
    </a>

    <a href="{{ route('majors.index') }}" class="card">
        <div class="label">Jurusan pilihan</div>
        <div class="value">
            {{ isset($selectedMajor) && $selectedMajor ? $selectedMajor->name : ($jurusanPilihan ?? 'Belum dipilih') }}
        </div>
        <div class="hint">Jelajahi pilihan yang tersedia</div>
    </a>

    <a href="{{ route('career.index') }}" class="card">
        <div class="label">Rencana karier</div>
        <div class="value">{{ $rencanaKarier ?? 'Belum dibuat' }}</div>
        @if ($rencanaTerakhir)
            <div class="hint">Progress {{ $rencanaTerakhir->progress_percentage }}% &bull; Klik untuk melihat atau menambah</div>
        @else
            <div class="hint">Bangun roadmap masa depan</div>
        @endif
    </a>
</section>

<h2 class="section-title">Rekomendasi untukmu</h2>
<p class="section-sub">Langkah yang bisa kamu lakukan sekarang.</p>

<section class="reco">
    <div class="card reco-main">
        <h3>Kenali jurusan yang sesuai</h3>
        <p>Pilih bidang yang kamu minati, lalu bandingkan dengan kekuatan akademik dan persyaratan jurusan.</p>
        <a href="{{ route('majors.index') }}" class="btn btn-primary">Jelajahi jurusan &rarr;</a>
    </div>

    <div class="card reco-tips">
        <div class="tips-head">
            <h4>Tips belajar minggu ini</h4>
            <p>Mulai dengan target kecil yang konsisten.</p>
        </div>
        <ul class="tips-list">
            <li>Tentukan satu materi untuk dipelajari</li>
            <li>Sisihkan 20 menit untuk latihan</li>
            <li>Catat progres setiap akhir minggu</li>
        </ul>
    </div>
</section>
@endsection
