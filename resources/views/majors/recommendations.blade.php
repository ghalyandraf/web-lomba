 @extends('layouts.lantera')

@section('title', 'LANTERA — Rekomendasi Jurusan')
@section('judul', 'Rekomendasi Jurusan')
@section('subjudul', 'Temukan jurusan yang sesuai dengan nilai rapor, minat, dan keterampilanmu.')

@section('content')
<style>
    .recommendation-list {
        display: grid;
        gap: 18px;
    }

    .recommendation-card {
        background: var(--card, #fff);
        border: 1px solid var(--border, #e5e7eb);
        border-radius: 18px;
        padding: 24px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .recommendation-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
    }

    .recommendation-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
    }

    .recommendation-field {
        display: inline-block;
        margin-bottom: 10px;
        padding: 6px 11px;
        border-radius: 999px;
        background: #eaf2ff;
        color: #2455a4;
        font-size: 12px;
        font-weight: 700;
    }

    .recommendation-name {
        margin: 0 0 8px;
        color: var(--text, #172033);
        font-size: 21px;
        font-weight: 750;
    }

    .recommendation-description {
        margin: 0;
        color: var(--muted, #64748b);
        line-height: 1.7;
        font-size: 14px;
    }

    .match-score {
        min-width: 88px;
        text-align: center;
        padding: 12px;
        background: #eff6ff;
        border-radius: 14px;
        color: #1d4ed8;
    }

    .match-score strong {
        display: block;
        font-size: 25px;
        line-height: 1.3;
    }

    .match-score span {
        font-size: 11px;
    }

    .match-progress {
        height: 7px;
        background: #e8edf5;
        border-radius: 999px;
        overflow: hidden;
        margin: 20px 0;
    }

    .match-progress span {
        display: block;
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
        border-radius: inherit;
    }

    .reason-title {
        margin: 0 0 10px;
        font-size: 13px;
        font-weight: 750;
        color: var(--text, #172033);
    }

    .reason-list {
        padding-left: 19px;
        margin: 0;
        color: var(--muted, #64748b);
        font-size: 13px;
        line-height: 1.8;
    }

    .recommendation-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .recommendation-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 10px;
        border: 1px solid #dbe3ef;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .recommendation-button-primary {
        color: #fff;
        background: #2455a4;
        border-color: #2455a4;
    }

    .recommendation-button-secondary {
        color: #2455a4;
        background: #fff;
    }

    .selected-label {
        display: inline-block;
        margin-top: 12px;
        color: #15803d;
        font-size: 12px;
        font-weight: 700;
    }

    .recommendation-notice {
        padding: 15px 18px;
        margin-bottom: 20px;
        border-radius: 12px;
        background: #eff6ff;
        color: #1e40af;
        font-size: 13px;
        line-height: 1.7;
    }

    .recommendation-alert {
        padding: 14px 18px;
        margin-bottom: 18px;
        border-radius: 12px;
        background: #ecfdf5;
        color: #166534;
        font-size: 14px;
    }

    @media (max-width: 600px) {
        .recommendation-card {
            padding: 18px;
        }

        .recommendation-top {
            flex-direction: column;
        }

        .match-score {
            min-width: 0;
            width: 100%;
            box-sizing: border-box;
            text-align: left;
        }

        .recommendation-name {
            font-size: 18px;
        }
    }
</style>

@if (session('success'))
    <div class="recommendation-alert">
        {{ session('success') }}
    </div>
@endif

<div class="recommendation-notice">
    Hasil ini merupakan estimasi kecocokan berdasarkan data yang kamu masukkan,
    bukan jaminan diterima di universitas atau jurusan tertentu.
</div>

@if ($recommendations->isEmpty())
    <div class="recommendation-card">
        <h3 class="recommendation-name">Belum ada rekomendasi</h3>
        <p class="recommendation-description">
            Data jurusan belum tersedia. Silakan coba lagi setelah data jurusan ditambahkan.
        </p>
        <div class="recommendation-actions">
            <a href="{{ route('majors.index') }}"
               class="recommendation-button recommendation-button-primary">
                Lihat Semua Jurusan
            </a>
        </div>
    </div>
@else
    <div class="recommendation-list">
        @foreach ($recommendations as $index => $major)
            <article class="recommendation-card">
                <div class="recommendation-top">
                    <div>
                        <span class="recommendation-field">
                            {{ $major->field ?: 'Bidang Umum' }}
                        </span>

                        <h3 class="recommendation-name">
                            {{ $index + 1 }}. {{ $major->name }}
                        </h3>

                        <p class="recommendation-description">
                            {{ $major->description ?: 'Informasi jurusan belum tersedia.' }}
                        </p>

                        @if (auth()->user()->major_id === $major->id)
                            <span class="selected-label">✓ Jurusan pilihanmu saat ini</span>
                        @endif
                    </div>

                    <div class="match-score">
                        <strong>{{ $major->match_score ?? 0 }}%</strong>
                        <span>Kecocokan estimasi</span>
                    </div>
                </div>

                <div class="match-progress">
                    <span style="width: {{ max(0, min(100, (int) ($major->match_score ?? 0))) }}%"></span>
                </div>

                <h4 class="reason-title">Mengapa jurusan ini direkomendasikan?</h4>

                @if (!empty($major->match_reasons))
                    <ul class="reason-list">
                        @foreach ($major->match_reasons as $reason)
                            <li>{{ $reason }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="recommendation-description">
                        Belum ada penjelasan kecocokan untuk jurusan ini.
                    </p>
                @endif

                <div class="recommendation-actions">
                    <a href="{{ route('majors.show', $major->slug) }}"
                       class="recommendation-button recommendation-button-secondary">
                        Detail Jurusan
                    </a>

                    <form action="{{ route('majors.select', $major) }}" method="POST">
                        @csrf
                        <button type="submit" class="recommendation-button recommendation-button-primary">
                            {{ auth()->user()->major_id === $major->id ? 'Pilih Lagi' : 'Pilih Jurusan' }}
                        </button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
@endif

<div class="recommendation-actions" style="margin-top: 22px;">
    <a href="{{ route('report-cards.index') }}"
       class="recommendation-button recommendation-button-secondary">
        Perbarui Data Rapor
    </a>

    <a href="{{ route('majors.index') }}"
       class="recommendation-button recommendation-button-secondary">
        Jelajahi Semua Jurusan
    </a>
</div>
@endsection