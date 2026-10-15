@extends('layouts.lantera')

@section('title', 'Nilai Rapor — LANTERA')
@section('judul', 'Selamat datang, ' . (auth()->user()->name ?? 'Siswa') . '!')
@section('subjudul', 'Yuk, kenali potensimu dan rancang masa depanmu.')
@section('bantuan', 'Satu langkah kecil hari ini bisa mengubah masa depanmu.')

@push('styles')
    /* ============ Nilai Rapor ============ */
    .nr { width: 100%; max-width: 1120px; margin: 0 auto; --nr-pad: 28px; }
    .nr *, .nr *::before, .nr *::after { box-sizing: border-box; }

    /* ----- Header halaman ----- */
    .nr-head { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
    .nr-head-ico { display: grid; place-items: center; width: 48px; height: 48px; flex-shrink: 0; border-radius: 14px; background: var(--sky-soft); color: var(--navy-deep); }
    .nr-head-ico svg { width: 24px; height: 24px; }
    .nr-title { font-size: clamp(20px, 3vw, 26px); font-weight: 800; color: var(--navy); line-height: 1.2; }
    .nr-sub { font-size: 13px; line-height: 1.5; color: var(--muted); margin-top: 2px; }

    /* ----- Layout ----- */
    .nr-layout { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 20px; align-items: start; }
    .nr-card { background: var(--surface); border: 1px solid var(--border); border-radius: 18px; box-shadow: 0 1px 2px rgba(22, 58, 107, .04), 0 8px 24px rgba(22, 58, 107, .05); }
    .nr-form { padding: var(--nr-pad); }
    .nr-form h3 { font-size: clamp(17px, 2.4vw, 20px); font-weight: 800; color: var(--navy); }
    .nr-form .nr-form-sub { font-size: 13px; color: var(--muted); margin: 2px 0 20px; }

    /* ----- Ringkasan progres (langsung terhitung) ----- */
    .nr-summary {
        display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px 20px;
        padding: 16px 18px; margin-bottom: 26px;
        border-radius: 14px; border: 1px solid var(--border);
        background: linear-gradient(135deg, var(--sky-soft) 0%, #fff 100%);
    }
    .nr-sum-label { display: block; font-size: 11px; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: var(--muted); margin-bottom: 2px; }
    .nr-sum-value { font-size: 22px; font-weight: 800; color: var(--navy); line-height: 1.2; }
    .nr-sum-value small { font-size: 12px; font-weight: 500; color: var(--muted); }
    .nr-sum-bar { grid-column: 1 / -1; height: 8px; border-radius: 999px; background: var(--border); overflow: hidden; }
    .nr-sum-bar > div { width: 0; height: 100%; border-radius: 999px; background: linear-gradient(90deg, var(--navy-deep), var(--sky)); transition: width .35s ease; }

    /* ----- Judul bagian bernomor ----- */
    .nr-sec-head { display: flex; align-items: center; gap: 10px; margin: 0 0 6px; }
    .nr-sec-num { display: grid; place-items: center; width: 26px; height: 26px; flex-shrink: 0; border-radius: 50%; background: var(--navy-deep); color: #fff; font-size: 12px; font-weight: 700; }
    .nr-sec-head h4 { font-size: 15px; font-weight: 700; color: var(--navy); }
    .nr-sec { padding-top: 24px; margin-top: 24px; border-top: 1px solid var(--border); }
    .nr-sec:first-of-type { padding-top: 0; margin-top: 0; border-top: 0; }
    .nr-hint { font-size: 12px; line-height: 1.6; color: var(--muted); margin: 0 0 14px 36px; }

    /* ----- Field ----- */
    .nr-selects { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin-left: 36px; }
    .nr-field label.lbl { display: block; font-size: 12px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
    .nr-field select, .nr-field input {
        width: 100%; min-height: 44px; padding: 10px 14px;
        border: 1px solid var(--border); border-radius: 12px; background: #fff;
        font-family: inherit; font-size: 14px; color: var(--text);
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .nr-field select:hover, .nr-field input:hover { border-color: #c9d6e6; }
    .nr-field select:focus, .nr-field input:focus { outline: none; border-color: var(--navy-deep); box-shadow: 0 0 0 4px rgba(31, 95, 174, .12); }
    .nr-field select {
        appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%236b7a90' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
    }
    .nr-field input::placeholder { color: #9aa7ba; }
    .nr-field input.invalid { border-color: var(--danger); background: var(--danger-soft); }
    .nr-field input.invalid:focus { box-shadow: 0 0 0 4px rgba(211, 47, 47, .14); }
    .nr input[type=number]::-webkit-inner-spin-button, .nr input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    .nr input[type=number] { -moz-appearance: textfield; }

    /* ----- Kelompok mata pelajaran ----- */
    .nr-groups { margin-left: 36px; display: grid; gap: 10px; }
    .nr-group { border: 1px solid var(--border); border-radius: 14px; background: #fff; transition: border-color .2s ease, box-shadow .2s ease; }
    .nr-group[open] { border-color: #cfe0f3; box-shadow: 0 4px 14px rgba(22, 58, 107, .06); }
    .nr-group summary {
        list-style: none; cursor: pointer; user-select: none;
        display: flex; align-items: center; gap: 12px;
        min-height: 56px; padding: 10px 16px;
        font-size: 14px; font-weight: 700; color: var(--navy);
        border-radius: 14px;
    }
    .nr-group summary::-webkit-details-marker { display: none; }
    .nr-group summary:hover { background: var(--bg); }
    .nr-group summary:focus-visible { outline: 2px solid var(--navy-deep); outline-offset: 2px; }
    .nr-group summary::after { content: ''; width: 8px; height: 8px; flex-shrink: 0; border-right: 2px solid var(--muted); border-bottom: 2px solid var(--muted); transform: rotate(45deg); transition: transform .2s ease; margin-left: 2px; }
    .nr-group[open] summary::after { transform: rotate(-135deg); }
    .nr-group-ico { display: grid; place-items: center; width: 34px; height: 34px; flex-shrink: 0; border-radius: 10px; background: var(--sky-soft); color: var(--navy-deep); }
    .nr-group-ico svg { width: 18px; height: 18px; }
    .nr-group-name { flex: 1; min-width: 0; line-height: 1.3; }
    .group-count { margin-left: auto; padding: 3px 10px; border-radius: 999px; background: var(--bg); color: var(--muted); font-size: 11px; font-weight: 600; white-space: nowrap; }
    .nr-group.done .group-count { background: var(--ok-soft); color: var(--ok); }
    .nr-group-body { padding: 16px 16px 6px; border-top: 1px solid var(--border); }

    .nr-row { display: grid; grid-template-columns: minmax(0, 1fr) 180px; align-items: center; gap: 16px; margin-bottom: 14px; }
    .nr-row label { font-size: 13px; line-height: 1.4; color: var(--text); }

    .nr-about { margin-left: 36px; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }

    /* ----- Tombol simpan (menempel di bawah saat form panjang) ----- */
    .nr-actions {
        position: sticky; bottom: 0; z-index: 5;
        margin: 28px calc(var(--nr-pad) * -1) calc(var(--nr-pad) * -1);
        padding: 14px var(--nr-pad);
        background: rgba(255, 255, 255, .92);
        -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px);
        border-top: 1px solid var(--border);
        border-radius: 0 0 17px 17px;
    }
    .nr-submit {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        min-height: 48px; padding: 12px 24px;
        border: 0; border-radius: 12px; background: var(--navy-deep); color: #fff;
        font: 700 14px 'Inter', sans-serif; cursor: pointer;
        box-shadow: 0 6px 16px rgba(31, 95, 174, .28);
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }
    .nr-submit svg { width: 18px; height: 18px; transition: transform .2s ease; }
    .nr-submit:hover { filter: brightness(1.08); box-shadow: 0 10px 22px rgba(31, 95, 174, .36); }
    .nr-submit:hover svg { transform: translateX(3px); }
    .nr-submit:active { transform: scale(.98); }
    .nr-submit:focus-visible { outline: 3px solid var(--sky); outline-offset: 3px; }

    /* ----- Panel samping ----- */
    .nr-side { display: grid; gap: 16px; position: sticky; top: 24px; }
    .nr-side .nr-card { padding: 20px; }
    .nr-side-head { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
    .nr-side-ico { display: grid; place-items: center; width: 38px; height: 38px; flex-shrink: 0; border-radius: 12px; background: var(--sky-soft); color: var(--navy-deep); }
    .nr-side-ico svg { width: 20px; height: 20px; }
    .nr-side h4 { font-size: 15px; font-weight: 700; color: var(--navy); line-height: 1.3; }
    .nr-side p { font-size: 13px; line-height: 1.7; color: var(--muted); }
    .nr-secure { display: inline-flex; align-items: center; gap: 8px; margin-top: 14px; padding: 6px 12px; border-radius: 999px; background: var(--ok-soft); color: var(--ok); font-size: 12px; font-weight: 700; }
    .nr-secure svg { width: 16px; height: 16px; }
    .nr-tips { list-style: none; display: grid; gap: 12px; margin-top: 4px; }
    .nr-tips li { display: flex; gap: 10px; align-items: flex-start; font-size: 13px; line-height: 1.5; color: var(--text); }
    .nr-tips svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; color: var(--ok); }

    /* ----- Responsive ----- */
    @media (max-width: 1000px) {
        .nr-layout { grid-template-columns: minmax(0, 1fr); }
        .nr-side { position: static; grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 760px) {
        .nr-selects, .nr-groups, .nr-about, .nr-hint { margin-left: 0; }
    }
    @media (max-width: 640px) {
        .nr-side { grid-template-columns: minmax(0, 1fr); }
    }
    @media (max-width: 560px) {
        .nr { --nr-pad: 18px; }
        .nr-selects, .nr-about { grid-template-columns: minmax(0, 1fr); }
        .nr-row { grid-template-columns: minmax(0, 1fr); gap: 6px; margin-bottom: 16px; }
        .nr-field select, .nr-field input { font-size: 16px; } /* cegah zoom otomatis di iOS */
        .nr-group summary { padding: 10px 12px; gap: 10px; }
        .nr-group-body { padding: 14px 12px 4px; }
        .nr-summary { padding: 14px; }
        .nr-sum-value { font-size: 19px; }
        .nr-submit { width: 100%; }
    }
    @media (prefers-reduced-motion: reduce) {
        .nr-sum-bar > div, .nr-submit, .nr-submit svg, .nr-group summary::after { transition: none; }
    }
@endpush

@section('content')
@php
    // Daftar pilihan & mapel yang ditampilkan di form
    $semesterList = ['Semester 1–5', 'Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5'];
    $kelasList    = ['Kelas X', 'Kelas XI', 'Kelas XII'];

    // Mata pelajaran SMA/MA/SMK (Kurikulum Merdeka & K13), dikelompokkan.
    // key = nama kunci yang disimpan di kolom scores, value = label tampilan.
    $mapelGrup = [
        'Kelompok umum' => [
            'Pendidikan_Agama'   => 'Pendidikan Agama dan Budi Pekerti',
            'Pendidikan_Pancasila' => 'Pendidikan Pancasila (PPKn)',
            'Bahasa_Indonesia'   => 'Bahasa Indonesia',
            'Matematika'         => 'Matematika',
            'Bahasa_Inggris'     => 'Bahasa Inggris',
            'Sejarah'            => 'Sejarah',
            'PJOK'               => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
            'Seni_Budaya'        => 'Seni dan Budaya',
            'Informatika_TIK'    => 'Informatika',
            'Projek_IPAS'        => 'IPAS (Ilmu Pengetahuan Alam dan Sosial)',
            'Muatan_Lokal'       => 'Muatan Lokal / Bahasa Daerah',
        ],
        'Pilihan IPA (Sains)' => [
            'Fisika'             => 'Fisika',
            'Kimia'              => 'Kimia',
            'Biologi'            => 'Biologi',
            'Matematika_Lanjut'  => 'Matematika Tingkat Lanjut',
        ],
        'Pilihan IPS (Sosial)' => [
            'Ekonomi'            => 'Ekonomi',
            'Sosiologi'          => 'Sosiologi',
            'Geografi'           => 'Geografi',
            'Antropologi'        => 'Antropologi',
            'Sejarah_Lanjut'     => 'Sejarah Tingkat Lanjut',
        ],
        'Pilihan bahasa & budaya' => [
            'Bahasa_Indonesia_Lanjut' => 'Bahasa Indonesia Tingkat Lanjut',
            'Bahasa_Inggris_Lanjut'   => 'Bahasa Inggris Tingkat Lanjut',
            'Bahasa_Arab'        => 'Bahasa Arab',
            'Bahasa_Jerman'      => 'Bahasa Jerman',
            'Bahasa_Jepang'      => 'Bahasa Jepang',
            'Bahasa_Korea'       => 'Bahasa Korea',
            'Bahasa_Mandarin'    => 'Bahasa Mandarin',
            'Bahasa_Prancis'     => 'Bahasa Prancis',
        ],
        'Seni, keterampilan & kejuruan' => [
            'Seni_Musik'         => 'Seni Musik',
            'Seni_Rupa'          => 'Seni Rupa',
            'Seni_Teater'        => 'Seni Teater',
            'Seni_Tari'          => 'Seni Tari',
            'Prakarya_Kewirausahaan' => 'Prakarya dan Kewirausahaan',
            'Mapel_Kejuruan'     => 'Mata pelajaran kejuruan (SMK)',
        ],
    ];

    // Ikon tiap kelompok (urutan sama dengan $mapelGrup) — isi path SVG gaya garis
    $ikonGrup = [
        '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
        '<path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/><path d="M8.5 2h7"/><path d="M7 16h10"/>',
        '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
        '<circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>',
    ];

    // Isi form dengan rapor terakhir (kalau ada)
    $kartuTerakhir = $reportCards->first();
    $skorTerakhir = $kartuTerakhir
        ? (is_array($kartuTerakhir->scores) ? $kartuTerakhir->scores : (json_decode($kartuTerakhir->scores, true) ?? []))
        : [];

    // kolom semester menyimpan "Semester ... - Kelas ..."
    [$semPilih, $kelPilih] = array_pad(explode(' - ', old('semester', $kartuTerakhir->semester ?? ''), 2), 2, null);
    if (! in_array($semPilih, $semesterList, true)) $semPilih = $semesterList[0];
    if (! in_array($kelPilih, $kelasList, true))    $kelPilih = 'Kelas XII';
@endphp

<div class="nr">

    <header class="nr-head">
        <span class="nr-head-ico" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </span>
        <div>
            <h2 class="nr-title">Nilai Rapor</h2>
            <p class="nr-sub">Masukkan nilai rapor untuk membantu kami memahami kekuatan akademikmu.</p>
        </div>
    </header>

    @if (session('success'))
        <div class="alert alert-ok">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-err">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="nr-layout">

        <form class="nr-card nr-form" action="{{ route('report-cards.store') }}" method="POST" novalidate>
            @csrf
            <h3>Data nilai akademik</h3>
            <p class="nr-form-sub">Isi sesuai rapor terakhir yang kamu miliki.</p>

            {{-- dikirim ke server sebagai satu nilai: "Semester ... - Kelas ..." --}}
            <input type="hidden" name="semester" id="semester-gabungan" value="{{ $semPilih }} - {{ $kelPilih }}">

            {{-- Ringkasan progres (diperbarui otomatis saat mengisi) --}}
            <div class="nr-summary" aria-live="polite">
                <div>
                    <span class="nr-sum-label">Terisi</span>
                    <div class="nr-sum-value"><span id="sumTerisi">0</span> <small>/ <span id="sumTotal">0</span> mapel</small></div>
                </div>
                <div>
                    <span class="nr-sum-label">Rata-rata sementara</span>
                    <div class="nr-sum-value" id="sumAvg">–</div>
                </div>
                <div class="nr-sum-bar" role="progressbar" aria-label="Kelengkapan nilai" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="sumBarWrap">
                    <div id="sumBar"></div>
                </div>
            </div>

            {{-- 1. Periode --}}
            <section class="nr-sec">
                <div class="nr-sec-head">
                    <span class="nr-sec-num">1</span>
                    <h4>Periode rapor</h4>
                </div>
                <p class="nr-hint">Pilih semester dan kelas dari rapor yang kamu isi.</p>
                <div class="nr-selects">
                    <div class="nr-field">
                        <label class="lbl" for="semester">Semester</label>
                        <select id="semester" onchange="gabungkan()">
                            @foreach ($semesterList as $opt)
                                <option value="{{ $opt }}" @selected($semPilih === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="nr-field">
                        <label class="lbl" for="kelas">Kelas</label>
                        <select id="kelas" onchange="gabungkan()">
                            @foreach ($kelasList as $opt)
                                <option value="{{ $opt }}" @selected($kelPilih === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            {{-- 2. Nilai mata pelajaran --}}
            <section class="nr-sec">
                <div class="nr-sec-head">
                    <span class="nr-sec-num">2</span>
                    <h4>Nilai mata pelajaran</h4>
                </div>
                <p class="nr-hint">Isi hanya mata pelajaran yang kamu ambil. Yang tidak ada di rapormu boleh dikosongkan.</p>

                <div class="nr-groups">
                    @foreach ($mapelGrup as $namaGrup => $daftar)
                        @php
                            // hitung berapa mapel di grup ini yang sudah terisi
                            $terisi = collect(array_keys($daftar))->filter(
                                fn ($k) => filled(old('scores.' . $k, $skorTerakhir[$k] ?? null))
                            )->count();
                            // grup pertama selalu terbuka; grup lain terbuka jika sudah ada isinya / ada error
                            $buka = $loop->first || $terisi > 0
                                || collect(array_keys($daftar))->contains(fn ($k) => $errors->has('scores.' . $k));
                        @endphp
                        <details class="nr-group mapel-group" @if ($buka) open @endif>
                            <summary>
                                <span class="nr-group-ico" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $ikonGrup[$loop->index] ?? $ikonGrup[0] !!}</svg>
                                </span>
                                <span class="nr-group-name">{{ $namaGrup }}</span>
                                <span class="group-count">{{ $terisi }}/{{ count($daftar) }} terisi</span>
                            </summary>
                            <div class="nr-group-body">
                                @foreach ($daftar as $key => $label)
                                    <div class="nr-row nr-field">
                                        <label for="skor-{{ $key }}">{{ $label }}</label>
                                        <input
                                            type="number" id="skor-{{ $key }}" name="scores[{{ $key }}]"
                                            value="{{ old('scores.' . $key, $skorTerakhir[$key] ?? '') }}"
                                            min="0" max="100" step="0.1" inputmode="decimal"
                                            placeholder="Nilai (0-100)"
                                            class="{{ $errors->has('scores.' . $key) ? 'invalid' : '' }}">
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </div>
            </section>

            {{-- 3. Tentang dirimu --}}
            <section class="nr-sec">
                <div class="nr-sec-head">
                    <span class="nr-sec-num">3</span>
                    <h4>Tentang dirimu</h4>
                </div>
                <p class="nr-hint">Pisahkan dengan koma jika lebih dari satu.</p>
                <div class="nr-about">
                    <div class="nr-field">
                        <label class="lbl" for="interests">Minat</label>
                        <input type="text" id="interests" name="interests"
                               value="{{ old('interests', $kartuTerakhir->interests ?? '') }}"
                               placeholder="Contoh: teknologi, desain"
                               class="{{ $errors->has('interests') ? 'invalid' : '' }}">
                    </div>
                    <div class="nr-field">
                        <label class="lbl" for="skills">Keahlian</label>
                        <input type="text" id="skills" name="skills"
                               value="{{ old('skills', $kartuTerakhir->skills ?? '') }}"
                               placeholder="Contoh: coding, public speaking"
                               class="{{ $errors->has('skills') ? 'invalid' : '' }}">
                    </div>
                </div>
            </section>

            <div class="nr-actions">
                <button type="submit" class="nr-submit">
                    Simpan nilai &amp; lanjut
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </div>
        </form>

        <aside class="nr-side">
            <div class="nr-card">
                <div class="nr-side-head">
                    <span class="nr-side-ico" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                    </span>
                    <h4>Data kamu, kendalimu</h4>
                </div>
                <p>Nilai digunakan untuk menyusun rekomendasi pendidikan. Hasilnya bukan penentu mutlak masa depan.</p>
                <div class="nr-secure">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                    Aman dan transparan
                </div>
            </div>

            <div class="nr-card">
                <div class="nr-side-head">
                    <span class="nr-side-ico" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="9" y1="18" x2="15" y2="18"/><line x1="10" y1="22" x2="14" y2="22"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/></svg>
                    </span>
                    <h4>Tips mengisi nilai</h4>
                </div>
                <ul class="nr-tips">
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Gunakan nilai dari rapor asli
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Jangan isi perkiraan jika ragu
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Kamu bisa memperbaruinya nanti
                    </li>
                </ul>
            </div>
        </aside>
    </div>

    <script>
        // Gabungkan pilihan semester + kelas menjadi satu nilai untuk dikirim ke server
        function gabungkan() {
            document.getElementById('semester-gabungan').value =
                document.getElementById('semester').value + ' - ' + document.getElementById('kelas').value;
        }

        // Ringkasan progres: jumlah mapel terisi, rata-rata sementara, dan hitungan per kelompok
        (function () {
            var groups = document.querySelectorAll('.mapel-group');
            var elTerisi = document.getElementById('sumTerisi');
            var elTotal  = document.getElementById('sumTotal');
            var elAvg    = document.getElementById('sumAvg');
            var elBar    = document.getElementById('sumBar');
            var elWrap   = document.getElementById('sumBarWrap');

            function hitung() {
                var terisi = 0, total = 0, jumlah = 0, valid = 0;

                groups.forEach(function (g) {
                    var inputs = g.querySelectorAll('input[type=number]');
                    var n = 0;

                    inputs.forEach(function (i) {
                        total++;
                        if (i.value.trim() !== '') {
                            n++;
                            var v = parseFloat(i.value);
                            if (!isNaN(v) && v >= 0 && v <= 100) { jumlah += v; valid++; }
                        }
                    });

                    terisi += n;

                    var badge = g.querySelector('.group-count');
                    if (badge) { badge.textContent = n + '/' + inputs.length + ' terisi'; }
                    g.classList.toggle('done', inputs.length > 0 && n === inputs.length);
                });

                var persen = total > 0 ? Math.round((terisi / total) * 100) : 0;

                elTerisi.textContent = terisi;
                elTotal.textContent  = total;
                elAvg.textContent    = valid > 0 ? (jumlah / valid).toFixed(1).replace('.', ',') : '–';
                elBar.style.width    = persen + '%';
                elWrap.setAttribute('aria-valuenow', persen);
            }

            document.addEventListener('input', function (e) {
                var t = e.target;
                if (t && t.matches && t.matches('.mapel-group input[type=number]')) {
                    var v = parseFloat(t.value);
                    t.classList.toggle('invalid', t.value.trim() !== '' && (isNaN(v) || v < 0 || v > 100));
                    hitung();
                }
            });

            hitung();
        })();
    </script>

</div>
@endsection