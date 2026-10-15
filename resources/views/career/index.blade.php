@extends('layouts.lantera')

@section('title', 'LANTERA — Rencana Karier')

@section('judul', 'Rencana Karier')
@section('subjudul', 'Susun langkah nyata dari bangku sekolah hingga siap terjun ke dunia profesional.')

@section('content')
@push('styles')
<style>
  /* =====================================================
     RENCANA KARIER — LANTERA
  ===================================================== */
  .rk{
    --ok:#1e7e4f; --ok-soft:#e6f6ee; --ok-line:#b9e5d2;
    --err:#c0392b; --err-soft:#fdecea; --err-line:#f3c3c3;
    --c1:#4aa8f0; --c2:#2467b3; --c3:#163a6b;
    --shadow-sm:0 2px 10px rgba(22,58,107,.04);
    --shadow-md:0 10px 30px rgba(22,58,107,.09);
    --shadow-lg:0 18px 44px rgba(22,58,107,.14);
  }

  /* ---------- Ikon ---------- */
  .ic{width:16px;height:16px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
  .ic.lg{width:28px;height:28px}
  .ic.sm{width:13px;height:13px}

  /* ---------- Animasi masuk ---------- */
  @keyframes rkUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
  @keyframes rkGrow{from{transform:scaleX(0)}to{transform:scaleX(1)}}
  @keyframes rkDrop{from{opacity:0;transform:translateY(-10px) scale(.99)}to{opacity:1;transform:none}}
  .rk-in{animation:rkUp .55s cubic-bezier(.2,.7,.2,1) both;animation-delay:var(--d,0s)}

  /* ---------- Alert ---------- */
  .alert{display:flex;align-items:flex-start;gap:10px;background:var(--ok-soft);border:1px solid var(--ok-line);color:var(--ok);border-radius:14px;padding:14px 18px;font-size:12.5px;font-weight:500;margin-bottom:20px;box-shadow:0 2px 8px rgba(30,126,79,.06)}
  .alert .ic{margin-top:2px}
  .alert.err{background:var(--err-soft);border-color:var(--err-line);color:var(--err);box-shadow:0 2px 8px rgba(192,57,43,.06)}

  /* ---------- Statistik ---------- */
  .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-bottom:34px}
  .stat{
    position:relative;display:flex;align-items:center;gap:16px;overflow:hidden;
    background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:20px 22px;
    box-shadow:var(--shadow-sm);transition:transform .25s ease,box-shadow .25s ease,border-color .25s ease;
  }
  .stat::after{content:"";position:absolute;width:120px;height:120px;right:-40px;top:-50px;border-radius:50%;background:radial-gradient(circle,rgba(91,181,224,.22),transparent 70%);pointer-events:none}
  .stat:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);border-color:var(--sky)}
  .stat-ico{width:48px;height:48px;border-radius:14px;display:grid;place-items:center;flex-shrink:0;background:var(--sky-soft);color:var(--navy-deep)}
  .stat-ico .ic{width:22px;height:22px}
  .stat.ok .stat-ico{background:var(--ok-soft);color:var(--ok)}
  .stat-body{min-width:0;position:relative;z-index:1}
  .stat small{display:block;font-size:10.5px;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.06em}
  .stat b{display:block;font-size:24px;line-height:1.2;color:var(--navy);margin:3px 0 1px;letter-spacing:-.01em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .stat.text b{font-size:17px;margin:6px 0 3px}
  .stat span.sub{display:block;font-size:11px;color:var(--muted)}

  /* ---------- Judul bagian ---------- */
  .head-row{display:flex;justify-content:space-between;align-items:center;gap:14px;margin-bottom:16px}
  .head-row h3{font-size:19px;font-weight:700;color:var(--navy);letter-spacing:-.01em}
  .head-row p{font-size:12px;color:var(--muted);margin-top:3px}

  /* ---------- Tombol ---------- */
  .rk .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border:0;cursor:pointer;font-family:inherit;font-size:13px;font-weight:700;border-radius:12px;white-space:nowrap;transition:background .18s,color .18s,transform .1s,box-shadow .18s}
  .rk .btn:active{transform:translateY(1px)}
  .rk .btn:focus-visible{outline:2px solid var(--navy-deep);outline-offset:3px}
  .btn-main{padding:13px 24px;background:var(--navy-deep);color:#fff;box-shadow:0 8px 18px rgba(31,95,174,.26)}
  .btn-main:hover{background:var(--navy-darker);box-shadow:0 10px 22px rgba(31,95,174,.32)}
  .btn-ghost{padding:13px 20px;background:transparent;color:var(--muted);border:1px solid var(--border)!important}
  .btn-ghost:hover{background:var(--bg);color:var(--navy)}
  #toggleForm{padding:11px 18px;background:var(--sky-soft);color:var(--navy-deep)}
  #toggleForm:hover{background:var(--navy-deep);color:#fff}

  /* ---------- Form ---------- */
  .form-card{
    position:relative;display:none;overflow:hidden;
    background:var(--surface);border:1px solid var(--border);border-radius:22px;
    padding:30px 30px 28px;margin-bottom:38px;box-shadow:var(--shadow-md);
  }
  .form-card::before{content:"";position:absolute;left:0;right:0;top:0;height:4px;background:linear-gradient(90deg,var(--c1),var(--c2),var(--c3))}
  .form-card.open{display:block;animation:rkDrop .35s cubic-bezier(.2,.7,.2,1)}

  .fs{margin-bottom:26px}
  .fs-title{display:flex;align-items:center;gap:10px;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:16px}
  .fs-title .num{width:26px;height:26px;border-radius:9px;background:var(--sky-soft);color:var(--navy-deep);display:grid;place-items:center}
  .fs-title .num .ic{width:14px;height:14px}
  .fs-title::after{content:"";flex:1;height:1px;background:var(--border)}

  .grid2{display:grid;grid-template-columns:1fr 1fr;gap:20px}
  .grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}

  .rk label{display:block;font-size:11.5px;font-weight:600;color:var(--navy);margin-bottom:8px}
  .rk input[type=text],.rk input[type=number],.rk textarea{
    width:100%;border:1px solid var(--border);border-radius:12px;padding:13px 16px;
    font:400 13px 'Inter',sans-serif;color:var(--text);background:#fbfdff;outline:none;
    transition:border-color .2s,box-shadow .2s,background .2s;
  }
  .rk textarea{resize:vertical;min-height:110px;line-height:1.6}
  .rk input[type=text]:hover,.rk input[type=number]:hover,.rk textarea:hover{border-color:#cfdceb}
  .rk input[type=text]:focus,.rk input[type=number]:focus,.rk textarea:focus{background:#fff;border-color:var(--sky);box-shadow:0 0 0 4px var(--sky-soft)}
  .rk ::placeholder{color:#9aaabb}

  .step-label{display:flex;align-items:center;gap:8px}
  .dot{width:22px;height:22px;border-radius:50%;display:grid;place-items:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0}
  .d1{background:var(--c1)}.d2{background:var(--c2)}.d3{background:var(--c3)}

  /* slider progress */
  .range-row{display:flex;align-items:center;gap:18px}
  .rk .range-row input[type=range]{
    -webkit-appearance:none;appearance:none;flex:1;height:8px;padding:0;border:0;border-radius:99px;outline:none;cursor:pointer;
    background:linear-gradient(90deg,var(--navy-deep) var(--v,0%),var(--sky-soft) var(--v,0%));
  }
  .rk .range-row input[type=range]::-webkit-slider-thumb{
    -webkit-appearance:none;appearance:none;width:24px;height:24px;border-radius:50%;background:#fff;
    border:4px solid var(--navy-deep);box-shadow:0 4px 10px rgba(22,58,107,.25);transition:transform .15s;
  }
  .rk .range-row input[type=range]::-moz-range-thumb{
    width:16px;height:16px;border-radius:50%;background:#fff;border:4px solid var(--navy-deep);box-shadow:0 4px 10px rgba(22,58,107,.25);
  }
  .rk .range-row input[type=range]:hover::-webkit-slider-thumb{transform:scale(1.1)}
  .rk .range-row input[type=range]:focus-visible::-webkit-slider-thumb{box-shadow:0 0 0 5px var(--sky-soft)}
  .rk .range-row input[type=number]{width:96px;text-align:center;font-weight:700;color:var(--navy)}
  .range-scale{display:flex;justify-content:space-between;margin-top:8px;font-size:10px;color:var(--muted);padding-right:114px}

  .form-actions{display:flex;gap:12px;align-items:center;justify-content:flex-end;margin-top:8px;padding-top:22px;border-top:1px solid var(--border)}
  .form-hint{margin-right:auto;font-size:11.5px;color:var(--muted)}

  /* ---------- Kartu rencana ---------- */
  .plan{
    position:relative;overflow:hidden;
    background:var(--surface);border:1px solid var(--border);border-radius:22px;
    padding:26px;margin-bottom:22px;box-shadow:var(--shadow-sm);
    transition:transform .28s cubic-bezier(.2,.7,.2,1),box-shadow .28s ease,border-color .28s ease;
  }
  .plan::before{content:"";position:absolute;left:0;top:0;bottom:0;width:4px;background:linear-gradient(180deg,var(--c1),var(--c3))}
  .plan.done::before{background:linear-gradient(180deg,#3fc58a,var(--ok))}
  .plan:hover{transform:translateY(-3px);box-shadow:var(--shadow-lg);border-color:var(--sky)}

  .plan-head{display:flex;justify-content:space-between;align-items:center;gap:18px;margin-bottom:22px}
  .plan-title{display:flex;align-items:center;gap:15px;min-width:0}
  .plan-icon{width:52px;height:52px;border-radius:16px;background:linear-gradient(135deg,var(--navy-deep),var(--sky));color:#fff;display:grid;place-items:center;font-size:21px;font-weight:700;flex-shrink:0;box-shadow:0 8px 18px rgba(31,95,174,.25)}
  .plan.done .plan-icon{background:linear-gradient(135deg,var(--ok),#46c98e);box-shadow:0 8px 18px rgba(30,126,79,.25)}
  .plan-title h4{font-size:19px;color:var(--navy);line-height:1.3;letter-spacing:-.01em;overflow-wrap:anywhere}

  .chip{display:inline-flex;align-items:center;gap:6px;margin-top:7px;background:var(--bg);color:var(--muted);font-size:10.5px;font-weight:600;padding:5px 12px;border-radius:99px;border:1px solid var(--border)}

  /* cincin progress */
  .ring{--p:0;position:relative;width:62px;height:62px;border-radius:50%;flex-shrink:0;display:grid;place-items:center;
    background:conic-gradient(var(--navy-deep) calc(var(--p) * 1%), var(--sky-soft) 0)}
  .ring::before{content:"";position:absolute;inset:6px;border-radius:50%;background:var(--surface)}
  .ring span{position:relative;font-size:13px;font-weight:700;color:var(--navy)}
  .plan.done .ring{background:conic-gradient(var(--ok) 100%, var(--ok-soft) 0)}
  .plan.done .ring span{color:var(--ok)}

  .plan-side{display:flex;align-items:center;gap:14px;flex-shrink:0}
  .badge{display:inline-flex;align-items:center;gap:6px;background:var(--sky-soft);color:var(--navy-deep);font-size:11px;font-weight:700;padding:7px 14px;border-radius:99px;white-space:nowrap}
  .badge.done{background:var(--ok-soft);color:var(--ok)}
  .badge .ic{width:13px;height:13px;stroke-width:2.6}

  .progress{height:9px;background:var(--sky-soft);border-radius:99px;overflow:hidden;margin-bottom:24px}
  .progress i{display:block;height:100%;width:var(--w);border-radius:99px;transform-origin:left;
    background:linear-gradient(90deg,var(--navy-deep),var(--sky));animation:rkGrow 1s cubic-bezier(.2,.7,.2,1) .15s both}
  .plan.done .progress i{background:linear-gradient(90deg,var(--ok),#46c98e)}

  /* timeline 3 tahap */
  .timeline{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
  .tl{position:relative;background:var(--bg);border:1px solid var(--border);border-top:3px solid var(--tc);border-radius:14px;padding:16px 16px 18px;font-size:12.5px;line-height:1.65;color:var(--text);overflow-wrap:anywhere;transition:background .2s,box-shadow .2s}
  .tl:hover{background:#fff;box-shadow:var(--shadow-sm)}
  .tl.s1{--tc:var(--c1)}.tl.s2{--tc:var(--c2)}.tl.s3{--tc:var(--c3)}
  .tl:not(:last-child)::after{
    content:"";position:absolute;z-index:2;right:-14px;top:50%;width:10px;height:10px;margin-top:-5px;
    border-top:2px solid #b4c6dc;border-right:2px solid #b4c6dc;transform:rotate(45deg);
  }
  .tl-head{display:flex;align-items:center;gap:8px;font-size:11px;font-weight:700;color:var(--navy);margin-bottom:10px;text-transform:uppercase;letter-spacing:.05em}

  .plan-date{display:flex;align-items:center;gap:6px;margin-top:18px;font-size:11px;color:var(--muted);font-weight:500}

  /* ---------- Kondisi kosong ---------- */
  .empty{position:relative;overflow:hidden;background:var(--surface);border:2px dashed #cfe0f1;border-radius:22px;padding:56px 24px;text-align:center}
  .empty::before{content:"";position:absolute;width:320px;height:320px;left:50%;top:-170px;margin-left:-160px;border-radius:50%;background:radial-gradient(circle,rgba(91,181,224,.2),transparent 70%);pointer-events:none}
  .empty>*{position:relative}
  .empty .ico{width:70px;height:70px;border-radius:22px;background:var(--sky-soft);color:var(--navy-deep);display:grid;place-items:center;margin:0 auto 18px;animation:rkFloat 3.6s ease-in-out infinite}
  @keyframes rkFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
  .empty b{display:block;font-size:18px;color:var(--navy);margin-bottom:8px}
  .empty p{font-size:13px;color:var(--muted);max-width:400px;margin:0 auto 22px;line-height:1.65}

  /* ---------- Responsive ---------- */
  @media (max-width:960px){
    .stats{grid-template-columns:1fr}
    .grid2,.grid3{grid-template-columns:1fr}
    .timeline{grid-template-columns:1fr;gap:16px}
    .tl:not(:last-child)::after{right:auto;left:50%;top:auto;bottom:-14px;margin:0 0 0 -5px;transform:rotate(135deg)}
  }
  @media (max-width:600px){
    .form-card{padding:24px 18px 22px}
    .plan{padding:20px 18px 20px 22px}
    .plan-head{flex-direction:column;align-items:flex-start}
    .plan-side{width:100%;justify-content:space-between}
    .head-row{flex-wrap:wrap}
    .range-scale{padding-right:0}
    .range-row{flex-wrap:wrap}
    .rk .range-row input[type=range]{flex-basis:100%}
    .form-actions{flex-direction:column-reverse;align-items:stretch}
    .form-hint{margin:6px 0 0;text-align:center}
    .form-actions .btn{width:100%}
  }
  @media (prefers-reduced-motion:reduce){
    .rk *,.rk *::before,.rk *::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}
  }
</style>
@endpush

<!-- ===== KUMPULAN IKON SVG ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="i-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
  <symbol id="i-steps" viewBox="0 0 24 24"><polyline points="3 21 8 21 8 16 13 16 13 11 18 11 18 6 21 6"/></symbol>
  <symbol id="i-trend" viewBox="0 0 24 24"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></symbol>
  <symbol id="i-cap" viewBox="0 0 24 24"><path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></symbol>
  <symbol id="i-compass" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></symbol>
  <symbol id="i-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
  <symbol id="i-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="i-minus" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="i-layers" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></symbol>
  <symbol id="i-calendar" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></symbol>
  <symbol id="i-save" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></symbol>
</svg>

@php
  $jumlah   = $careerPlans->count();
  $terbaru  = $jumlah ? $careerPlans->first()->target_career : 'Belum ada';
  $tercapai = $careerPlans->filter(fn ($p) => (int) $p->progress_percentage >= 100)->count();
  $rataRata = $jumlah ? (int) round($careerPlans->avg('progress_percentage')) : 0;
  $nilaiAwal = (int) old('progress_percentage', 0);
  $formTerbuka = $jumlah === 0 || $errors->any();
@endphp

<div class="rk">

  @if(session('success'))
    <div class="alert rk-in"><svg class="ic"><use href="#i-check"/></svg> <span>{{ session('success') }}</span></div>
  @endif
  @if($errors->any())
    <div class="alert err rk-in"><span>Periksa kembali isian formulir: {{ $errors->first() }}</span></div>
  @endif

  <!-- RINGKASAN -->
  <div class="stats">
    <div class="stat rk-in" style="--d:.03s">
      <div class="stat-ico"><svg class="ic"><use href="#i-layers"/></svg></div>
      <div class="stat-body">
        <small>Rencana aktif</small>
        <b>{{ $jumlah }}</b>
        <span class="sub">rencana karier tersimpan</span>
      </div>
    </div>
    <div class="stat ok rk-in" style="--d:.1s">
      <div class="stat-ico"><svg class="ic"><use href="#i-trend"/></svg></div>
      <div class="stat-body">
        <small>Rata-rata progress</small>
        <b>{{ $rataRata }}%</b>
        <span class="sub">{{ $tercapai }} rencana sudah tercapai</span>
      </div>
    </div>
    <div class="stat text rk-in" style="--d:.17s">
      <div class="stat-ico"><svg class="ic"><use href="#i-target"/></svg></div>
      <div class="stat-body">
        <small>Target terbaru</small>
        <b title="{{ $terbaru }}">{{ $terbaru }}</b>
        <span class="sub">rencana yang terakhir dibuat</span>
      </div>
    </div>
  </div>

  <!-- FORM -->
  <div class="head-row rk-in" style="--d:.2s">
    <div>
      <h3>Buat Rencana Baru</h3>
      <p>Isi tujuan, tahapan, dan progress kamu saat ini.</p>
    </div>
    <button type="button" class="btn" id="toggleForm" aria-expanded="{{ $formTerbuka ? 'true' : 'false' }}" aria-controls="formCard">
      <svg class="ic" id="toggleIcon"><use href="{{ $formTerbuka ? '#i-minus' : '#i-plus' }}"/></svg>
      <span id="toggleText">{{ $formTerbuka ? 'Tutup form' : 'Rencana baru' }}</span>
    </button>
  </div>

  <div class="form-card {{ $formTerbuka ? 'open' : '' }}" id="formCard">
    <form action="{{ route('career.store') }}" method="POST">
      @csrf

      <div class="fs">
        <div class="fs-title"><span class="num"><svg class="ic"><use href="#i-target"/></svg></span> Tujuan</div>
        <div class="grid2">
          <div>
            <label for="target_career">Target karier masa depan</label>
            <input id="target_career" type="text" name="target_career" value="{{ old('target_career') }}" placeholder="Contoh: Web Developer / Software Engineer" required>
          </div>
          <div>
            <label for="education_path">Jalur pendidikan</label>
            <input id="education_path" type="text" name="education_path" value="{{ old('education_path') }}" placeholder="Contoh: S1 Informatika / Bootcamp Profesional" required>
          </div>
        </div>
      </div>

      <div class="fs">
        <div class="fs-title"><span class="num"><svg class="ic"><use href="#i-steps"/></svg></span> Tahapan</div>
        <div class="grid3">
          <div>
            <label class="step-label" for="short_term_goals"><span class="dot d1">1</span> Jangka pendek</label>
            <textarea id="short_term_goals" name="short_term_goals" placeholder="Contoh: Menguasai dasar HTML, CSS, dan Algoritma" required>{{ old('short_term_goals') }}</textarea>
          </div>
          <div>
            <label class="step-label" for="medium_term_goals"><span class="dot d2">2</span> Jangka menengah</label>
            <textarea id="medium_term_goals" name="medium_term_goals" placeholder="Contoh: Membuat portofolio project web & ikut magang" required>{{ old('medium_term_goals') }}</textarea>
          </div>
          <div>
            <label class="step-label" for="long_term_goals"><span class="dot d3">3</span> Jangka panjang</label>
            <textarea id="long_term_goals" name="long_term_goals" placeholder="Contoh: Bekerja sebagai Senior Developer di perusahaan teknologi" required>{{ old('long_term_goals') }}</textarea>
          </div>
        </div>
      </div>

      <div class="fs">
        <div class="fs-title"><span class="num"><svg class="ic"><use href="#i-trend"/></svg></span> Progress</div>
        <label for="numProg">Progress saat ini (%)</label>
        <div class="range-row">
          <input type="range" id="rangeProg" min="0" max="100" value="{{ $nilaiAwal }}" aria-label="Geser untuk mengatur progress">
          <input type="number" id="numProg" name="progress_percentage" min="0" max="100" value="{{ $nilaiAwal }}" required>
        </div>
        <div class="range-scale"><span>0%</span><span>50%</span><span>100%</span></div>
      </div>

      <div class="form-actions">
        <span class="form-hint">Semua kolom wajib diisi.</span>
        <button type="button" class="btn btn-ghost" id="cancelForm">Batal</button>
        <button type="submit" class="btn btn-main">
          <svg class="ic"><use href="#i-save"/></svg> Simpan rencana karier
        </button>
      </div>
    </form>
  </div>

  <!-- DAFTAR RENCANA -->
  <div class="head-row rk-in" style="--d:.25s">
    <div>
      <h3>Rencana Karier Aktif</h3>
      <p>Pantau langkahmu dari jangka pendek sampai jangka panjang.</p>
    </div>
  </div>

  @forelse($careerPlans as $cp)
    @php
      $pg = max(0, min(100, (int) $cp->progress_percentage));
      $selesai = $pg >= 100;
    @endphp
    <div class="plan {{ $selesai ? 'done' : '' }} rk-in" style="--d: {{ min($loop->index, 6) * .07 + .3 }}s">
      <div class="plan-head">
        <div class="plan-title">
          <div class="plan-icon">{{ strtoupper(mb_substr($cp->target_career, 0, 1)) }}</div>
          <div>
            <h4>{{ $cp->target_career }}</h4>
            <span class="chip"><svg class="ic"><use href="#i-cap"/></svg> {{ $cp->education_path }}</span>
          </div>
        </div>

        <div class="plan-side">
          @if($selesai)
            <span class="badge done"><svg class="ic"><use href="#i-check"/></svg> Tercapai</span>
          @else
            <span class="badge">Sedang berjalan</span>
          @endif
          <div class="ring" style="--p: {{ $pg }}" role="img" aria-label="Progress {{ $pg }} persen">
            <span>{{ $pg }}%</span>
          </div>
        </div>
      </div>

      <div class="progress" aria-hidden="true"><i style="--w: {{ $pg }}%"></i></div>

      <div class="timeline">
        <div class="tl s1">
          <div class="tl-head"><span class="dot d1">1</span> Jangka pendek</div>
          {{ $cp->short_term_goals }}
        </div>
        <div class="tl s2">
          <div class="tl-head"><span class="dot d2">2</span> Jangka menengah</div>
          {{ $cp->medium_term_goals }}
        </div>
        <div class="tl s3">
          <div class="tl-head"><span class="dot d3">3</span> Jangka panjang</div>
          {{ $cp->long_term_goals }}
        </div>
      </div>

      @if($cp->created_at)
        <div class="plan-date"><svg class="ic sm"><use href="#i-calendar"/></svg> Dibuat {{ $cp->created_at->translatedFormat('d F Y') }}</div>
      @endif
    </div>
  @empty
    <div class="empty rk-in" style="--d:.3s">
      <div class="ico"><svg class="ic lg"><use href="#i-compass"/></svg></div>
      <b>Belum ada rencana karier</b>
      <p>Mulai dari satu target karier, lalu pecah menjadi langkah jangka pendek, menengah, dan panjang.</p>
      <button type="button" class="btn btn-main" id="emptyBtn">
        <svg class="ic"><use href="#i-plus"/></svg> Buat rencana pertamamu
      </button>
    </div>
  @endforelse

</div>

<script>
  (function () {
    var $ = function (id) { return document.getElementById(id); };
    var formCard = $('formCard');
    var toggleBtn = $('toggleForm');

    // Buka / tutup form
    function setForm(open, focus) {
      formCard.classList.toggle('open', open);
      $('toggleText').textContent = open ? 'Tutup form' : 'Rencana baru';
      $('toggleIcon').firstElementChild.setAttribute('href', open ? '#i-minus' : '#i-plus');
      toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (open && focus) {
        formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(function () { var f = $('target_career'); if (f) f.focus({ preventScroll: true }); }, 350);
      }
    }

    toggleBtn.addEventListener('click', function () {
      setForm(!formCard.classList.contains('open'), true);
    });

    var cancelBtn = $('cancelForm');
    if (cancelBtn) cancelBtn.addEventListener('click', function () { setForm(false); toggleBtn.focus(); });

    var emptyBtn = $('emptyBtn');
    if (emptyBtn) emptyBtn.addEventListener('click', function () { setForm(true, true); });

    // Tekan Esc untuk menutup form
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && formCard.classList.contains('open')) setForm(false);
    });

    // Slider dan angka progress saling sinkron
    var range = $('rangeProg'), num = $('numProg');
    function paint(v) { range.style.setProperty('--v', v + '%'); }
    function clamp(v) { v = parseInt(v, 10); return isNaN(v) ? 0 : Math.max(0, Math.min(100, v)); }

    range.addEventListener('input', function () { num.value = range.value; paint(range.value); });
    num.addEventListener('input', function () {
      if (num.value === '') return;
      var v = clamp(num.value);
      range.value = v;
      paint(v);
    });
    num.addEventListener('blur', function () {
      var v = clamp(num.value);
      num.value = v; range.value = v; paint(v);
    });
    paint(clamp(range.value));
  })();
</script>
@endsection