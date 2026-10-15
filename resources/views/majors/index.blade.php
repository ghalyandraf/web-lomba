<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>LANTERA — Eksplorasi Jurusan</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
  --bg:#f4f8fc; --card:#fff; --line:#e3ebf4;
  --primary:#1e5fae; --primary-soft:#e8f1fb;
  --navy:#14375f; --text:#1c2f45; --muted:#6b7f95;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);font-size:13px}

.app{display:flex;gap:28px;padding:24px clamp(12px,3.4vw,64px);min-height:100vh;align-items:flex-start}
.sidebar{
  width:240px;flex-shrink:0;background:var(--card);border:1px solid var(--line);
  border-radius:19px;padding:19px 16px;display:flex;flex-direction:column;
  position:sticky;top:24px;height:calc(100vh - 48px);min-height:500px;
}
.brand{display:flex;align-items:center;gap:11px;margin:0 0 27px;padding-left:4px}
.brand-logo{width:38px;height:38px;border-radius:10px;background:var(--navy);flex-shrink:0}
.brand h1{font-size:19px;font-weight:700;color:var(--navy);line-height:1.1;letter-spacing:.01em}
.brand small{display:block;margin-top:2px;font-size:8px;letter-spacing:.06em;color:var(--muted)}
.menu-label{font-size:10px;font-weight:600;letter-spacing:.04em;color:var(--muted);margin:0 0 13px 4px}
.menu a{
  display:flex;align-items:center;height:42px;padding:0 14px;margin-bottom:6px;
  border-radius:10px;color:var(--muted);text-decoration:none;font-weight:500;font-size:13px;transition:.15s;
}
.menu a:hover{background:#f0f5fc;color:var(--navy)}
.menu a.active{background:var(--primary-soft);color:var(--navy);font-weight:700}
.help-box{margin-top:auto;background:var(--primary-soft);border-radius:13px;padding:16px}
.help-box b{display:block;font-size:13px;color:var(--navy)}
.help-box p{font-size:11px;color:var(--muted);margin:8px 0 13px;line-height:1.5}
.help-box .btn{display:flex;align-items:center;justify-content:center;height:34px;padding:0;text-align:center;text-decoration:none;font-size:11px}
.menu-toggle{display:none}
.content{flex:1;min-width:0}

.btn{
  display:block;width:100%;border:0;background:var(--primary);color:#fff;
  font:600 11px 'Inter',sans-serif;padding:10px 13px;border-radius:8px;
  cursor:pointer;transition:.15s;text-align:left;text-decoration:none;
}
.btn:hover{background:#18508f}
.main{background:transparent;border:0;padding:0}
.topbar{display:flex;justify-content:space-between;align-items:flex-start;gap:19px;margin-bottom:22px}
.topbar h2{font-size:26px;font-weight:700;color:var(--navy);line-height:1.2}
.topbar p{font-size:12px;color:var(--muted);margin-top:5px}
.top-right{display:flex;align-items:center;gap:14px}
.search{width:220px;height:35px;border:1px solid var(--line);border-radius:10px;padding:0 14px;font:400 11px 'Inter',sans-serif;color:var(--text);background:#fff;outline:none}
.search:focus{border-color:var(--primary)}
.user-wrap{display:flex;align-items:center;gap:10px}
.avatar{width:32px;height:32px;border-radius:50%;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;font-weight:700;font-size:13px}
.user b{display:block;font-size:11px;color:var(--navy)}
.user span{font-size:10px;color:var(--muted)}
.logout{border:0;background:none;font:600 11px 'Inter',sans-serif;color:var(--muted);cursor:pointer;padding:5px 3px}
.logout:hover{color:var(--navy)}
.label{font-size:10px;font-weight:600;letter-spacing:.06em;color:var(--muted);margin-bottom:8px}
.chips{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px}
.chip{border:1px solid var(--line);background:#fff;color:var(--muted);font:500 11px 'Inter',sans-serif;padding:8px 16px;border-radius:99px;cursor:pointer;transition:.15s}
.chip:hover{border-color:var(--primary);color:var(--primary)}
.chip.active{background:var(--primary);border-color:var(--primary);color:#fff}
.section h3{font-size:18px;font-weight:700;color:var(--navy)}
.section p{font-size:11px;color:var(--muted);margin:3px 0 14px}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(192px,1fr));gap:16px}
.major{background:#fff;border:1px solid var(--line);border-radius:14px;padding:14px;display:flex;flex-direction:column;transition:.2s}
.major:hover{box-shadow:0 6px 19px rgba(20,55,95,.10);transform:translateY(-2px)}
.thumb{height:96px;border-radius:11px;display:grid;place-items:center;font-size:35px;font-weight:700;margin-bottom:13px}
.tag{font-size:9px;font-weight:700;letter-spacing:.06em;color:var(--primary);margin-bottom:6px}
.major h4{font-size:16px;font-weight:700;color:var(--navy);margin-bottom:6px}
.desc{font-size:11px;color:var(--muted);margin-bottom:8px;line-height:1.5}
.skills{font-size:10px;font-weight:500;color:var(--text);margin-bottom:14px}
.major .btn{margin-top:auto}
.empty{grid-column:1/-1;text-align:center;color:var(--muted);font-size:13px;padding:32px 0}
.banner{margin-top:22px;background:var(--navy);border-radius:19px;padding:24px 27px;display:flex;justify-content:space-between;align-items:center;gap:16px;color:#fff}
.banner b{display:block;font-size:16px;margin-bottom:6px}
.banner span{font-size:12px;color:#c4d4e6}
.banner .btn{width:auto;white-space:nowrap;text-align:center}
.footer{margin-top:16px;font-size:10px;color:var(--muted)}

@media(max-width:900px){
  .app{flex-direction:column;padding:12px;gap:12px}
  .sidebar{width:100%;height:auto;min-height:0;position:static;padding:16px;border-radius:16px}
  .brand{margin-bottom:0}
  .menu-wrap{display:none;margin-top:16px}
  .menu-wrap.open{display:block}
  .help-box{display:none}
  .menu-toggle{display:block;margin-top:12px;width:100%;padding:12px;border:0;border-radius:10px;background:var(--primary-soft);color:var(--navy);font:600 13px 'Inter',sans-serif;cursor:pointer}
  .content{width:100%}
}
@media(max-width:760px){
  .topbar{flex-direction:column}
  .top-right{width:100%;flex-wrap:wrap}
  .search{width:100%}
  .banner{flex-direction:column;align-items:flex-start}
}
</style>
</head>

<body>
@php
    $namaUser = Auth::check() ? Auth::user()->name : 'Dafa';
    $inisial = strtoupper(mb_substr($namaUser, 0, 1));

    $majorData = $majors->map(function ($m) {
        $icon = '✦';$bg = '#eaf4fe';
        $color = '#2563b8';

        switch (strtolower(trim($m->name))) {
            case 'akuntansi':
                $icon = '🧮'; $bg = '#e6f4ea'; $color = '#137333'; break;
            case 'arsitektur':
                $icon = '📐'; $bg = '#fce8e6'; $color = '#c5221f'; break;
            case 'bisnis digital':
                $icon = '📈'; $bg = '#e8f0fe'; $color = '#1a73e8'; break;
            case 'desain komunikasi visual':
                $icon = '🎨'; $bg = '#fef7e0'; $color = '#b06000'; break;
            case 'gizi':
                $icon = '🥗'; $bg = '#e6f4ea'; $color = '#0d652d'; break;
            case 'informatika':
                $icon = '💻'; $bg = '#e8f0fe'; $color = '#174ea6'; break;
            case 'kedokteran':
                $icon = '🩺'; $bg = '#fce8e6'; $color = '#a50e0e'; break;
            case 'keperawatan':
                $icon = '🩹'; $bg = '#fce8e6'; $color = '#d93025'; break;
            case 'manajemen':
                $icon = '💼'; $bg = '#f3e8fd'; $color = '#8430ce'; break;
            case 'sistem informasi':
                $icon = '🗄️'; $bg = '#e8f0fe'; $color = '#1967d2'; break;
            default:
                if (stripos($m->field ?? '', 'kesehatan') !== false) {
                    $icon = '🏥'; $bg = '#fce8e6'; $color = '#d93025';
                } elseif (stripos($m->field ?? '', 'teknologi') !== false) {
                    $icon = '⚡'; $bg = '#e8f0fe'; $color = '#1a73e8';
                }
                break;
        }

        return [
            'id' => $m->id,
            'cat' => $m->field ?? 'Lainnya',
            'tag' => strtoupper($m->field ?? 'JURUSAN'),
            'name' => $m->name,
            'icon' => $icon,
            'color' => $color,
            'bg' => $bg,
            'desc' => $m->description ?? 'Deskripsi belum tersedia.',
            'skills' => $m->required_skills ?? [],
        ];
    })->values();
@endphp

<div class="app">
  <aside class="sidebar">
    <div class="brand">
      <div class="brand-logo"></div>
      <div>
        <h1>LANTERA</h1>
        <small>TERANGKAN MASA DEPAN</small>
      </div>
    </div>

    <button class="menu-toggle" id="menuToggle" type="button">☰ Menu</button>

    <div class="menu-wrap" id="menuWrap">
      <div class="menu-label">MENU UTAMA</div>
      <nav class="menu">
        <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard*') ? 'active' : '' }}">Beranda</a>
        <a href="{{ url('/report-cards') }}" class="{{ request()->is('report-cards*') ? 'active' : '' }}">Nilai Rapor</a>
        <a href="{{ url('/majors') }}" class="{{ request()->is('majors*') ? 'active' : '' }}">Eksplorasi Jurusan</a>
        <a href="{{ url('/career-plans') }}" class="{{ request()->is('career-plans*') ? 'active' : '' }}">Rencana Karier</a>
      </nav>
    </div>

    <div class="help-box">
      <b>Butuh arahan?</b>
      <p>Temukan langkah kecil untuk mencapai jurusan impianmu.</p>
      <a href="#" class="btn">Pusat Bantuan</a>
    </div>
  </aside>

  <div class="content">
    <main class="main">
      <div class="topbar">
        <div>
          <h2>Eksplorasi Jurusan</h2>
          <p>Pilih jurusan impianmu. LANTERA akan membantu melihat kesiapan dan langkah pengembangannya.</p>
        </div>

        <div class="top-right">
          <input class="search" id="search" type="search" placeholder="Cari jurusan atau bidang...">
          <div class="user-wrap">
            <div class="avatar">{{ $inisial }}</div>
            <div class="user">
              <b>{{ $namaUser }}</b>
              <span>Siswa</span>
            </div>
          </div>
          <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit" class="logout">Keluar</button>
          </form>
        </div>
      </div>

      <div class="label">BIDANG MINAT</div>
      <div class="chips" id="chips"></div>

      <div class="section">
        <h3 id="sectionTitle">Pilihan populer</h3>
        <p>Pilih satu jurusan untuk melihat detailnya.</p>
      </div>

      <div class="grid" id="grid"></div>

      <div class="banner">
        <div>
          <b>Belum yakin jurusan mana?</b>
          <span>Mulai dari bidang yang menarik perhatianmu. Kamu tidak harus langsung tahu semua jawabannya.</span>
        </div>
        <button class="btn" id="allBtn" type="button">Lihat semua jurusan</button>
      </div>

      <div class="footer">LANTERA &nbsp;•&nbsp; Terangi langkahmu, raih masa depanmu.</div>
    </main>
  </div>
</div>

<script>
  const majors = @json($majorData);

  const categories = [
    'Semua',
    ...new Set(majors.map(m => m.cat).filter(Boolean))
  ];

  const dashboardUrl = @json(url('/dashboard'));

  let activeCat = 'Semua';
  let query = '';

  const chipsEl = document.getElementById('chips');
  const gridEl = document.getElementById('grid');
  const titleEl = document.getElementById('sectionTitle');
  const searchEl = document.getElementById('search');

  function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    })[char]);
  }

  function renderChips() {
    chipsEl.innerHTML = categories.map(category => `
      <button
        type="button"
        class="chip ${category === activeCat ? 'active' : ''}"
        data-cat="${escapeHtml(category)}">
        ${escapeHtml(category)}
      </button>
    `).join('');
  }

  function renderGrid() {
    const keyword = query.trim().toLowerCase();

    const list = majors.filter(major => {
      const skills = Array.isArray(major.skills) ? major.skills : [];

      const searchable = [
        major.name,
        major.desc,
        major.cat,
        ...skills
      ].join(' ').toLowerCase();

      const matchesSearch = !keyword || searchable.includes(keyword);
      const matchesCategory = activeCat === 'Semua' || major.cat === activeCat;

      return matchesSearch && matchesCategory;
    });

    titleEl.textContent = keyword
      ? `Hasil pencarian "${query.trim()}"`
      : activeCat === 'Semua'
        ? 'Pilihan populer'
        : `Jurusan ${activeCat}`;

    if (list.length === 0) {
      gridEl.innerHTML = `
        <div class="empty">
          Jurusan tidak ditemukan. Coba kata kunci atau bidang lain.
        </div>
      `;
      return;
    }

    gridEl.innerHTML = list.map(major => {
      const skills = Array.isArray(major.skills) ? major.skills : [];
      const detailUrl = `${dashboardUrl}?major_id=${encodeURIComponent(major.id)}`;

      return `
        <article class="major">
          <div class="thumb"
               style="background:${escapeHtml(major.bg)};color:${escapeHtml(major.color)}">
            ${escapeHtml(major.icon)}
          </div>

          <div class="tag">${escapeHtml(major.tag)}</div>
          <h4>${escapeHtml(major.name)}</h4>
          <div class="desc">${escapeHtml(major.desc)}</div>
          <div class="skills">${skills.map(escapeHtml).join(' · ')}</div>

          <a class="btn" href="${detailUrl}">
            Lihat kecocokan →
          </a>
        </article>
      `;
    }).join('');
  }

  chipsEl.addEventListener('click', event => {
    const button = event.target.closest('.chip');
    if (!button) return;

    activeCat = button.dataset.cat;
    query = '';
    searchEl.value = '';

    renderChips();
    renderGrid();
  });

  searchEl.addEventListener('input', event => {
    query = event.target.value;
    renderGrid();
  });

  document.getElementById('allBtn').addEventListener('click', () => {
    activeCat = 'Semua';
    query = '';
    searchEl.value = '';

    renderChips();
    renderGrid();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  document.getElementById('menuToggle').addEventListener('click', () => {
    document.getElementById('menuWrap').classList.toggle('open');
  });

  renderChips();
  renderGrid();
</script>
</body>
</html>