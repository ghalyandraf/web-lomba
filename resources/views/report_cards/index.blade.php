@extends('layouts.lantera')

@section('title', 'Nilai Rapor — LANTERA')
@section('judul', 'Selamat datang, ' . (auth()->user()->name ?? 'Siswa') . '!')
@section('subjudul', 'Yuk, kenali potensimu dan rancang masa depanmu.')
@section('bantuan', 'Satu langkah kecil hari ini bisa mengubah masa depanmu.')

@push('styles')
    .page-title { font-size: 22px; font-weight: 700; color: var(--navy); line-height: 1.2; }
    .page-sub { font-size: 12px; color: var(--muted); margin: 2px 0 16px; }

    .stepper { display: flex; align-items: center; flex-wrap: wrap; gap: 8px 22px; padding: 14px 18px; margin-bottom: 18px; }
    .step { display: flex; align-items: center; gap: 8px; font-size: 11px; color: var(--muted); }
    .step-num { width: 24px; height: 24px; border-radius: 50%; background: var(--sky-soft); color: var(--navy-deep); font-size: 11px; font-weight: 700; display: grid; place-items: center; flex-shrink: 0; }
    .step.active { color: var(--navy); font-weight: 700; }
    .step.active .step-num { background: var(--navy-deep); color: #fff; }

    .layout { display: grid; grid-template-columns: 1fr 300px; gap: 16px; align-items: start; }
    .form-card { padding: 24px; }
    .form-card h3 { font-size: 16px; font-weight: 700; color: var(--navy); }
    .form-card .sub { font-size: 11px; color: var(--muted); margin: 2px 0 18px; }

    .selects { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding-bottom: 22px; border-bottom: 1px solid var(--border); }
    .field label.lbl { display: block; font-size: 11px; font-weight: 500; color: var(--text); margin-bottom: 6px; }
    .field select, .field input { width: 100%; padding: 11px 12px; border: 1px solid var(--border); border-radius: 8px; background: #fff; font-family: inherit; font-size: 12px; color: var(--text); }
    .field select {
        appearance: none; -webkit-appearance: none; padding-right: 30px; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%236b7a90' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center;
    }
    .field input::placeholder { color: #9aa7ba; }
    .field input.invalid { border-color: var(--danger); }
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }

    .mapel-title { font-size: 13px; font-weight: 700; color: var(--navy); margin: 20px 0 6px; }
    .mapel-hint { font-size: 10px; color: var(--muted); margin-bottom: 12px; }
    .mapel-row { display: grid; grid-template-columns: 1fr 165px; align-items: center; gap: 16px; margin-bottom: 12px; }
    .mapel-row label { font-size: 12px; color: var(--text); }
    .form-actions { margin-top: 34px; }

    /* Kelompok mata pelajaran (bisa dibuka/tutup) */
    .mapel-group { border: 1px solid var(--border); border-radius: 10px; margin-bottom: 10px; background: #fff; }
    .mapel-group summary { list-style: none; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 12px 14px; font-size: 12px; font-weight: 700; color: var(--navy); }
    .mapel-group summary::-webkit-details-marker { display: none; }
    .mapel-group summary::after { content: ''; width: 8px; height: 8px; border-right: 2px solid var(--muted); border-bottom: 2px solid var(--muted); transform: rotate(45deg); transition: transform .15s; flex-shrink: 0; }
    .mapel-group[open] summary::after { transform: rotate(-135deg); }
    .mapel-group .group-count { font-size: 10px; font-weight: 500; color: var(--muted); margin-left: auto; margin-right: 8px; }
    .mapel-group .group-body { padding: 4px 14px 6px; border-top: 1px solid var(--border); padding-top: 14px; }

    .side { display: grid; gap: 16px; }
    .side .card { padding: 16px 18px; }
    .side h4 { font-size: 12px; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
    .side p { font-size: 10px; color: var(--muted); line-height: 1.6; }
    .secure { display: flex; align-items: center; gap: 10px; margin-top: 12px; font-size: 10px; font-weight: 600; color: var(--navy-deep); }
    .secure-icon { width: 32px; height: 28px; border-radius: 8px; background: var(--sky-soft); flex-shrink: 0; }
    .tips { list-style: none; display: grid; gap: 8px; margin-top: 10px; }
    .tips li { font-size: 10px; display: flex; gap: 8px; align-items: center; }
    .tips li::before { content: ''; width: 4px; height: 4px; border-radius: 50%; background: var(--text); flex-shrink: 0; }

    @media (max-width: 1000px) { .layout { grid-template-columns: 1fr; } }
    @media (max-width: 560px) { .selects { grid-template-columns: 1fr; } .mapel-row { grid-template-columns: 1fr; gap: 6px; } }
@endpush

@section('content')
    <h2 class="page-title">Nilai Rapor</h2>
    <p class="page-sub">Masukkan nilai rapor untuk membantu kami memahami kekuatan akademikmu.</p>

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

    <div class="layout">
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

        <form class="card form-card" action="{{ route('report-cards.store') }}" method="POST" novalidate>
            @csrf
            <h3>Data nilai akademik</h3>
            <p class="sub">Isi sesuai rapor terakhir yang kamu miliki.</p>

            {{-- dikirim ke server sebagai satu nilai: "Semester ... - Kelas ..." --}}
            <input type="hidden" name="semester" id="semester-gabungan" value="{{ $semPilih }} - {{ $kelPilih }}">

            <div class="selects">
                <div class="field">
                    <label class="lbl" for="semester">Semester</label>
                    <select id="semester" onchange="gabungkan()">
                        @foreach ($semesterList as $opt)
                            <option value="{{ $opt }}" @selected($semPilih === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label class="lbl" for="kelas">Kelas</label>
                    <select id="kelas" onchange="gabungkan()">
                        @foreach ($kelasList as $opt)
                            <option value="{{ $opt }}" @selected($kelPilih === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h4 class="mapel-title">Nilai mata pelajaran</h4>
            <p class="mapel-hint">Isi hanya mata pelajaran yang kamu ambil. Yang tidak ada di rapormu boleh dikosongkan.</p>

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
                <details class="mapel-group" @if ($buka) open @endif>
                    <summary>
                        {{ $namaGrup }}
                        <span class="group-count">{{ $terisi }}/{{ count($daftar) }} terisi</span>
                    </summary>
                    <div class="group-body">
                        @foreach ($daftar as $key => $label)
                            <div class="mapel-row field">
                                <label for="skor-{{ $key }}">{{ $label }}</label>
                                <input
                                    type="number" id="skor-{{ $key }}" name="scores[{{ $key }}]"
                                    value="{{ old('scores.' . $key, $skorTerakhir[$key] ?? '') }}"
                                    min="0" max="100" step="0.1" inputmode="decimal"
                                    placeholder="Masukkan nilai (0-100)"
                                    class="{{ $errors->has('scores.' . $key) ? 'invalid' : '' }}">
                            </div>
                        @endforeach
                    </div>
                </details>
            @endforeach

            <h4 class="mapel-title">Tentang dirimu</h4>
            <div class="mapel-row field">
                <label for="interests">Minat</label>
                <input type="text" id="interests" name="interests"
                       value="{{ old('interests', $kartuTerakhir->interests ?? '') }}"
                       placeholder="Contoh: teknologi, desain"
                       class="{{ $errors->has('interests') ? 'invalid' : '' }}">
            </div>
            <div class="mapel-row field">
                <label for="skills">Keahlian</label>
                <input type="text" id="skills" name="skills"
                       value="{{ old('skills', $kartuTerakhir->skills ?? '') }}"
                       placeholder="Contoh: coding, public speaking"
                       class="{{ $errors->has('skills') ? 'invalid' : '' }}">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan nilai &amp; lanjut</button>
            </div>
        </form>

        <aside class="side">
            <div class="card">
                <h4>Data kamu, kendalimu</h4>
                <p>Nilai digunakan untuk menyusun rekomendasi pendidikan. Hasilnya bukan penentu mutlak masa depan.</p>
                <div class="secure"><span class="secure-icon"></span> Aman dan transparan</div>
            </div>
            <div class="card">
                <h4>Tips mengisi nilai</h4>
                <ul class="tips">
                    <li>Gunakan nilai dari rapor asli</li>
                    <li>Jangan isi perkiraan jika ragu</li>
                    <li>Kamu bisa memperbaruinya nanti</li>
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
    </script>
@endsection