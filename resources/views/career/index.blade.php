<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LANTERA — Rencana Karier</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg:#f4f8fc; --card:#fff; --line:#e3ebf4;
    --primary:#1e5fae; --primary-soft:#e8f1fb;
    --navy:#14375f; --text:#1c2f45; --muted:#6b7f95; --green:#1f9a6b;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);font-size:13px}

  /* ===== IKON ===== */
  .ic{width:16px;height:16px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
  .ic.lg{width:26px;height:26px}

  /* ===== LAYOUT (sama dengan dashboard & majors) ===== */
  .app{display:flex;gap:28px;padding:24px clamp(12px,3.4vw,64px);min-height:100vh;align-items:flex-start}
  .sidebar{width:240px;flex-shrink:0;background:var(--card);border:1px solid var(--line);border-radius:19px;padding:19px 16px;display:flex;flex-direction:column;position:sticky;top:24px;height:calc(100vh - 48px);min-height:500px}
  .brand{display:flex;align-items:center;gap:11px;margin:0 0 27px;padding-left:4px}
  .brand-logo{width:38px;height:38px;border-radius:10px;background:var(--navy);flex-shrink:0}
  .brand h1{font-size:19px;font-weight:700;color:var(--navy);line-height:1.1;letter-spacing:.01em}
  .brand small{display:block;margin-top:2px;font-size:8px;letter-spacing:.06em;color:var(--muted)}
  .menu-label{font-size:10px;font-weight:600;letter-spacing:.04em;color:var(--muted);margin:0 0 13px 4px}
  .menu a{display:flex;align-items:center;height:42px;padding:0 14px;margin-bottom:6px;border-radius:10px;color:var(--muted);text-decoration:none;font-weight:500;font-size:13px;transition:.15s}
  .menu a:hover{background:#f0f5fc;color:var(--navy)}
  .menu a.active{background:var(--primary-soft);color:var(--navy);font-weight:700}
  .help-box{margin-top:auto;background:var(--primary-soft);border-radius:13px;padding:16px}
  .help-box b{display:block;font-size:13px;color:var(--navy)}
  .help-box p{font-size:11px;color:var(--muted);margin:8px 0 13px;line-height:1.5}
  .help-box .btn{display:flex;align-items:center;justify-content:center;height:34px;padding:0;text-align:center;text-decoration:none;font-size:11px;width:100%}
  .menu-toggle{display:none}
  .content{flex:1;min-width:0}

  /* ===== KOMPONEN UMUM ===== */
  .btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:0;background:var(--primary);color:#fff;font:600 12px 'Inter',sans-serif;padding:11px 18px;border-radius:10px;cursor:pointer;transition:.15s;text-decoration:none}
  .btn:hover{background:#18508f}
  .btn.ghost{background:var(--primary-soft);color:var(--primary)}
  .btn.ghost:hover{background:#d9e8f8}

  .topbar{display:flex;justify-content:space-between;align-items:flex-start;gap:19px;margin-bottom:22px}
  .topbar h2{font-size:26px;font-weight:700;color:var(--navy);line-height:1.2}
  .topbar p{font-size:12px;color:var(--muted);margin-top:5px}
  .top-right{display:flex;align-items:center;gap:14px}
  .user-wrap{display:flex;align-items:center;gap:10px}
  .avatar{width:32px;height:32px;border-radius:50%;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;font-weight:700;font-size:13px}
  .user b{display:block;font-size:11px;color:var(--navy)}
  .user span{font-size:10px;color:var(--muted)}
  .logout{border:0;background:none;font:600 11px 'Inter',sans-serif;color:var(--muted);cursor:pointer;padding:5px 3px}
  .logout:hover{color:var(--navy)}

  .alert{display:flex;align-items:center;gap:9px;background:#eaf7f1;border:1px solid #b9e5d2;color:#176b4b;border-radius:12px;padding:12px 15px;font-size:12px;font-weight:500;margin-bottom:18px}
  .alert.err{background:#fdecec;border-color:#f3c3c3;color:#a13030}

  /* ===== RINGKASAN ===== */
  .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:22px}
  .stat{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px 18px}
  .stat small{display:block;font-size:11px;color:var(--muted)}
  .stat b{display:block;font-size:20px;color:var(--navy);margin:4px 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .stat span{font-size:10px;color:var(--muted)}

  /* ===== JUDUL BAGIAN ===== */
  .head-row{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:14px}
  .head-row h3{font-size:18px;font-weight:700;color:var(--navy)}
  .head-row p{font-size:11px;color:var(--muted);margin-top:3px}

  /* ===== FORM ===== */
  .form-card{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:24px;margin-bottom:26px;display:none}
  .form-card.open{display:block}
  .fs{margin-bottom:22px}
  .fs:last-of-type{margin-bottom:18px}
  .fs-title{display:flex;align-items:center;gap:9px;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid var(--line)}
  .fs-title .ic{color:var(--primary)}
  .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
  .grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
  label{display:block;font-size:11px;font-weight:600;color:var(--navy);margin-bottom:6px}
  input[type=text],input[type=number],textarea{width:100%;border:1px solid var(--line);border-radius:10px;padding:11px 13px;font:400 12px 'Inter',sans-serif;color:var(--text);background:#fff;outline:none;transition:.15s}
  textarea{resize:vertical;min-height:84px;line-height:1.5}
  input:focus,textarea:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(30,95,174,.10)}
  ::placeholder{color:#9aaabb}

  .step-label{display:flex;align-items:center;gap:8px}
  .dot{width:22px;height:22px;border-radius:50%;display:grid;place-items:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0}
  .d1{background:#4aa3e0}.d2{background:#1e5fae}.d3{background:#14375f}

  .range-row{display:flex;align-items:center;gap:16px}
  .range-row input[type=range]{flex:1;accent-color:var(--primary);height:6px}
  .range-row input[type=number]{width:84px;text-align:center;font-weight:700;color:var(--navy)}
  .form-actions{display:flex;gap:10px;align-items:center}

  /* ===== DAFTAR RENCANA ===== */
  .plan{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:22px;margin-bottom:16px;transition:.2s}
  .plan:hover{box-shadow:0 6px 19px rgba(20,55,95,.08)}
  .plan-head{display:flex;justify-content:space-between;align-items:center;gap:14px;margin-bottom:16px}
  .plan-title{display:flex;align-items:center;gap:13px;min-width:0}
  .plan-icon{width:42px;height:42px;border-radius:12px;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;font-size:17px;font-weight:700;flex-shrink:0}
  .plan-title h4{font-size:17px;color:var(--navy);line-height:1.25}
  .chip{display:inline-flex;align-items:center;gap:6px;margin-top:5px;background:#f0f5fc;color:var(--muted);font-size:10px;font-weight:600;padding:5px 10px;border-radius:99px}
  .chip .ic{width:13px;height:13px}
  .badge{display:inline-flex;align-items:center;gap:6px;background:var(--primary-soft);color:var(--primary);font-size:11px;font-weight:700;padding:6px 12px;border-radius:99px;white-space:nowrap}
  .badge.done{background:#e3f6ee;color:var(--green)}
  .badge .ic{width:13px;height:13px;stroke-width:2.6}
  .progress{height:8px;background:var(--primary-soft);border-radius:99px;overflow:hidden;margin-bottom:18px}
  .progress i{display:block;height:100%;background:var(--green);border-radius:99px}

  .timeline{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
  .tl{background:#f7fafd;border:1px solid var(--line);border-radius:12px;padding:14px;font-size:12px;line-height:1.55;color:var(--text)}
  .tl-head{display:flex;align-items:center;gap:8px;font-size:11px;font-weight:700;color:var(--navy);margin-bottom:8px}
  .plan-date{margin-top:14px;font-size:10px;color:var(--muted)}

  /* ===== KOSONG ===== */
  .empty{background:var(--card);border:1px dashed #c9d8ea;border-radius:16px;padding:38px 20px;text-align:center}
  .empty .ico{width:54px;height:54px;border-radius:16px;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;margin:0 auto 14px}
  .empty b{display:block;font-size:15px;color:var(--navy);margin-bottom:6px}
  .empty p{font-size:12px;color:var(--muted);max-width:360px;margin:0 auto 16px;line-height:1.55}

  .footer{margin-top:20px;font-size:10px;color:var(--muted)}

  /* ===== RESPONSIVE ===== */
  @media (max-width:900px){
    .app{flex-direction:column;padding:12px;gap:12px}
    .sidebar{width:100%;height:auto;min-height:0;position:static;padding:16px;border-radius:16px}
    .brand{margin-bottom:0}
    .menu-wrap{display:none;margin-top:16px}
    .menu-wrap.open{display:block}
    .help-box{display:none}
    .menu-toggle{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:12px;width:100%;padding:12px;border:0;border-radius:10px;background:var(--primary-soft);color:var(--navy);font:600 13px 'Inter',sans-serif;cursor:pointer}
    .content{width:100%}
    .grid2,.grid3,.timeline{grid-template-columns:1fr}
  }
  @media (max-width:760px){
    .topbar{flex-direction:column}
    .stats{grid-template-columns:1fr}
    .plan-head{flex-direction:column;align-items:flex-start}
    .head-row{flex-direction:column;align-items:flex-start}
    .form-card{padding:18px}
  }
</style>
</head>
<body>

<!-- ===== KUMPULAN IKON ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="i-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
  <symbol id="i-steps" viewBox="0 0 24 24"><polyline points="3 21 8 21 8 16 13 16 13 11 18 11 18 6 21 6"/></symbol>
  <symbol id="i-trend" viewBox="0 0 24 24"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></symbol>
  <symbol id="i-cap" viewBox="0 0 24 24"><path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></symbol>
  <symbol id="i-compass" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></symbol>
  <symbol id="i-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
  <symbol id="i-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="i-minus" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="i-menu" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></symbol>
</svg>

@php
  $namaUser  = Auth::check() ? Auth::user()->name : 'Dafa';
  $inisial   = strtoupper(mb_substr($namaUser, 0, 1));
  $jumlah    = $careerPlans->count();
  $rataRata  = $jumlah ? round($careerPlans->avg('progress_percentage')) : 0;
  $terbaru   = $jumlah ? $careerPlans->first()->target_career : 'Belum ada';
  $formTerbuka = $jumlah === 0 || $errors->any();
@endphp
<div class="app">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-logo"></div>
      <div><h1>LANTERA</h1><small>TERANGKAN MASA DEPAN</small></div>
    </div>

    <button class="menu-toggle" id="menuToggle"><svg class="ic"><use href="#i-menu"/></svg> Menu</button>

    <div class="menu-wrap" id="menuWrap">
      <div class="menu-label">MENU UTAMA</div>
      <nav class="menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('report-cards.index') }}" class="{{ request()->routeIs('report-cards.*') ? 'active' : '' }}">Nilai Rapor</a>
        <a href="{{ route('majors.index') }}" class="{{ request()->routeIs('majors.*') ? 'active' : '' }}">Eksplorasi Jurusan</a>
        <a href="{{ route('career.index') }}" class="{{ request()->routeIs('career.*') ? 'active' : '' }}">Rencana Karier</a>
      </nav>
    </div>

    <div class="help-box">
      <b>Butuh arahan?</b>
      <p>Temukan langkah kecil untuk mencapai jurusan impianmu.</p>
      <a href="#" class="btn">Pusat Bantuan</a>
    </div>
  </aside>

  <!-- ===== KONTEN ===== -->
  <div class="content">
    <div class="topbar">
      <div>
        <h2>Rencana Karier</h2>
        <p>Susun langkah nyata dari bangku sekolah hingga siap terjun ke dunia profesional.</p>
      </div>
      <div class="top-right">
        <div class="user-wrap">
          <div class="avatar">{{ $inisial }}</div>
          <div class="user"><b>{{ $namaUser }}</b><span>Siswa</span></div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout">Keluar</button>
        </form>
      </div>
    </div>

    @if(session('success'))
      <div class="alert"><svg class="ic"><use href="#i-check"/></svg> {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert err">Periksa kembali isian formulir: {{ $errors->first() }}</div>
    @endif

    <!-- RINGKASAN -->
    <div class="stats">
      <div class="stat">
        <small>Rencana aktif</small>
        <b>{{ $jumlah }}</b>
        <span>rencana karier tersimpan</span>
      </div>
      <div class="stat">
        <small>Target terbaru</small>
        <b title="{{ $terbaru }}">{{ $terbaru }}</b>
        <span>rencana yang terakhir dibuat</span>
      </div>
    </div>

    <!-- FORM -->
    <div class="head-row">
      <div>
        <h3>Buat Rencana Baru</h3>
        <p>Isi tujuan, tahapan, dan progress kamu saat ini.</p>
      </div>
      <button type="button" class="btn ghost" id="toggleForm">
        <svg class="ic" id="toggleIcon"><use href="{{ $formTerbuka ? '#i-minus' : '#i-plus' }}"/></svg>
        <span id="toggleText">{{ $formTerbuka ? 'Tutup form' : 'Rencana baru' }}</span>
      </button>
    </div>

    <div class="form-card {{ $formTerbuka ? 'open' : '' }}" id="formCard">
      <form action="{{ route('career.store') }}" method="POST">
        @csrf

        <div class="fs">
          <div class="fs-title"><svg class="ic"><use href="#i-target"/></svg> Tujuan</div>
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
          <div class="fs-title"><svg class="ic"><use href="#i-steps"/></svg> Tahapan</div>
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

        
        <div class="form-actions">
          <button type="submit" class="btn">Simpan rencana karier</button>
        </div>
      </form>
    </div>

    <!-- DAFTAR RENCANA -->
    <div class="head-row">
      <div>
        <h3>Rencana Karier Aktif</h3>
        <p>Pantau langkahmu dari jangka pendek sampai jangka panjang.</p>
      </div>
    </div>

    @forelse($careerPlans as $cp)
      <div class="plan">
        <div class="plan-head">
          <div class="plan-title">
            <div class="plan-icon">{{ strtoupper(mb_substr($cp->target_career, 0, 1)) }}</div>
            <div>
              <h4>{{ $cp->target_career }}</h4>
              <span class="chip"><svg class="ic"><use href="#i-cap"/></svg> {{ $cp->education_path }}</span>
            </div>
          </div>
          @if($cp->progress_percentage >= 100)
            <span class="badge done"><svg class="ic"><use href="#i-check"/></svg> Tercapai</span>
          @else
            <span class="badge">Progress {{ $cp->progress_percentage }}%</span>
          @endif
        </div>

        <div class="progress"><i style="width: {{ $cp->progress_percentage }}%"></i></div>

        <div class="timeline">
          <div class="tl">
            <div class="tl-head"><span class="dot d1">1</span> Jangka pendek</div>
            {{ $cp->short_term_goals }}
          </div>
          <div class="tl">
            <div class="tl-head"><span class="dot d2">2</span> Jangka menengah</div>
            {{ $cp->medium_term_goals }}
          </div>
          <div class="tl">
            <div class="tl-head"><span class="dot d3">3</span> Jangka panjang</div>
            {{ $cp->long_term_goals }}
          </div>
        </div>

        @if($cp->created_at)
          <div class="plan-date">Dibuat {{ $cp->created_at->translatedFormat('d F Y') }}</div>
        @endif
      </div>
    @empty
      <div class="empty">
        <div class="ico"><svg class="ic lg"><use href="#i-compass"/></svg></div>
        <b>Belum ada rencana karier</b>
        <p>Mulai dari satu target karier, lalu pecah menjadi langkah jangka pendek, menengah, dan panjang.</p>
        <button type="button" class="btn" id="emptyBtn">Buat rencana pertamamu</button>
      </div>
    @endforelse

    <div class="footer">LANTERA &nbsp;•&nbsp; Terangi langkahmu, raih masa depanmu.</div>
  </div>
</div>

<script>
  const $ = id => document.getElementById(id);

  // Menu di HP
  $('menuToggle').addEventListener('click', () => $('menuWrap').classList.toggle('open'));

  // Buka / tutup form
  const formCard = $('formCard');
  function setForm(open){
    formCard.classList.toggle('open', open);
    $('toggleText').textContent = open ? 'Tutup form' : 'Rencana baru';
    $('toggleIcon').firstElementChild.setAttribute('href', open ? '#i-minus' : '#i-plus');
  }
  $('toggleForm').addEventListener('click', () => setForm(!formCard.classList.contains('open')));
  const emptyBtn = $('emptyBtn');
  if(emptyBtn) emptyBtn.addEventListener('click', () => {
    setForm(true);
    formCard.scrollIntoView({behavior:'smooth', block:'start'});
  });

  // Slider dan angka progress saling sinkron
  const range = $('rangeProg'), num = $('numProg');
  range.addEventListener('input', () => num.value = range.value);
  num.addEventListener('input', () => {
    let v = Math.max(0, Math.min(100, parseInt(num.value || 0, 10)));
    range.value = v;
  });
</script>
</body>
</html><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LANTERA — Rencana Karier</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg:#f4f8fc; --card:#fff; --line:#e3ebf4;
    --primary:#1e5fae; --primary-soft:#e8f1fb;
    --navy:#14375f; --text:#1c2f45; --muted:#6b7f95; --green:#1f9a6b;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);font-size:13px}

  /* ===== IKON ===== */
  .ic{width:16px;height:16px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
  .ic.lg{width:26px;height:26px}

  /* ===== LAYOUT ===== */
  .app{display:flex;gap:28px;padding:24px clamp(12px,3.4vw,64px);min-height:100vh;align-items:flex-start}
  .sidebar{width:240px;flex-shrink:0;background:var(--card);border:1px solid var(--line);border-radius:19px;padding:19px 16px;display:flex;flex-direction:column;position:sticky;top:24px;height:calc(100vh - 48px);min-height:500px}
  .brand{display:flex;align-items:center;gap:11px;margin:0 0 27px;padding-left:4px}
  .brand-logo{width:38px;height:38px;border-radius:10px;background:var(--navy);flex-shrink:0}
  .brand h1{font-size:19px;font-weight:700;color:var(--navy);line-height:1.1;letter-spacing:.01em}
  .brand small{display:block;margin-top:2px;font-size:8px;letter-spacing:.06em;color:var(--muted)}
  .menu-label{font-size:10px;font-weight:600;letter-spacing:.04em;color:var(--muted);margin:0 0 13px 4px}
  .menu a{display:flex;align-items:center;height:42px;padding:0 14px;margin-bottom:6px;border-radius:10px;color:var(--muted);text-decoration:none;font-weight:500;font-size:13px;transition:.15s}
  .menu a:hover{background:#f0f5fc;color:var(--navy)}
  .menu a.active{background:var(--primary-soft);color:var(--navy);font-weight:700}
  .help-box{margin-top:auto;background:var(--primary-soft);border-radius:13px;padding:16px}
  .help-box b{display:block;font-size:13px;color:var(--navy)}
  .help-box p{font-size:11px;color:var(--muted);margin:8px 0 13px;line-height:1.5}
  .help-box .btn{display:flex;align-items:center;justify-content:center;height:34px;padding:0;text-align:center;text-decoration:none;font-size:11px;width:100%}
  .menu-toggle{display:none}
  .content{flex:1;min-width:0}

  /* ===== KOMPONEN UMUM ===== */
  .btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;border:0;background:var(--primary);color:#fff;font:600 12px 'Inter',sans-serif;padding:11px 18px;border-radius:10px;cursor:pointer;transition:.15s;text-decoration:none}
  .btn:hover{background:#18508f}
  .btn.ghost{background:var(--primary-soft);color:var(--primary)}
  .btn.ghost:hover{background:#d9e8f8}

  .topbar{display:flex;justify-content:space-between;align-items:flex-start;gap:19px;margin-bottom:22px}
  .topbar h2{font-size:26px;font-weight:700;color:var(--navy);line-height:1.2}
  .topbar p{font-size:12px;color:var(--muted);margin-top:5px}
  .top-right{display:flex;align-items:center;gap:14px}
  .user-wrap{display:flex;align-items:center;gap:10px}
  .avatar{width:32px;height:32px;border-radius:50%;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;font-weight:700;font-size:13px}
  .user b{display:block;font-size:11px;color:var(--navy)}
  .user span{font-size:10px;color:var(--muted)}
  .logout{border:0;background:none;font:600 11px 'Inter',sans-serif;color:var(--muted);cursor:pointer;padding:5px 3px}
  .logout:hover{color:var(--navy)}

  .alert{display:flex;align-items:center;gap:9px;background:#eaf7f1;border:1px solid #b9e5d2;color:#176b4b;border-radius:12px;padding:12px 15px;font-size:12px;font-weight:500;margin-bottom:18px}
  .alert.err{background:#fdecec;border-color:#f3c3c3;color:#a13030}

  /* ===== RINGKASAN ===== */
  .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:22px}
  .stat{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:16px 18px}
  .stat small{display:block;font-size:11px;color:var(--muted)}
  .stat b{display:block;font-size:20px;color:var(--navy);margin:4px 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .stat span{font-size:10px;color:var(--muted)}

  /* ===== JUDUL BAGIAN ===== */
  .head-row{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:14px}
  .head-row h3{font-size:18px;font-weight:700;color:var(--navy)}
  .head-row p{font-size:11px;color:var(--muted);margin-top:3px}

  /* ===== FORM ===== */
  .form-card{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:24px;margin-bottom:26px;display:none}
  .form-card.open{display:block}
  .fs{margin-bottom:22px}
  .fs:last-of-type{margin-bottom:18px}
  .fs-title{display:flex;align-items:center;gap:9px;font-size:13px;font-weight:700;color:var(--navy);margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid var(--line)}
  .fs-title .ic{color:var(--primary)}
  .grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
  .grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
  label{display:block;font-size:11px;font-weight:600;color:var(--navy);margin-bottom:6px}
  input[type=text],input[type=number],textarea{width:100%;border:1px solid var(--line);border-radius:10px;padding:11px 13px;font:400 12px 'Inter',sans-serif;color:var(--text);background:#fff;outline:none;transition:.15s}
  textarea{resize:vertical;min-height:84px;line-height:1.5}
  input:focus,textarea:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(30,95,174,.10)}
  ::placeholder{color:#9aaabb}

  .step-label{display:flex;align-items:center;gap:8px}
  .dot{width:22px;height:22px;border-radius:50%;display:grid;place-items:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0}
  .d1{background:#4aa3e0}.d2{background:#1e5fae}.d3{background:#14375f}

  .range-row{display:flex;align-items:center;gap:16px}
  .range-row input[type=range]{flex:1;accent-color:var(--primary);height:6px}
  .range-row input[type=number]{width:84px;text-align:center;font-weight:700;color:var(--navy)}
  .form-actions{display:flex;gap:10px;align-items:center}

  /* ===== DAFTAR RENCANA ===== */
  .plan{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:22px;margin-bottom:16px;transition:.2s}
  .plan:hover{box-shadow:0 6px 19px rgba(20,55,95,.08)}
  .plan-head{display:flex;justify-content:space-between;align-items:center;gap:14px;margin-bottom:16px}
  .plan-title{display:flex;align-items:center;gap:13px;min-width:0}
  .plan-icon{width:42px;height:42px;border-radius:12px;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;font-size:17px;font-weight:700;flex-shrink:0}
  .plan-title h4{font-size:17px;color:var(--navy);line-height:1.25}
  .chip{display:inline-flex;align-items:center;gap:6px;margin-top:5px;background:#f0f5fc;color:var(--muted);font-size:10px;font-weight:600;padding:5px 10px;border-radius:99px}
  .chip .ic{width:13px;height:13px}
  .badge{display:inline-flex;align-items:center;gap:6px;background:var(--primary-soft);color:var(--primary);font-size:11px;font-weight:700;padding:6px 12px;border-radius:99px;white-space:nowrap}
  .badge.done{background:#e3f6ee;color:var(--green)}
  .badge .ic{width:13px;height:13px;stroke-width:2.6}
  .progress{height:8px;background:var(--primary-soft);border-radius:99px;overflow:hidden;margin-bottom:18px}
  .progress i{display:block;height:100%;background:var(--green);border-radius:99px}

  .timeline{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
  .tl{background:#f7fafd;border:1px solid var(--line);border-radius:12px;padding:14px;font-size:12px;line-height:1.55;color:var(--text)}
  .tl-head{display:flex;align-items:center;gap:8px;font-size:11px;font-weight:700;color:var(--navy);margin-bottom:8px}
  .plan-date{margin-top:14px;font-size:10px;color:var(--muted)}

  /* ===== KOSONG ===== */
  .empty{background:var(--card);border:1px dashed #c9d8ea;border-radius:16px;padding:38px 20px;text-align:center}
  .empty .ico{width:54px;height:54px;border-radius:16px;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;margin:0 auto 14px}
  .empty b{display:block;font-size:15px;color:var(--navy);margin-bottom:6px}
  .empty p{font-size:12px;color:var(--muted);max-width:360px;margin:0 auto 16px;line-height:1.55}

  .footer{margin-top:20px;font-size:10px;color:var(--muted)}

  /* ===== RESPONSIVE ===== */
  @media (max-width:900px){
    .app{flex-direction:column;padding:12px;gap:12px}
    .sidebar{width:100%;height:auto;min-height:0;position:static;padding:16px;border-radius:16px}
    .brand{margin-bottom:0}
    .menu-wrap{display:none;margin-top:16px}
    .menu-wrap.open{display:block}
    .help-box{display:none}
    .menu-toggle{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:12px;width:100%;padding:12px;border:0;border-radius:10px;background:var(--primary-soft);color:var(--navy);font:600 13px 'Inter',sans-serif;cursor:pointer}
    .content{width:100%}
    .grid2,.grid3,.timeline{grid-template-columns:1fr}
  }
  @media (max-width:760px){
    .topbar{flex-direction:column}
    .stats{grid-template-columns:1fr}
    .plan-head{flex-direction:column;align-items:flex-start}
    .head-row{flex-direction:column;align-items:flex-start}
    .form-card{padding:18px}
  }
</style>
</head>
<body>

<!-- ===== KUMPULAN IKON ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="i-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></symbol>
  <symbol id="i-steps" viewBox="0 0 24 24"><polyline points="3 21 8 21 8 16 13 16 13 11 18 11 18 6 21 6"/></symbol>
  <symbol id="i-trend" viewBox="0 0 24 24"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></symbol>
  <symbol id="i-cap" viewBox="0 0 24 24"><path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></symbol>
  <symbol id="i-compass" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></symbol>
  <symbol id="i-check" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></symbol>
  <symbol id="i-plus" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="i-minus" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/></symbol>
  <symbol id="i-menu" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></symbol>
</svg>

@php
  $namaUser  = Auth::check() ? Auth::user()->name : 'Dafa';
  $inisial   = strtoupper(mb_substr($namaUser, 0, 1));
  $jumlah    = $careerPlans->count();
  $rataRata  = $jumlah ? round($careerPlans->avg('progress_percentage')) : 0;
  $terbaru   = $jumlah ? $careerPlans->first()->target_career : 'Belum ada';
  $formTerbuka = $jumlah === 0 || $errors->any();
@endphp
<div class="app">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-logo"></div>
      <div><h1>LANTERA</h1><small>TERANGKAN MASA DEPAN</small></div>
    </div>

    <button class="menu-toggle" id="menuToggle"><svg class="ic"><use href="#i-menu"/></svg> Menu</button>

    <div class="menu-wrap" id="menuWrap">
      <div class="menu-label">MENU UTAMA</div>
      <nav class="menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('report-cards.index') }}" class="{{ request()->routeIs('report-cards.*') ? 'active' : '' }}">Nilai Rapor</a>
        <a href="{{ route('majors.index') }}" class="{{ request()->routeIs('majors.*') ? 'active' : '' }}">Eksplorasi Jurusan</a>
        <a href="{{ route('career.index') }}" class="{{ request()->routeIs('career.*') ? 'active' : '' }}">Rencana Karier</a>
      </nav>
    </div>

    <div class="help-box">
      <b>Butuh arahan?</b>
      <p>Temukan langkah kecil untuk mencapai jurusan impianmu.</p>
      <a href="#" class="btn">Pusat Bantuan</a>
    </div>
  </aside>

  <!-- ===== KONTEN ===== -->
  <div class="content">
    <div class="topbar">
      <div>
        <h2>Rencana Karier</h2>
        <p>Susun langkah nyata dari bangku sekolah hingga siap terjun ke dunia profesional.</p>
      </div>
      <div class="top-right">
        <div class="user-wrap">
          <div class="avatar">{{ $inisial }}</div>
          <div class="user"><b>{{ $namaUser }}</b><span>Siswa</span></div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout">Keluar</button>
        </form>
      </div>
    </div>

    @if(session('success'))
      <div class="alert"><svg class="ic"><use href="#i-check"/></svg> {{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert err">Periksa kembali isian formulir: {{ $errors->first() }}</div>
    @endif

    <!-- RINGKASAN -->
    <div class="stats">
      <div class="stat">
        <small>Rencana aktif</small>
        <b>{{ $jumlah }}</b>
        <span>rencana karier tersimpan</span>
      </div>
      <div class="stat">
        <small>Target terbaru</small>
        <b title="{{ $terbaru }}">{{ $terbaru }}</b>
        <span>rencana yang terakhir dibuat</span>
      </div>
      <div class="stat">
        <small>Rata-rata progress</small>
        <b>{{ $rataRata }}%</b>
        <span>dari semua rencana</span>
      </div>
    </div>

    <!-- FORM -->
    <div class="head-row">
      <div>
        <h3>Buat Rencana Baru</h3>
        <p>Isi tujuan, tahapan, dan progress kamu saat ini.</p>
      </div>
      <button type="button" class="btn ghost" id="toggleForm">
        <svg class="ic" id="toggleIcon"><use href="{{ $formTerbuka ? '#i-minus' : '#i-plus' }}"/></svg>
        <span id="toggleText">{{ $formTerbuka ? 'Tutup form' : 'Rencana baru' }}</span>
      </button>
    </div>

    <div class="form-card {{ $formTerbuka ? 'open' : '' }}" id="formCard">
      <form action="{{ route('career.store') }}" method="POST">
        @csrf

        <div class="fs">
          <div class="fs-title"><svg class="ic"><use href="#i-target"/></svg> Tujuan</div>
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
          <div class="fs-title"><svg class="ic"><use href="#i-steps"/></svg> Tahapan</div>
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
          <div class="fs-title"><svg class="ic"><use href="#i-trend"/></svg> Progress</div>
          <label for="numProg">Progress saat ini (%)</label>
          <div class="range-row">
            <input type="range" id="rangeProg" min="0" max="100" value="{{ old('progress_percentage', 0) }}">
            <input type="number" id="numProg" name="progress_percentage" min="0" max="100" value="{{ old('progress_percentage', 0) }}" required>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn">Simpan rencana karier</button>
        </div>
      </form>
    </div>

    <!-- DAFTAR RENCANA -->
    <div class="head-row">
      <div>
        <h3>Rencana Karier Aktif</h3>
        <p>Pantau langkahmu dari jangka pendek sampai jangka panjang.</p>
      </div>
    </div>

    @forelse($careerPlans as $cp)
      <div class="plan">
        <div class="plan-head">
          <div class="plan-title">
            <div class="plan-icon">{{ strtoupper(mb_substr($cp->target_career, 0, 1)) }}</div>
            <div>
              <h4>{{ $cp->target_career }}</h4>
              <span class="chip"><svg class="ic"><use href="#i-cap"/></svg> {{ $cp->education_path }}</span>
            </div>
          </div>
          @if($cp->progress_percentage >= 100)
            <span class="badge done"><svg class="ic"><use href="#i-check"/></svg> Tercapai</span>
          @else
            <span class="badge">Progress {{ $cp->progress_percentage }}%</span>
          @endif
        </div>

        <div class="progress"><i style="width: {{ $cp->progress_percentage }}%"></i></div>

        <div class="timeline">
          <div class="tl">
            <div class="tl-head"><span class="dot d1">1</span> Jangka pendek</div>
            {{ $cp->short_term_goals }}
          </div>
          <div class="tl">
            <div class="tl-head"><span class="dot d2">2</span> Jangka menengah</div>
            {{ $cp->medium_term_goals }}
          </div>
          <div class="tl">
            <div class="tl-head"><span class="dot d3">3</span> Jangka panjang</div>
            {{ $cp->long_term_goals }}
          </div>
        </div>

        @if($cp->created_at)
          <div class="plan-date">Dibuat {{ $cp->created_at->translatedFormat('d F Y') }}</div>
        @endif
      </div>
    @empty
      <div class="empty">
        <div class="ico"><svg class="ic lg"><use href="#i-compass"/></svg></div>
        <b>Belum ada rencana karier</b>
        <p>Mulai dari satu target karier, lalu pecah menjadi langkah jangka pendek, menengah, dan panjang.</p>
        <button type="button" class="btn" id="emptyBtn">Buat rencana pertamamu</button>
      </div>
    @endforelse

    <div class="footer">LANTERA &nbsp;•&nbsp; Terangi langkahmu, raih masa depanmu.</div>
  </div>
</div>

<script>
  const $ = id => document.getElementById(id);

  // Menu di HP
  $('menuToggle').addEventListener('click', () => $('menuWrap').classList.toggle('open'));

  // Buka / tutup form
  const formCard = $('formCard');
  function setForm(open){
    formCard.classList.toggle('open', open);
    $('toggleText').textContent = open ? 'Tutup form' : 'Rencana baru';
    $('toggleIcon').firstElementChild.setAttribute('href', open ? '#i-minus' : '#i-plus');
  }
  $('toggleForm').addEventListener('click', () => setForm(!formCard.classList.contains('open')));
  const emptyBtn = $('emptyBtn');
  if(emptyBtn) emptyBtn.addEventListener('click', () => {
    setForm(true);
    formCard.scrollIntoView({behavior:'smooth', block:'start'});
  });

  // Slider dan angka progress saling sinkron
  const range = $('rangeProg'), num = $('numProg');
  range.addEventListener('input', () => num.value = range.value);
  num.addEventListener('input', () => {
    let v = Math.max(0, Math.min(100, parseInt(num.value || 0, 10)));
    range.value = v;
  });
</script>
</body>
</html>