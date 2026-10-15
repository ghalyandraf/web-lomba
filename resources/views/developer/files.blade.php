@extends('layouts.lantera')

@section('title', 'Rekomendasi Jurusan — LANTERA')
@section('judul', 'Rekomendasi Jurusan')
@section('subjudul', 'Masukkan nilai kamu, lalu lihat jurusan yang paling cocok beserta persentase kecocokannya.')

@push('styles')
<style>
    .dev-hero {
        background: linear-gradient(135deg, var(--navy), var(--navy-deep));
        color: #fff;
        padding: 26px;
        border-radius: 18px;
        margin-bottom: 24px;
    }

    .dev-hero h2 {
        font-size: 22px;
        margin-bottom: 8px;
    }

    .dev-hero p {
        color: #dce9f8;
        font-size: 12px;
        line-height: 1.8;
    }

    .section-heading {
        color: var(--navy);
        font-size: 16px;
        font-weight: 800;
        margin: 26px 0 8px;
    }

    .section-description {
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 14px;
        line-height: 1.8;
    }

    .notice {
        padding: 14px 16px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--surface);
        font-size: 12px;
        line-height: 1.8;
        margin-bottom: 18px;
    }

    .notice strong {
        color: var(--navy);
    }

    .notice.error {
        border-color: #e5a3a3;
        background: #fdf1f1;
        color: #9b2c2c;
    }

    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .form-card h3 {
        color: var(--navy);
        font-size: 14px;
        margin-bottom: 14px;
    }

    .score-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 8px;
    }

    .field {
        min-width: 0;
    }

    .field label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 6px;
    }

    .field input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: var(--bg);
        font-family: inherit;
        font-size: 12px;
        color: inherit;
    }

    .field input:focus {
        outline: 2px solid var(--sky-soft);
        border-color: var(--navy);
    }

    .tag-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 4px;
    }

    .tag-option {
        position: relative;
    }

    .tag-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .tag-option span {
        display: inline-block;
        padding: 7px 12px;
        border: 1px solid var(--border);
        border-radius: 20px;
        background: var(--bg);
        font-size: 11px;
        cursor: pointer;
        transition: all .15s ease;
    }

    .tag-option input:checked + span {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }

    .tag-option input:focus-visible + span {
        outline: 2px solid var(--navy);
        outline-offset: 2px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 18px;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-ghost {
        padding: 11px 18px;
        border-radius: 8px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        border: 0;
        background: var(--navy-deep);
        color: #fff;
    }

    .btn-primary:hover {
        filter: brightness(1.08);
    }

    .btn-ghost {
        border: 1px solid var(--border);
        background: transparent;
        color: var(--navy);
    }

    .summary-bar {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .summary-chip {
        padding: 8px 14px;
        border-radius: 20px;
        background: var(--sky-soft);
        color: var(--navy);
        font-size: 11px;
        font-weight: 700;
    }

    .result-list {
        display: grid;
        gap: 14px;
        margin-bottom: 24px;
    }

    .result-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 15px;
        padding: 20px;
        display: grid;
        grid-template-columns: 56px minmax(0, 1fr) 96px;
        gap: 16px;
        align-items: center;
    }

    .result-card.top {
        border-color: var(--navy);
        box-shadow: 0 6px 20px rgba(16, 28, 48, .08);
    }

    .rank {
        width: 44px;
        height: 44px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: var(--sky-soft);
        color: var(--navy);
        font-weight: 800;
        font-size: 16px;
    }

    .result-card.top .rank {
        background: var(--navy);
        color: #fff;
    }

    .result-body {
        min-width: 0;
    }

    .result-body h3 {
        color: var(--navy);
        font-size: 15px;
        margin-bottom: 6px;
        overflow-wrap: anywhere;
    }

    .result-meta {
        color: var(--muted);
        font-size: 11px;
        line-height: 1.8;
        margin-bottom: 8px;
    }

    .match-bar {
        height: 8px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .match-fill {
        height: 100%;
        border-radius: 20px;
        background: #d9a21b;
    }

    .match-fill.high { background: var(--ok, #1f9d63); }
    .match-fill.mid  { background: #2f80c9; }
    .match-fill.low  { background: #d9a21b; }
    .match-fill.none { background: #c0392b; }

    .tag-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .tag-chip {
        padding: 4px 9px;
        border-radius: 20px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: 10px;
        color: var(--muted);
    }

    .tag-chip.matched {
        background: var(--ok-soft);
        border-color: transparent;
        color: var(--ok);
        font-weight: 700;
    }

    .percent-box {
        text-align: center;
    }

    .percent-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--navy);
        line-height: 1;
    }

    .percent-value small {
        font-size: 14px;
    }

    .percent-label {
        display: inline-block;
        margin-top: 8px;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        background: var(--sky-soft);
        color: var(--navy);
    }

    .percent-label.high {
        background: var(--ok-soft);
        color: var(--ok);
    }

    .empty-state {
        text-align: center;
        padding: 36px 20px;
        background: var(--surface);
        border: 1px dashed var(--border);
        border-radius: 15px;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.8;
        margin-bottom: 24px;
    }

    @media (max-width: 760px) {
        .score-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dev-hero {
            padding: 20px;
        }

        .dev-hero h2 {
            font-size: 19px;
        }

        .result-card {
            grid-template-columns: 44px minmax(0, 1fr);
        }

        .percent-box {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: left;
        }

        .percent-label {
            margin-top: 0;
        }
    }

    @media (max-width: 480px) {
        .score-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
@php
    // Fallback supaya halaman tetap jalan kalau controller belum kirim data.
    $subjects = $subjects ?? [
        'matematika'        => 'Matematika',
        'bahasa_indonesia'  => 'Bahasa Indonesia',
        'bahasa_inggris'    => 'Bahasa Inggris',
        'fisika'            => 'Fisika',
        'kimia'             => 'Kimia',
        'biologi'           => 'Biologi',
        'ekonomi'           => 'Ekonomi',
        'sosiologi'         => 'Sosiologi',
        'geografi'          => 'Geografi',
    ];
    $interestTags = $interestTags ?? [];
    $results      = isset($results) ? collect($results) : null;
    $selectedTags = old('interest_tags', $selectedTags ?? []);

    $labelFor = function ($pct) {
        if ($pct >= 80) return ['Sangat Cocok', 'high', 'high'];
        if ($pct >= 60) return ['Cocok', '', 'mid'];
        if ($pct >= 40) return ['Cukup Cocok', '', 'low'];
        return ['Kurang Cocok', '', 'none'];
    };
@endphp

<section class="dev-hero">
    <h2>Temukan Jurusan yang Cocok untuk Kamu</h2>
    <p>
        Isi nilai mata pelajaran dan pilih minat kamu. Sistem akan menghitung
        tingkat kecocokan (%) untuk setiap jurusan, lalu mengurutkannya dari
        yang paling cocok.
    </p>
</section>

@if ($errors->any())
    <div class="notice error">
        <strong>Periksa kembali isian kamu:</strong><br>
        @foreach ($errors->all() as $error)
            • {{ $error }}<br>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ url('/rekomendasi-jurusan') }}" class="form-card">
    @csrf

    <h3>Nilai Mata Pelajaran</h3>
    <div class="score-grid">
        @foreach ($subjects as $key => $label)
            <div class="field">
                <label for="grade-{{ $key }}">{{ $label }}</label>
                <input
                    type="number"
                    id="grade-{{ $key }}"
                    name="grades[{{ $key }}]"
                    min="0"
                    max="100"
                    step="0.01"
                    inputmode="decimal"
                    placeholder="0 – 100"
                    value="{{ old('grades.' . $key, data_get($grades ?? [], $key)) }}"
                >
            </div>
        @endforeach
    </div>

    @if (count($interestTags))
        <h3 style="margin-top:22px">Minat (opsional)</h3>
        <div class="tag-list">
            @foreach ($interestTags as $tag)
                <label class="tag-option">
                    <input
                        type="checkbox"
                        name="interest_tags[]"
                        value="{{ $tag }}"
                        @checked(in_array($tag, $selectedTags))
                    >
                    <span>{{ $tag }}</span>
                </label>
            @endforeach
        </div>
    @endif

    <div class="form-actions">
        <button type="submit" class="btn-primary">Lihat Rekomendasi</button>
        <a href="{{ url('/rekomendasi-jurusan') }}" class="btn-ghost">Reset</a>
    </div>
</form>

@if ($results === null)
    <div class="empty-state">
        Belum ada hasil. Isi nilai di atas lalu klik <strong>Lihat Rekomendasi</strong>.
    </div>
@elseif ($results->isEmpty())
    <div class="empty-state">
        Belum ada jurusan yang cocok dengan nilai dan minat yang kamu masukkan.
        Coba ubah nilai atau kurangi filter minat.
    </div>
@else
    <h2 class="section-heading">Hasil Rekomendasi</h2>
    <p class="section-description">
        Diurutkan dari persentase kecocokan tertinggi. Persentase dihitung dari
        kesesuaian nilai kamu dengan nilai minimum jurusan
        @if (count($selectedTags)) serta kecocokan tag minat @endif.
    </p>

    <div class="summary-bar">
        <span class="summary-chip">{{ $results->count() }} jurusan ditemukan</span>
        <span class="summary-chip">
            Tertinggi: {{ data_get($results->first(), 'name') }}
            ({{ number_format((float) data_get($results->first(), 'percentage'), 1) }}%)
        </span>
    </div>

    <div class="result-list">
        @foreach ($results as $index => $item)
            @php
                $pct     = max(0, min(100, (float) data_get($item, 'percentage', 0)));
                [$labelText, $labelClass, $fillClass] = $labelFor($pct);
                $tags    = (array) data_get($item, 'tags', []);
                $matched = (array) data_get($item, 'matched_tags', []);
                $minScore = data_get($item, 'min_score');
            @endphp

            <article class="result-card {{ $index === 0 ? 'top' : '' }}">
                <div class="rank">{{ $index + 1 }}</div>

                <div class="result-body">
                    <h3>{{ data_get($item, 'name', '-') }}</h3>

                    <div class="result-meta">
                        @if ($minScore !== null)
                            Nilai minimum: <strong>{{ $minScore }}</strong>
                        @endif
                        @if (data_get($item, 'note'))
                            <br>{{ data_get($item, 'note') }}
                        @endif
                    </div>

                    <div class="match-bar" role="progressbar"
                         aria-valuenow="{{ round($pct) }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="match-fill {{ $fillClass }}" style="width: {{ $pct }}%"></div>
                    </div>

                    @if (count($tags))
                        <div class="tag-chips">
                            @foreach ($tags as $tag)
                                <span class="tag-chip {{ in_array($tag, $matched) ? 'matched' : '' }}">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="percent-box">
                    <div class="percent-value">{{ number_format($pct, 0) }}<small>%</small></div>
                    <span class="percent-label {{ $labelClass }}">{{ $labelText }}</span>
                </div>
            </article>
        @endforeach
    </div>
@endif

<div class="notice">
    <strong>Catatan:</strong> Hasil ini hanya rekomendasi berdasarkan nilai dan
    minat yang kamu masukkan. Tetap pertimbangkan passion, prospek karier, dan
    syarat seleksi masing-masing kampus.
</div>
@endsection