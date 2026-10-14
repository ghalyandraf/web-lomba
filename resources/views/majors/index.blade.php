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
  body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);font-size:16px}
  .app{padding:24px;min-height:100vh}

  .btn{display:block;width:100%;border:0;background:var(--primary);color:#fff;font:600 14px 'Inter',sans-serif;padding:13px 16px;border-radius:10px;cursor:pointer;transition:.15s;text-align:left}
  .btn:hover{background:#18508f}

  .main{background:var(--card);border-radius:24px;padding:32px;border:1px solid var(--line)}
  .topbar{display:flex;justify-content:space-between;align-items:flex-start;gap:24px;margin-bottom:24px}
  .topbar h2{font-size:32px;font-weight:700;color:var(--navy)}
  .topbar p{font-size:15px;color:var(--muted);margin-top:6px}
  .top-right{display:flex;align-items:center;gap:14px}
  .search{width:280px;height:44px;border:1px solid var(--line);border-radius:10px;padding:0 14px;font:400 14px 'Inter',sans-serif;color:var(--text);outline:none}
  .search:focus{border-color:var(--primary)}
  .avatar{width:40px;height:40px;border-radius:50%;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;font-weight:700;font-size:16px}
  .user b{display:block;font-size:14px;color:var(--navy)}
  .user span{font-size:12px;color:var(--muted)}
  .user-wrap{display:flex;align-items:center;gap:10px}

  .label{font-size:12px;font-weight:600;letter-spacing:.06em;color:var(--muted);margin-bottom:10px}
  .chips{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:30px}
  .chip{border:1px solid var(--line);background:#fff;color:var(--muted);font:500 14px 'Inter',sans-serif;padding:10px 20px;border-radius:99px;cursor:pointer;transition:.15s}
  .chip:hover{border-color:var(--primary);color:var(--primary)}
  .chip.active{background:var(--primary);border-color:var(--primary);color:#fff}

  .section h3{font-size:22px;font-weight:700;color:var(--navy)}
  .section p{font-size:14px;color:var(--muted);margin:4px 0 18px}

  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px}
  .major{background:#fff;border:1px solid var(--line);border-radius:18px;padding:18px;display:flex;flex-direction:column;transition:.2s}
  .major:hover{box-shadow:0 8px 24px rgba(20,55,95,.10);transform:translateY(-3px)}
  .thumb{height:120px;border-radius:14px;display:grid;place-items:center;font-size:44px;font-weight:700;margin-bottom:16px}
  .tag{font-size:11px;font-weight:700;letter-spacing:.06em;color:var(--primary);margin-bottom:8px}
  .major h4{font-size:20px;font-weight:700;color:var(--navy);margin-bottom:8px}
  .desc{font-size:14px;color:var(--muted);margin-bottom:10px;line-height:1.5}
  .skills{font-size:13px;font-weight:500;color:var(--text);margin-bottom:18px}
  .major .btn{margin-top:auto}
  .empty{grid-column:1/-1;text-align:center;color:var(--muted);font-size:16px;padding:40px 0}

  .banner{margin-top:28px;background:var(--navy);border-radius:16px;padding:26px 32px;display:flex;justify-content:space-between;align-items:center;gap:20px;color:#fff}
  .banner b{display:block;font-size:20px;margin-bottom:8px}
  .banner span{font-size:15px;color:#c4d4e6}
  .banner .btn{width:auto;white-space:nowrap;text-align:center}
  .footer{margin-top:20px;font-size:12px;color:var(--muted)}

  @media (max-width:760px){
    .app{padding:12px}
    .main{padding:20px}
    .topbar{flex-direction:column}
    .search{width:100%}
    .banner{flex-direction:column;align-items:flex-start}
  }
</style>
</head>
<body>
<div class="app">
  <main class="main">
    <div class="topbar">
      <div>
        <h2>Eksplorasi Jurusan</h2>
        <p>Pilih jurusan impianmu. LANTERA akan membantu melihat kesiapan dan langkah pengembangannya.</p>
      </div>
      <div class="top-right">
        <input class="search" id="search" type="search" placeholder="Cari jurusan, atau karier...">
        <div class="user-wrap">
          <div class="avatar">D</div>
          <div class="user"><b>Dafa</b><span>Siswa</span></div>
        </div>
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
      <button class="btn" id="allBtn">Lihat semua jurusan</button>
    </div>
    <div class="footer">LANTERA &nbsp;•&nbsp; Terangi langkahmu, raih masa depanmu.</div>
  </main>
</div>

<script>
  const categories = ['Semua','Teknologi','Bisnis','Kesehatan','Kreatif','Pendidikan'];

  const majors = [
    {cat:'Teknologi', tag:'TEKNOLOGI', name:'Informatika', icon:'&lt;/&gt;', color:'#2563b8', bg:'#eaf4fe',
     desc:'Pemrograman, data, dan pemecahan masalah', skills:['Logika','Matematika','Kreativitas']},
    {cat:'Teknologi', tag:'TEKNOLOGI & BISNIS', name:'Sistem Informasi', icon:'⇄', color:'#1f9a6b', bg:'#eaf3ee',
     desc:'Menghubungkan teknologi dengan kebutuhan bisnis', skills:['Analisis','Komunikasi','Teknologi']},
    {cat:'Kreatif', tag:'KREATIF', name:'Desain Komunikasi Visual', icon:'✦', color:'#f5a623', bg:'#fdf3df',
     desc:'Komunikasi melalui visual dan desain', skills:['Kreativitas','Visual','Storytelling']},

    {cat:'Bisnis', tag:'BISNIS', name:'Manajemen', icon:'◈', color:'#2563b8', bg:'#eaf4fe',
     desc:'Mengelola organisasi, sumber daya, dan strategi', skills:['Kepemimpinan','Analisis','Komunikasi']},
    {cat:'Bisnis', tag:'BISNIS', name:'Akuntansi', icon:'Σ', color:'#1f9a6b', bg:'#eaf3ee',
     desc:'Mencatat, menganalisis, dan melaporkan keuangan', skills:['Ketelitian','Matematika','Etika']},
    {cat:'Bisnis', tag:'BISNIS & DIGITAL', name:'Bisnis Digital', icon:'↗', color:'#f5a623', bg:'#fdf3df',
     desc:'Membangun usaha berbasis teknologi digital', skills:['Inovasi','Pemasaran','Teknologi']},

    {cat:'Kesehatan', tag:'KESEHATAN', name:'Kedokteran', icon:'+', color:'#d64545', bg:'#fdecec',
     desc:'Mendiagnosis dan menangani kesehatan manusia', skills:['Biologi','Empati','Ketekunan']},
    {cat:'Kesehatan', tag:'KESEHATAN', name:'Keperawatan', icon:'♥', color:'#1f9a6b', bg:'#eaf3ee',
     desc:'Merawat dan mendampingi pasien secara langsung', skills:['Empati','Kepedulian','Komunikasi']},
    {cat:'Kesehatan', tag:'KESEHATAN', name:'Gizi', icon:'◐', color:'#f5a623', bg:'#fdf3df',
     desc:'Mengelola pola makan untuk hidup lebih sehat', skills:['Biologi','Analisis','Edukasi']},

    {cat:'Kreatif', tag:'KREATIF', name:'Arsitektur', icon:'△', color:'#2563b8', bg:'#eaf4fe',
     desc:'Merancang ruang dan bangunan yang fungsional', skills:['Visual','Matematika','Kreativitas']},
    {cat:'Kreatif', tag:'KREATIF', name:'Film & Animasi', icon:'▶', color:'#8a4fd0', bg:'#f2ebfb',
     desc:'Menceritakan kisah melalui gambar bergerak', skills:['Storytelling','Visual','Kolaborasi']},

    {cat:'Pendidikan', tag:'PENDIDIKAN', name:'Pendidikan Guru SD', icon:'✎', color:'#2563b8', bg:'#eaf4fe',
     desc:'Mendidik dan membimbing anak usia sekolah dasar', skills:['Sabar','Komunikasi','Kreativitas']},
    {cat:'Pendidikan', tag:'PENDIDIKAN', name:'Bimbingan Konseling', icon:'☺', color:'#1f9a6b', bg:'#eaf3ee',
     desc:'Mendampingi perkembangan pribadi dan karier siswa', skills:['Empati','Mendengar','Analisis']},
    {cat:'Pendidikan', tag:'PENDIDIKAN', name:'Pendidikan Bahasa Inggris', icon:'A', color:'#f5a623', bg:'#fdf3df',
     desc:'Mengajarkan bahasa dan budaya global', skills:['Bahasa','Komunikasi','Edukasi']},
  ];

  // Jurusan yang masuk lebih dari satu bidang (mis. DKV: Teknologi & Kreatif)
  const alsoIn = { 'Desain Komunikasi Visual': ['Teknologi'] };

  let activeCat = 'Semua';
  let query = '';

  const chipsEl = document.getElementById('chips');
  const gridEl  = document.getElementById('grid');
  const titleEl = document.getElementById('sectionTitle');

  function inCategory(m, cat){
    return cat === 'Semua' || m.cat === cat || (alsoIn[m.name] || []).includes(cat);
  }

  function renderChips(){
    chipsEl.innerHTML = categories.map(c =>
      `<button class="chip ${c===activeCat?'active':''}" data-cat="${c}">${c}</button>`).join('');
  }

  function renderGrid(){
    const q = query.trim().toLowerCase();
    const list = majors.filter(m => {
      if(q) return (m.name+' '+m.desc+' '+m.skills.join(' ')+' '+m.cat).toLowerCase().includes(q);
      return inCategory(m, activeCat);
    });

    titleEl.textContent = q ? `Hasil pencarian "${query.trim()}"`
      : activeCat === 'Semua' ? 'Pilihan populer' : `Jurusan ${activeCat}`;

    gridEl.innerHTML = list.length ? list.map(m => `
      <article class="major">
        <div class="thumb" style="background:${m.bg};color:${m.color}">${m.icon}</div>
        <div class="tag">${m.tag}</div>
        <h4>${m.name}</h4>
        <div class="desc">${m.desc}</div>
        <div class="skills">${m.skills.join(' · ')}</div>
        <button class="btn" onclick="alert('Lihat kecocokan: ${m.name}')">Lihat kecocokan →</button>
      </article>`).join('')
      : `<div class="empty">Jurusan tidak ditemukan. Coba kata kunci lain.</div>`;
  }

  chipsEl.addEventListener('click', e => {
    const b = e.target.closest('.chip'); if(!b) return;
    activeCat = b.dataset.cat; query = '';
    document.getElementById('search').value = '';
    renderChips(); renderGrid();
  });
  document.getElementById('search').addEventListener('input', e => {
    query = e.target.value; renderGrid();
  });
  document.getElementById('allBtn').addEventListener('click', () => {
    activeCat = 'Semua'; query = '';
    document.getElementById('search').value = '';
    renderChips(); renderGrid();
    window.scrollTo({top:0, behavior:'smooth'});
  });

  renderChips(); renderGrid();
</script>
</body>
</html>