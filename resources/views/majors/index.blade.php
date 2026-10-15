@extends('layouts.lantera')

@section('title', 'LANTERA — Eksplorasi Jurusan')

@section('judul', 'Eksplorasi Jurusan')
@section('subjudul', 'Pilih jurusan impianmu. LANTERA akan membantu melihat kesiapan dan langkah pengembangannya.')

@push('styles')
    /* ============ Eksplorasi Jurusan ============ */
    .mx { width: 100%; }
    .mx *, .mx *::before, .mx *::after { box-sizing: border-box; }

    /* ----- Filter kategori ----- */
    .mx-chips { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 26px; }
    .mx-chip {
        display: inline-flex; align-items: center; gap: 8px; flex-shrink: 0;
        min-height: 40px; padding: 8px 14px 8px 16px;
        border: 1px solid var(--border); border-radius: 999px;
        background: var(--surface); color: var(--muted);
        font: 600 13px 'Inter', sans-serif; white-space: nowrap; cursor: pointer;
        transition: background .2s ease, border-color .2s ease, color .2s ease, box-shadow .2s ease;
    }
    .mx-chip:hover { border-color: var(--navy-deep); color: var(--navy); background: var(--sky-soft); }
    .mx-chip:focus-visible { outline: 2px solid var(--navy-deep); outline-offset: 2px; }
    .mx-chip.active { background: var(--navy); border-color: var(--navy); color: #fff; box-shadow: 0 4px 12px rgba(22, 58, 107, .22); }
    .mx-chip-n {
        min-width: 22px; padding: 1px 7px; border-radius: 999px;
        background: var(--bg); color: var(--muted);
        font-size: 11px; font-weight: 700; text-align: center;
    }
    .mx-chip.active .mx-chip-n { background: rgba(255, 255, 255, .2); color: #fff; }

    /* ----- Judul bagian ----- */
    .mx-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; }
    .mx-head h3 { font-size: clamp(18px, 2.6vw, 22px); font-weight: 800; color: var(--navy); line-height: 1.3; overflow-wrap: anywhere; }
    .mx-head p { font-size: 13px; color: var(--muted); margin-top: 2px; }
    .mx-count { padding: 5px 12px; border-radius: 999px; background: var(--sky-soft); color: var(--navy-deep); font-size: 12px; font-weight: 700; white-space: nowrap; }

    /* ----- Grid & kartu ----- */
    .mx-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 240px), 1fr)); gap: 18px; }

    .mx-card {
        --c: var(--navy); --bg: var(--sky-soft);
        display: flex; flex-direction: column; min-width: 0;
        padding: 14px;
        background: var(--surface); border: 1px solid var(--border); border-radius: 18px;
        box-shadow: 0 1px 2px rgba(22, 58, 107, .04);
        transition: transform .25s cubic-bezier(.4, 0, .2, 1), box-shadow .25s ease, border-color .25s ease;
        animation: mx-in .4s ease both;
    }
    @keyframes mx-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
    @media (hover: hover) {
        .mx-card:hover { transform: translateY(-4px); border-color: var(--sky); box-shadow: 0 14px 32px rgba(22, 58, 107, .12); }
        .mx-card:hover .mx-ico { transform: scale(1.08) rotate(-3deg); }
    }

    .mx-thumb {
        position: relative; overflow: hidden; isolation: isolate;
        display: grid; place-items: center;
        height: 112px; margin-bottom: 14px;
        border-radius: 13px; background: var(--bg);
    }
    .mx-thumb::before, .mx-thumb::after { content: ''; position: absolute; z-index: -1; border-radius: 50%; background: var(--c); opacity: .08; }
    .mx-thumb::before { width: 130px; height: 130px; right: -36px; top: -56px; }
    .mx-thumb::after { width: 84px; height: 84px; left: -26px; bottom: -42px; }

    .mx-ico {
        display: grid; place-items: center;
        width: 58px; height: 58px; border-radius: 18px;
        background: #fff; color: var(--c);
        box-shadow: 0 8px 18px rgba(22, 58, 107, .14);
        transition: transform .25s ease;
    }
    .mx-ico svg { width: 28px; height: 28px; }

    .mx-tag {
        align-self: flex-start; margin-bottom: 10px; padding: 4px 10px;
        border-radius: 999px; background: var(--sky-soft); color: var(--navy-deep);
        font-size: 10px; font-weight: 700; letter-spacing: .06em;
    }
    .mx-card h4 { font-size: 17px; font-weight: 700; line-height: 1.3; color: var(--navy); margin-bottom: 6px; overflow-wrap: anywhere; }
    .mx-desc { font-size: 13px; line-height: 1.6; color: var(--muted); margin-bottom: 12px; }
    .mx-skills { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
    .mx-skill { padding: 4px 10px; border: 1px solid var(--border); border-radius: 999px; background: var(--bg); color: var(--text); font-size: 11px; font-weight: 600; }

    .mx-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; min-height: 44px; margin-top: auto; padding: 10px 16px;
        border: 1px solid transparent; border-radius: 12px;
        background: var(--sky-soft); color: var(--navy);
        font: 700 13px 'Inter', sans-serif; cursor: pointer;
        transition: background .2s ease, color .2s ease, transform .15s ease;
    }
    .mx-btn svg { width: 16px; height: 16px; flex-shrink: 0; transition: transform .2s ease; }
    .mx-btn:hover { background: var(--navy); color: #fff; }
    .mx-btn:hover svg { transform: translateX(3px); }
    .mx-btn:active { transform: scale(.98); }
    .mx-btn:disabled { opacity: .7; cursor: progress; }
    .mx-btn:disabled:hover { background: var(--sky-soft); color: var(--navy); }
    .mx-btn:focus-visible { outline: 2px solid var(--navy-deep); outline-offset: 2px; }

    /* ----- Kosong ----- */
    .mx-empty {
        grid-column: 1 / -1;
        display: flex; flex-direction: column; align-items: center; gap: 8px;
        padding: 48px 16px; text-align: center;
        background: var(--surface); border: 1px dashed var(--border); border-radius: 18px;
        color: var(--muted); font-size: 14px;
    }
    .mx-empty svg { width: 40px; height: 40px; color: var(--sky); }
    .mx-empty b { font-size: 16px; color: var(--navy); }

    /* ----- Banner ----- */
    .mx-banner {
        position: relative; overflow: hidden; isolation: isolate;
        display: flex; justify-content: space-between; align-items: center; gap: 20px;
        margin-top: 32px; padding: clamp(20px, 4vw, 32px);
        border-radius: 22px; color: #fff;
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-deep) 100%);
        box-shadow: 0 12px 28px rgba(22, 58, 107, .18);
    }
    .mx-banner::before { content: ''; position: absolute; z-index: -1; width: 280px; height: 280px; right: -60px; top: -120px; border-radius: 50%; background: radial-gradient(circle, rgba(91, 181, 224, .4), transparent 70%); }
    .mx-banner::after { content: ''; position: absolute; z-index: -1; width: 160px; height: 160px; left: 30%; bottom: -90px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 255, 255, .12), transparent 70%); }
    .mx-banner b { display: block; margin-bottom: 6px; font-size: clamp(16px, 2.4vw, 20px); font-weight: 800; }
    .mx-banner span { display: block; max-width: 560px; font-size: 14px; line-height: 1.6; color: rgba(255, 255, 255, .86); }
    .mx-cta {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px; flex-shrink: 0;
        min-height: 46px; padding: 11px 22px;
        border: 0; border-radius: 12px; background: #fff; color: var(--navy);
        font: 700 13px 'Inter', sans-serif; white-space: nowrap; cursor: pointer;
        box-shadow: 0 6px 16px rgba(0, 0, 0, .12);
        transition: background .2s ease, transform .2s ease;
    }
    .mx-cta:hover { background: var(--sky-soft); transform: translateY(-1px); }
    .mx-cta:focus-visible { outline: 2px solid #fff; outline-offset: 3px; }

    /* ----- Responsive ----- */
    @media (max-width: 760px) {
        .mx-chips {
            flex-wrap: nowrap; overflow-x: auto;
            margin-inline: -16px; padding: 2px 16px 8px;
            scroll-snap-type: x proximity; scrollbar-width: none; -webkit-overflow-scrolling: touch;
        }
        .mx-chips::-webkit-scrollbar { display: none; }
        .mx-chip { scroll-snap-align: start; }
        .mx-banner { flex-direction: column; align-items: stretch; }
        .mx-cta { width: 100%; }
    }
    @media (max-width: 480px) {
        .mx-chips { margin-inline: -12px; padding-inline: 12px; }
        .mx-grid { gap: 14px; }
        .mx-thumb { height: 100px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .mx-card { animation: none; }
        .mx-card, .mx-ico, .mx-btn, .mx-btn svg, .mx-chip, .mx-cta { transition: none; }
    }
@endpush

@section('content')
<div class="mx">

    <div class="mx-chips" id="chips" role="group" aria-label="Filter kategori jurusan"></div>

    <div class="mx-head">
        <div>
            <h3 id="sectionTitle">Pilihan populer</h3>
            <p>Pilih satu jurusan untuk melihat detailnya.</p>
        </div>
        <span class="mx-count" id="resultCount" aria-live="polite"></span>
    </div>

    <div class="mx-grid" id="grid"></div>

    <div class="mx-banner">
        <div>
            <b>Belum yakin jurusan mana?</b>
            <span>Mulai dari bidang yang menarik perhatianmu. Kamu tidak harus langsung tahu semua jawabannya.</span>
        </div>
        <button class="mx-cta" id="allBtn" type="button">Lihat semua jurusan</button>
    </div>

</div>

<script>
  const categories = [
    'Semua',
    'Teknologi',
    'Bisnis',
    'Kesehatan',
    'Kreatif',
    'Pendidikan'
  ];

  // Ikon SVG (gaya garis) untuk tiap jurusan
  const ICONS = {
    code: '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
    exchange: '<polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/>',
    pen: '<path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="M2 2l7.6 7.6"/><circle cx="11" cy="11" r="2"/>',
    briefcase: '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
    calculator: '<rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="11" x2="8" y2="11.01"/><line x1="12" y1="11" x2="12" y2="11.01"/><line x1="16" y1="11" x2="16" y2="11.01"/><line x1="8" y1="16" x2="8" y2="16.01"/><line x1="12" y1="16" x2="12" y2="16.01"/><line x1="16" y1="16" x2="16" y2="16.01"/>',
    trending: '<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>',
    pulse: '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
    heart: '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
    leaf: '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
    building: '<path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V11l-6-4"/><line x1="9" y1="9" x2="9" y2="9.01"/><line x1="9" y1="12" x2="9" y2="12.01"/><line x1="9" y1="15" x2="9" y2="15.01"/>',
    film: '<rect x="2" y="2" width="20" height="20" rx="2.2"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/>',
    book: '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
    chat: '<path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5z"/>',
    globe: '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
    search: '<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>'
  };

  const svg = (name, width) =>
    `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="${width || 2}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${ICONS[name]}</svg>`;

  const ARROW = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';

  const majors = [
    {
      cat:'Teknologi',
      tag:'TEKNOLOGI',
      name:'Informatika',
      icon:'code',
      color:'#163a6b',
      bg:'#e3effb',
      desc:'Pemrograman, data, dan pemecahan masalah',
      skills:['Logika','Matematika','Kreativitas']
    },
    {
      cat:'Teknologi',
      tag:'TEKNOLOGI & BISNIS',
      name:'Sistem Informasi',
      icon:'exchange',
      color:'#1f7e4f',
      bg:'#e6f6ee',
      desc:'Menghubungkan teknologi dengan kebutuhan bisnis',
      skills:['Analisis','Komunikasi','Teknologi']
    },
    {
      cat:'Kreatif',
      tag:'KREATIF',
      name:'Desain Komunikasi Visual',
      icon:'pen',
      color:'#b27d12',
      bg:'#fdf8ec',
      desc:'Komunikasi melalui visual dan desain',
      skills:['Kreativitas','Visual','Storytelling']
    },
    {
      cat:'Bisnis',
      tag:'BISNIS',
      name:'Manajemen',
      icon:'briefcase',
      color:'#163a6b',
      bg:'#e3effb',
      desc:'Mengelola organisasi, sumber daya, dan strategi',
      skills:['Kepemimpinan','Analisis','Komunikasi']
    },
    {
      cat:'Bisnis',
      tag:'BISNIS',
      name:'Akuntansi',
      icon:'calculator',
      color:'#1f7e4f',
      bg:'#e6f6ee',
      desc:'Mencatat, menganalisis, dan melaporkan keuangan',
      skills:['Ketelitian','Matematika','Etika']
    },
    {
      cat:'Bisnis',
      tag:'BISNIS & DIGITAL',
      name:'Bisnis Digital',
      icon:'trending',
      color:'#b27d12',
      bg:'#fdf8ec',
      desc:'Membangun usaha berbasis teknologi digital',
      skills:['Inovasi','Pemasaran','Teknologi']
    },
    {
      cat:'Kesehatan',
      tag:'KESEHATAN',
      name:'Kedokteran',
      icon:'pulse',
      color:'#c0392b',
      bg:'#fdecea',
      desc:'Mendiagnosis dan menangani kesehatan manusia',
      skills:['Biologi','Empati','Ketekunan']
    },
    {
      cat:'Kesehatan',
      tag:'KESEHATAN',
      name:'Keperawatan',
      icon:'heart',
      color:'#1f7e4f',
      bg:'#e6f6ee',
      desc:'Merawat dan mendampingi pasien secara langsung',
      skills:['Empati','Kepedulian','Komunikasi']
    },
    {
      cat:'Kesehatan',
      tag:'KESEHATAN',
      name:'Gizi',
      icon:'leaf',
      color:'#b27d12',
      bg:'#fdf8ec',
      desc:'Mengelola pola makan untuk hidup lebih sehat',
      skills:['Biologi','Analisis','Edukasi']
    },
    {
      cat:'Kreatif',
      tag:'KREATIF',
      name:'Arsitektur',
      icon:'building',
      color:'#163a6b',
      bg:'#e3effb',
      desc:'Merancang ruang dan bangunan yang fungsional',
      skills:['Visual','Matematika','Kreativitas']
    },
    {
      cat:'Kreatif',
      tag:'KREATIF',
      name:'Film & Animasi',
      icon:'film',
      color:'#6c3483',
      bg:'#f4ecf7',
      desc:'Menceritakan kisah melalui gambar bergerak',
      skills:['Storytelling','Visual','Kolaborasi']
    },
    {
      cat:'Pendidikan',
      tag:'PENDIDIKAN',
      name:'Pendidikan Guru SD',
      icon:'book',
      color:'#163a6b',
      bg:'#e3effb',
      desc:'Mendidik dan membimbing anak usia sekolah dasar',
      skills:['Sabar','Komunikasi','Kreativitas']
    },
    {
      cat:'Pendidikan',
      tag:'PENDIDIKAN',
      name:'Bimbingan Konseling',
      icon:'chat',
      color:'#1f7e4f',
      bg:'#e6f6ee',
      desc:'Mendampingi perkembangan pribadi dan karier siswa',
      skills:['Empati','Mendengar','Analisis']
    },
    {
      cat:'Pendidikan',
      tag:'PENDIDIKAN',
      name:'Pendidikan Bahasa Inggris',
      icon:'globe',
      color:'#b27d12',
      bg:'#fdf8ec',
      desc:'Mengajarkan bahasa dan budaya global',
      skills:['Bahasa','Komunikasi','Edukasi']
    }
  ];

  const alsoIn = {
    'Desain Komunikasi Visual': ['Teknologi']
  };

  let activeCat = 'Semua';
  let query = '';

  const chipsEl = document.getElementById('chips');
  const gridEl  = document.getElementById('grid');
  const titleEl = document.getElementById('sectionTitle');
  const countEl = document.getElementById('resultCount');
  const searchInput = document.querySelector('input[name="q"]');

  function inCategory(m, cat) {
    return cat === 'Semua' ||
      m.cat === cat ||
      (alsoIn[m.name] || []).includes(cat);
  }

  function countFor(cat) {
    return majors.filter(m => inCategory(m, cat)).length;
  }

  function renderChips() {
    chipsEl.innerHTML = categories.map(c =>
      `<button class="mx-chip ${c === activeCat ? 'active' : ''}"
        data-cat="${c}" type="button" aria-pressed="${c === activeCat}">
        ${c}<span class="mx-chip-n">${countFor(c)}</span>
      </button>`
    ).join('');
  }

  function renderGrid() {
    const q = query.trim().toLowerCase();

    const list = majors.filter(m => {
      if (q) {
        return (
          m.name + ' ' +
          m.desc + ' ' +
          m.skills.join(' ') + ' ' +
          m.cat
        ).toLowerCase().includes(q);
      }

      return inCategory(m, activeCat);
    });

    titleEl.textContent = q
      ? `Hasil pencarian "${query.trim()}"`
      : activeCat === 'Semua'
        ? 'Pilihan populer'
        : `Jurusan ${activeCat}`;

    countEl.textContent = `${list.length} jurusan`;

    gridEl.innerHTML = list.length
      ? list.map((m, i) => `
          <article class="mx-card"
            style="--c:${m.color};--bg:${m.bg};animation-delay:${Math.min(i, 10) * 35}ms">
            <div class="mx-thumb">
              <div class="mx-ico">${svg(m.icon)}</div>
            </div>

            <div class="mx-tag">${m.tag}</div>
            <h4>${m.name}</h4>
            <div class="mx-desc">${m.desc}</div>
            <div class="mx-skills">
              ${m.skills.map(s => `<span class="mx-skill">${s}</span>`).join('')}
            </div>

            <button
              class="mx-btn"
              type="button"
              data-major="${m.name}"
            >
              Lihat kecocokan ${ARROW}
            </button>
          </article>
        `).join('')
      : `<div class="mx-empty">
          ${svg('search', 1.8)}
          <b>Jurusan tidak ditemukan</b>
          <span>Coba kata kunci lain atau pilih kategori di atas.</span>
        </div>`;
  }

  // Memilih kategori jurusan
  chipsEl.addEventListener('click', e => {
    const b = e.target.closest('.mx-chip');

    if (!b) return;

    activeCat = b.dataset.cat;
    query = '';

    if (searchInput) {
      searchInput.value = '';
    }

    renderChips();
    renderGrid();

    const active = chipsEl.querySelector('.mx-chip.active');
    if (active && active.scrollIntoView) {
      active.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });
    }
  });

  // Pencarian jurusan
  if (searchInput) {
    searchInput.addEventListener('input', e => {
      query = e.target.value;
      renderGrid();
    });
  }

  // Menampilkan semua jurusan
  document.getElementById('allBtn').addEventListener('click', () => {
    activeCat = 'Semua';
    query = '';

    if (searchInput) {
      searchInput.value = '';
    }

    renderChips();
    renderGrid();

    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  // PILIH JURUSAN DAN SIMPAN KE DATABASE
  gridEl.addEventListener('click', async function (e) {
    const button = e.target.closest('[data-major]');

    if (!button) return;

    const selectedMajor = button.dataset.major;
    const originalLabel = button.innerHTML;

    button.disabled = true;
    button.textContent = 'Menyimpan...';

    try {
      // Cari jurusan berdasarkan nama di database Laravel
      const response = await fetch(
        `/majors?selected_major=${encodeURIComponent(selectedMajor)}`,
        {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        }
      );

      if (!response.ok) {
        throw new Error('Gagal mencari jurusan.');
      }

      const data = await response.json();

      if (!data.id) {
        throw new Error(
          'Jurusan ini belum tersedia di database. Nama jurusan harus cocok dengan data jurusan Laravel.'
        );
      }

      // Simpan pilihan melalui route Laravel
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/majors/${data.id}/select`;

      const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
      );

      if (!csrfToken) {
        throw new Error('Token keamanan CSRF tidak ditemukan.');
      }

      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = csrfToken.content;

      form.appendChild(csrfInput);
      document.body.appendChild(form);
      form.submit();
    } catch (error) {
      alert(error.message);
      button.disabled = false;
      button.innerHTML = originalLabel;
    }
  });

  // Dukung pencarian dari kolom cari di bar atas (?q=...)
  const urlQuery = new URLSearchParams(window.location.search).get('q');
  if (urlQuery) {
    query = urlQuery;
    if (searchInput) {
      searchInput.value = urlQuery;
    }
  }

  renderChips();
  renderGrid();
</script>
@endsection