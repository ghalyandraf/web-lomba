<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LANTERA')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f4f8fd; --surface: #ffffff; --border: #e3ebf5;
            --navy: #163a6b; --navy-deep: #1f5fae; --sky: #5bb5e0; --sky-soft: #e8f3fd;
            --text: #1b2b45; --muted: #6b7a90; --danger: #c0392b; --danger-soft: #fdecea;
            --ok: #1e7e4f; --ok-soft: #e6f6ee; --radius: 14px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); font-size: 14px; line-height: 1.5; }
        a { color: inherit; text-decoration: none; }

        .app { display: grid; grid-template-columns: 240px 1fr; gap: 28px; max-width: 1440px; margin: 0 auto; padding: 24px; min-height: 100vh; }

        /* Sidebar */
        .sidebar { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 20px 16px; display: flex; flex-direction: column; position: sticky; top: 24px; height: calc(100vh - 48px); }
        .brand { display: flex; align-items: center; gap: 12px; padding: 0 4px; }
        .brand-logo { width: 38px; height: 38px; border-radius: 10px; background: var(--navy); flex-shrink: 0; }
        .brand-name { font-size: 18px; font-weight: 700; color: var(--navy); letter-spacing: .02em; line-height: 1.1; }
        .brand-tag { font-size: 8px; color: var(--muted); letter-spacing: .04em; text-transform: uppercase; }
        .menu-label { font-size: 10px; font-weight: 600; color: var(--muted); margin: 26px 4px 10px; letter-spacing: .04em; text-transform: uppercase; }
        .menu { list-style: none; display: grid; gap: 6px; }
        .menu a { display: block; padding: 11px 14px; border-radius: 10px; font-size: 13px; color: var(--muted); font-weight: 500; transition: background .15s, color .15s; }
        .menu a:hover { background: var(--bg); color: var(--navy); }
        .menu a.active { background: var(--sky-soft); color: var(--navy); font-weight: 700; }
        .help { margin-top: auto; background: var(--sky-soft); border-radius: 12px; padding: 16px; }
        .help h4 { font-size: 13px; color: var(--navy); font-weight: 700; margin-bottom: 6px; }
        .help p { font-size: 11px; color: var(--muted); margin-bottom: 14px; }

        /* Buttons & inputs */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; border: 0; cursor: pointer; font-family: inherit; font-weight: 600; border-radius: 8px; transition: filter .15s; }
        .btn:hover { filter: brightness(1.08); }
        .btn:focus-visible, input:focus-visible, select:focus-visible, .menu a:focus-visible, .profile:focus-visible { outline: 2px solid var(--navy-deep); outline-offset: 2px; }
        .btn-block { width: 100%; padding: 9px 12px; font-size: 11px; background: var(--navy-deep); color: #fff; }
        .btn-sky { padding: 7px 14px; font-size: 11px; background: var(--sky); color: var(--navy); }
        .btn-primary { padding: 10px 18px; font-size: 12px; background: var(--navy-deep); color: #fff; }
        .btn-ghost { padding: 6px 10px; font-size: 11px; background: transparent; color: var(--danger); }
        .btn-ghost:hover { background: var(--danger-soft); filter: none; }

        /* Main */
        .main { min-width: 0; padding-top: 4px; }
        .topbar { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap; margin-bottom: 22px; }
        .topbar h1 { font-size: 24px; font-weight: 700; color: var(--navy); line-height: 1.2; }
        .topbar p { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .search input { width: 220px; padding: 10px 14px; border: 1px solid var(--border); border-radius: 10px; background: var(--surface); font-family: inherit; font-size: 12px; color: var(--text); }

        /* Profile (klik untuk edit) */
        .profile { display: flex; align-items: center; gap: 10px; padding: 4px 12px 4px 4px; border-radius: 999px; border: 1px solid transparent; cursor: pointer; user-select: none; transition: background .15s, border-color .15s; }
        .profile:hover, .profile.active { background: var(--surface); border-color: var(--border); }
        .avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--sky-soft); color: var(--navy-deep); font-weight: 700; font-size: 14px; display: grid; place-items: center; overflow: hidden; flex-shrink: 0; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile-name { font-size: 12px; font-weight: 700; color: var(--navy); line-height: 1.2; }
        .profile-role { font-size: 10px; color: var(--muted); }

        .section-title { font-size: 17px; font-weight: 700; color: var(--navy); }
        .section-sub { font-size: 12px; color: var(--muted); margin: 2px 0 12px; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); }
        a.card { display: block; transition: border-color .15s; }
        a.card:hover { border-color: var(--sky); }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 12px; margin-bottom: 16px; }
        .alert-ok { background: var(--ok-soft); color: var(--ok); }
        .alert-err { background: var(--danger-soft); color: var(--danger); }
        .alert-err ul { margin-left: 16px; }

        .footer { font-size: 10px; color: var(--muted); padding: 4px 0 20px; }

        @media (max-width: 1024px) {
            .app { grid-template-columns: 1fr; padding: 16px; }
            .sidebar { position: static; height: auto; }
            .help { margin-top: 24px; }
        }
        @media (max-width: 760px) {
            .search input { width: 100%; }
            .topbar-right { width: 100%; justify-content: space-between; }
            .search { flex: 1; }
        }
        @stack('styles')
    </style>
</head>
<body>
@php
    $authUser = auth()->user();
    $nama  = $nama ?? ($authUser->name ?? 'Siswa');
    $peran = $peran ?? 'Siswa';
    $foto  = $authUser->profile_photo_path ?? null;
@endphp

<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-logo"></div>
            <div>
                <div class="brand-name">LANTERA</div>
                <div class="brand-tag">Terangkan masa depan</div>
            </div>
        </div>

        <div class="menu-label">Menu utama</div>
        <ul class="menu">
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('report-cards.index') }}" class="{{ request()->routeIs('report-cards.*') ? 'active' : '' }}">Nilai Rapor</a></li>
            <li><a href="{{ route('majors.index') }}" class="{{ request()->routeIs('majors.*') ? 'active' : '' }}">Eksplorasi Jurusan</a></li>
            <li><a href="#">Rencana Karier</a></li>
        </ul>

        <div class="help">
            <h4>Butuh arahan?</h4>
            <p>@yield('bantuan', 'Temukan langkah kecil untuk mencapai jurusan impianmu.')</p>
            <a href="#" class="btn btn-block">Pusat Bantuan</a>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h1>@yield('judul')</h1>
                <p>@yield('subjudul')</p>
            </div>
            <div class="topbar-right">
                <form class="search" action="{{ route('majors.index') }}" method="GET">
                    <input type="search" name="q" placeholder="Cari jurusan atau karier..." aria-label="Cari jurusan atau karier">
                </form>

                <a href="{{ route('profile.edit') }}"
                   class="profile {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                   title="Edit profil">
                    <div class="avatar">
                        @if ($foto)
                            <img src="{{ asset('storage/' . $foto) }}" alt="{{ $nama }}">
                        @else
                            {{ strtoupper(mb_substr($nama, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="profile-name">{{ $nama }}</div>
                        <div class="profile-role">{{ $peran }}</div>
                    </div>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost" style="color: var(--muted);">Keluar</button>
                </form>
            </div>
        </header>

        @yield('content')

        <footer class="footer">LANTERA &bull; Terangi langkahmu, raih masa depanmu.</footer>
    </main>
</div>
</body>
</html>