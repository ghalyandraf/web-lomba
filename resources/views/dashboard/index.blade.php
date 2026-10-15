@extends('layouts.lantera')

@section('title', 'Beranda — LANTERA')
@section('judul', 'Selamat datang, ' . (auth()->user()->name ?? 'Siswa') . '!')
@section('subjudul', 'Yuk, kenali potensimu dan rancang masa depanmu.')

@push('styles')
    /* ============ Scope & token lokal ============ */
    .dash {
        --d-navy: var(--navy, #0f2a52);
        --d-primary: var(--primary, #2563eb);
        --d-primary-soft: var(--primary-soft, #eaf1ff);
        --d-sky: var(--sky, #7dc3ff);
        --d-sky-soft: var(--sky-soft, #eef7ff);
        --d-muted: var(--muted, #64748b);
        --d-line: var(--line, #e2e8f0);
        --d-text: var(--text, #1e293b);
        --d-radius: 20px;
        --d-shadow: 0 1px 2px rgba(15, 42, 82, .05), 0 8px 24px rgba(15, 42, 82, .06);
        --d-shadow-hover: 0 2px 4px rgba(15, 42, 82, .06), 0 16px 36px rgba(15, 42, 82, .12);

        width: 100%;
        max-width: 1120px;
        margin: 0 auto;
    }
    .dash *, .dash *::before, .dash *::after { box-sizing: border-box; }
    .dash a { -webkit-tap-highlight-color: transparent; }

    .dash .section-head { margin: 34px 0 16px; }
    .dash .section-head:first-of-type { margin-top: 0; }
    .dash .section-title {
        font-size: clamp(17px, 2.2vw, 20px);
        font-weight: 700;
        color: var(--d-navy);
        margin: 0 0 4px;
    }
    .dash .section-sub {
        font-size: clamp(12px, 1.6vw, 14px);
        color: var(--d-muted);
        margin: 0;
    }

    /* ============ Tombol ============ */
    .dash .d-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 11px 20px;
        border-radius: 12px;
        border: 1px solid transparent;
        font-size: 13px;
        font-weight: 600;
        line-height: 1;
        text-decoration: none;
        cursor: pointer;
        transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
    }
    .dash .d-btn:hover { transform: translateY(-1px); }
    .dash .d-btn:active { transform: translateY(0); }
    .dash .d-btn-sky { background: var(--d-sky); color: var(--d-navy); box-shadow: 0 6px 18px rgba(125, 195, 255, .35); }
    .dash .d-btn-sky:hover { box-shadow: 0 10px 24px rgba(125, 195, 255, .5); }
    .dash .d-btn-primary { background: var(--d-primary); color: #fff; box-shadow: 0 6px 18px rgba(37, 99, 235, .25); }
    .dash .d-btn-primary:hover { box-shadow: 0 10px 24px rgba(37, 99, 235, .35); }
    .dash .d-btn-outline { background: #fff; color: var(--d-navy); border-color: var(--d-line); }
    .dash .d-btn-outline:hover { background: var(--d-primary-soft); border-color: var(--d-primary); }
    .dash .d-btn:focus-visible,
    .dash .j-card:focus-visible { outline: 3px solid var(--d-sky); outline-offset: 3px; }

    /* ============ Hero ============ */
    .dash .hero {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        background: linear-gradient(135deg, var(--d-navy) 0%, #17407f 60%, #1f5fb8 100%);
        color: #fff;
        border-radius: 24px;
        padding: clamp(24px, 5vw, 48px);
        margin-bottom: 28px;
        box-shadow: 0 18px 40px rgba(15, 42, 82, .25);
    }
    .dash .hero::before,
    .dash .hero::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        z-index: -1;
    }
    .dash .hero::before {
        width: 320px; height: 320px;
        right: -80px; top: -120px;
        background: radial-gradient(circle, rgba(125, 195, 255, .35), transparent 70%);
    }
    .dash .hero::after {
        width: 220px; height: 220px;
        right: 12%; bottom: -110px;
        background: radial-gradient(circle, rgba(255, 255, 255, .14), transparent 70%);
    }
    .dash .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        margin-bottom: 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .18);
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--d-sky);
        backdrop-filter: blur(6px);
    }
    .dash .hero-chip i {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--d-sky);
        box-shadow: 0 0 0 4px rgba(125, 195, 255, .25);
    }
    .dash .hero h2 {
        font-size: clamp(24px, 4.6vw, 40px);
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.01em;
        margin: 0 0 12px;
        max-width: 640px;
    }
    .dash .hero h2 span {
        display: block;
        font-size: clamp(18px, 3.2vw, 28px);
        font-weight: 600;
        color: var(--d-sky);
        margin-top: 4px;
    }
    .dash .hero p {
        font-size: clamp(13px, 1.8vw, 15px);
        line-height: 1.7;
        color: #d6e3f7;
        margin: 0 0 24px;
        max-width: 520px;
    }

    /* ============ Detail jurusan ============ */
    .dash .major-detail {
        background: #fff;
        border: 1px solid var(--d-line);
        border-radius: var(--d-radius);
        padding: clamp(20px, 3.5vw, 32px);
        margin-bottom: 8px;
        box-shadow: var(--d-shadow);
        position: relative;
        overflow: hidden;
    }
    .dash .major-detail::before {
        content: '';
        position: absolute;
        inset: 0 0 auto 0;
        height: 4px;
        background: linear-gradient(90deg, var(--d-primary), var(--d-sky));
    }
    .dash .major-detail .eyebrow {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 999px;
        background: var(--d-primary-soft);
        color: var(--d-primary);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        margin-bottom: 14px;
    }
    .dash .major-detail h2 {
        color: var(--d-navy);
        font-size: clamp(22px, 3.4vw, 30px);
        font-weight: 800;
        line-height: 1.25;
        margin: 0 0 8px;
        overflow-wrap: anywhere;
    }
    .dash .major-detail .field {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--d-muted);
        font-size: 13px;
        margin: 0 0 18px;
    }
    .dash .major-detail .description {
        font-size: 14px;
        line-height: 1.8;
        color: var(--d-text);
        margin: 0 0 26px;
        max-width: 75ch;
    }
    .dash .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 26px;
    }
    .dash .detail-block {
        background: var(--d-sky-soft);
        border: 1px solid var(--d-line);
        border-radius: 16px;
        padding: 18px;
    }
    .dash .detail-block h3 {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--d-navy);
        font-size: 14px;
        font-weight: 700;
        margin: 0 0 12px;
    }
    .dash .chips { display: flex; flex-wrap: wrap; gap: 8px; margin: 0; padding: 0; list-style: none; }
    .dash .chip {
        padding: 7px 12px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid var(--d-line);
        color: var(--d-navy);
        font-size: 12px;
        font-weight: 500;
        line-height: 1.3;
    }
    .dash .score-list { display: grid; gap: 8px; margin: 0; padding: 0; list-style: none; }
    .dash .score-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 9px 12px;
        border-radius: 10px;
        background: #fff;
        border: 1px solid var(--d-line);
        font-size: 13px;
    }
    .dash .score-list li span { color: var(--d-text); overflow-wrap: anywhere; }
    .dash .score-list li strong { color: var(--d-primary); font-weight: 700; flex-shrink: 0; }
    .dash .detail-empty {
        color: var(--d-muted);
        font-size: 12px;
        line-height: 1.6;
        margin: 0;
    }
    .dash .detail-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    /* ============ Ikon inline ============ */
    .dash .ico { width: 18px; height: 18px; flex-shrink: 0; color: var(--d-primary); }
    .dash .major-detail .field .ico { color: var(--d-muted); }

    /* ============ Perjalananmu ============ */
    .dash .journey {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }
    .dash .j-card {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--d-line);
        border-radius: var(--d-radius);
        box-shadow: var(--d-shadow);
        color: inherit;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .dash .j-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--d-shadow-hover);
        border-color: var(--d-sky);
    }
    .dash .j-top { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
    .dash .j-icon {
        width: 40px; height: 40px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: var(--d-primary-soft);
        color: var(--d-primary);
    }
    .dash .j-icon svg { width: 20px; height: 20px; }
    .dash .j-card:nth-child(2) .j-icon { background: #e8f8f1; color: #0f9d6b; }
    .dash .j-card:nth-child(3) .j-icon { background: #fff3e2; color: #d98206; }
    .dash .j-label { font-size: 12px; font-weight: 600; color: var(--d-muted); text-transform: uppercase; letter-spacing: .05em; }
    .dash .j-value {
        font-size: clamp(18px, 2.4vw, 22px);
        font-weight: 800;
        color: var(--d-navy);
        line-height: 1.3;
        overflow-wrap: anywhere;
    }
    .dash .j-value small { font-size: 12px; font-weight: 500; color: var(--d-muted); }
    .dash .j-hint { font-size: 12px; line-height: 1.5; color: var(--d-muted); margin-top: auto; padding-top: 6px; }

    .dash .meter { margin-top: 10px; }
    .dash .meter-row { display: flex; justify-content: space-between; align-items: baseline; gap: 10px; margin-bottom: 8px; }
    .dash .meter-row span { font-size: 12px; color: var(--d-muted); }
    .dash .meter-row strong { font-size: 18px; font-weight: 800; color: var(--d-primary); }
    .dash .meter-bar { width: 100%; height: 8px; border-radius: 999px; background: var(--d-line); overflow: hidden; }
    .dash .meter-bar > div {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--d-primary), var(--d-sky));
        transition: width .5s ease;
    }

    /* ============ Rekomendasi ============ */
    .dash .reco {
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(0, 1fr);
        gap: 16px;
    }
    .dash .reco-main {
        position: relative;
        overflow: hidden;
        padding: clamp(20px, 3vw, 30px);
        background: linear-gradient(135deg, #fff 0%, var(--d-primary-soft) 100%);
        border: 1px solid var(--d-line);
        border-radius: var(--d-radius);
        box-shadow: var(--d-shadow);
    }
    .dash .reco-main::after {
        content: '';
        position: absolute;
        width: 180px; height: 180px;
        right: -50px; bottom: -70px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(125, 195, 255, .35), transparent 70%);
        pointer-events: none;
    }
    .dash .reco-main h3 { font-size: clamp(16px, 2.2vw, 19px); font-weight: 700; color: var(--d-navy); margin: 0 0 10px; }
    .dash .reco-main p { font-size: 14px; line-height: 1.8; color: var(--d-muted); margin: 0 0 20px; max-width: 480px; position: relative; z-index: 1; }
    .dash .reco-main .d-btn { position: relative; z-index: 1; }

    .dash .reco-tips {
        padding: 16px;
        background: #fff;
        border: 1px solid var(--d-line);
        border-radius: var(--d-radius);
        box-shadow: var(--d-shadow);
    }
    .dash .tips-head { background: var(--d-sky-soft); border-radius: 14px; padding: 14px 16px; margin-bottom: 14px; }
    .dash .tips-head h4 { font-size: 14px; font-weight: 700; color: var(--d-navy); margin: 0 0 2px; }
    .dash .tips-head p { font-size: 12px; color: var(--d-muted); margin: 0; }
    .dash .tips-list { list-style: none; counter-reset: tip; display: grid; gap: 10px; margin: 0; padding: 0 4px; }
    .dash .tips-list li {
        counter-increment: tip;
        display: flex;
        gap: 12px;
        align-items: center;
        font-size: 13px;
        line-height: 1.5;
        color: var(--d-text);
    }
    .dash .tips-list li::before {
        content: counter(tip);
        width: 24px; height: 24px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: var(--d-primary-soft);
        color: var(--d-primary);
        font-size: 12px;
        font-weight: 700;
    }

    /* ============ Responsive ============ */
    @media (max-width: 1024px) {
        .dash .journey { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .dash .journey .j-card:last-child { grid-column: 1 / -1; }
    }
    @media (max-width: 760px) {
        .dash .hero { border-radius: 20px; }
        .dash .journey,
        .dash .reco,
        .dash .detail-grid { grid-template-columns: minmax(0, 1fr); }
        .dash .journey .j-card:last-child { grid-column: auto; }
        .dash .section-head { margin-top: 28px; }
    }
    @media (max-width: 480px) {
        .dash .hero .d-btn,
        .dash .detail-actions .d-btn,
        .dash .reco-main .d-btn { width: 100%; }
        .dash .j-card { padding: 16px; }
        .dash .detail-block { padding: 14px; }
        .dash .major-detail .description { font-size: 13px; }
    }
    @media (hover: none) {
        .dash .j-card:hover, .dash .d-btn:hover { transform: none; }
    }
    @media (prefers-reduced-motion: reduce) {
        .dash * { transition: none !important; }
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

<div class="dash">

    <section class="hero">
        <span class="hero-chip"><i></i> Langkah pertamamu dimulai di sini</span>
        <h2>
            Masa depan cerah,
            <span>dimulai dari mengenal diri.</span>
        </h2>
        <p>Lihat kemampuanmu, temukan jurusan yang cocok, dan susun langkah berikutnya.</p>
        <a href="{{ route('majors.index') }}" class="d-btn d-btn-sky">Mulai eksplorasi &rarr;</a>
    </section>

    {{-- DETAIL JURUSAN YANG DIPILIH --}}
    @if(isset($selectedMajor) && $selectedMajor)
        <section class="major-detail">
            <div class="eyebrow">DETAIL JURUSAN PILIHANMU</div>

            <h2>{{ $selectedMajor->name }}</h2>

            <p class="field">
                <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                Bidang: {{ $selectedMajor->field ?? 'Belum tersedia' }}
            </p>

            <p class="description">
                {{ $selectedMajor->description ?? 'Deskripsi jurusan belum tersedia.' }}
            </p>

            <div class="detail-grid">
                <div class="detail-block">
                    <h3><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg> Keterampilan yang Dibutuhkan</h3>

                    @if(is_array($selectedMajor->required_skills) && count($selectedMajor->required_skills) > 0)
                        <ul class="chips">
                            @foreach($selectedMajor->required_skills as $skill)
                                <li class="chip">{{ $skill }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="detail-empty">Informasi keterampilan belum tersedia.</p>
                    @endif
                </div>

                <div class="detail-block">
                    <h3><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg> Nilai Minimum</h3>

                    @if(is_array($selectedMajor->min_scores) && count($selectedMajor->min_scores) > 0)
                        <ul class="score-list">
                            @foreach($selectedMajor->min_scores as $mapel => $nilai)
                                <li>
                                    <span>{{ is_string($mapel) ? $mapel : 'Mata pelajaran' }}</span>
                                    <strong>{{ is_scalar($nilai) ? $nilai : json_encode($nilai) }}</strong>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="detail-empty">Informasi nilai minimum belum tersedia.</p>
                    @endif
                </div>
            </div>

            <div class="detail-actions">
                <a href="{{ route('majors.index') }}" class="d-btn d-btn-primary">
                    Pilih Jurusan Lain
                </a>
                <a href="{{ url('/dashboard') }}" class="d-btn d-btn-outline">
                    Tutup Detail
                </a>
            </div>
        </section>
    @endif

    <div class="section-head">
        <h2 class="section-title">Perjalananmu</h2>
        <p class="section-sub">Pantau perkembangan persiapan jurusanmu.</p>
    </div>

    <section class="journey">
        {{-- NILAI RAPOR --}}
        <a href="{{ route('report-cards.index') }}" class="j-card">
            <div class="j-top">
                <span class="j-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </span>
                <span class="j-label">Nilai rapor</span>
            </div>

            @if ($jumlahNilai > 0)
                <div class="j-value">{{ number_format($rataRapor, 1, ',', '.') }} <small>rata-rata</small></div>
                <div class="j-hint">{{ $jumlahNilai }} nilai tercatat &bull; Klik untuk menambah atau mengubah</div>
            @else
                <div class="j-value">Belum diisi</div>
                <div class="j-hint">Mulai dari data akademikmu</div>
            @endif
        </a>

        {{-- JURUSAN PILIHAN + PERSENTASE KECOCOKAN --}}
        <a href="{{ route('majors.index') }}" class="j-card">
            <div class="j-top">
                <span class="j-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </span>
                <span class="j-label">Jurusan pilihan</span>
            </div>

            <div class="j-value" id="dashboardMajorName">
                {{ isset($selectedMajor) && $selectedMajor
                    ? $selectedMajor->name
                    : ($jurusanPilihan ?? 'Belum dipilih') }}
            </div>

            @if(isset($selectedMajor) && $selectedMajor)
                @if(isset($selectedMajorMatchScore) && $selectedMajorMatchScore !== null)
                    <div class="meter">
                        <div class="meter-row">
                            <span>Kecocokan estimasi</span>
                            <strong>{{ $selectedMajorMatchScore }}%</strong>
                        </div>
                        <div class="meter-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ max(0, min(100, (int) $selectedMajorMatchScore)) }}">
                            <div style="width: {{ max(0, min(100, (int) $selectedMajorMatchScore)) }}%;"></div>
                        </div>
                    </div>

                    <div class="j-hint" id="dashboardMajorHint">
                        Berdasarkan data rapor, minat, dan keterampilan
                    </div>
                @else
                    <div class="j-hint" id="dashboardMajorHint">
                        Isi data rapor untuk melihat estimasi kecocokan
                    </div>
                @endif
            @else
                <div class="j-hint" id="dashboardMajorHint">
                    Jelajahi pilihan yang tersedia
                </div>
            @endif
        </a>

        {{-- RENCANA KARIER --}}
        <a href="{{ route('career.index') }}" class="j-card">
            <div class="j-top">
                <span class="j-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </span>
                <span class="j-label">Rencana karier</span>
            </div>

            <div class="j-value">{{ $rencanaKarier ?? 'Belum dibuat' }}</div>

            @if ($rencanaTerakhir)
                @php $progres = max(0, min(100, (int) $rencanaTerakhir->progress_percentage)); @endphp
                <div class="meter">
                    <div class="meter-row">
                        <span>Progress</span>
                        <strong>{{ $progres }}%</strong>
                    </div>
                    <div class="meter-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $progres }}">
                        <div style="width: {{ $progres }}%;"></div>
                    </div>
                </div>
                <div class="j-hint">Klik untuk melihat atau menambah</div>
            @else
                <div class="j-hint">Bangun roadmap masa depan</div>
            @endif
        </a>
    </section>

    <div class="section-head">
        <h2 class="section-title">Rekomendasi untukmu</h2>
        <p class="section-sub">Langkah yang bisa kamu lakukan sekarang.</p>
    </div>

    <section class="reco">
        <div class="reco-main">
            <h3>Kenali jurusan yang sesuai</h3>
            <p>Pilih bidang yang kamu minati, lalu bandingkan dengan kekuatan akademik dan persyaratan jurusan.</p>
            <a href="{{ route('majors.index') }}" class="d-btn d-btn-primary">Jelajahi jurusan &rarr;</a>
        </div>

        <div class="reco-tips">
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

</div>
@endsection