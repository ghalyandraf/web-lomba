<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LANTERA')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f4f8fd; --surface: #ffffff; --border: #e3ebf5;
            --navy: #163a6b; --navy-deep: #1f5fae; --sky: #5bb5e0; --sky-soft: #e8f3fd;
            --text: #1b2b45; --muted: #6b7a90; --danger: #d32f2f; --danger-dark: #b71c1c; --danger-soft: #fdecea;
            --ok: #1e7e4f; --ok-soft: #e6f6ee; --radius: 14px;
            --primary: var(--navy-deep); --primary-soft: var(--sky-soft); --line: var(--border);
            --sidebar-w: 248px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-text-size-adjust: 100%; }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.5;
            -webkit-tap-highlight-color: transparent;
        }

        body.nav-open { overflow: hidden; }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; }

        .app {
            display: grid;
            grid-template-columns: var(--sidebar-w) minmax(0, 1fr);
            gap: 28px;
            max-width: 1440px;
            margin: 0 auto;
            padding: 24px;
            min-height: 100vh;
        }

        /* ===== Bar atas khusus HP/tablet ===== */
        .mobile-bar { display: none; }

        .burger {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
            color: var(--navy);
            cursor: pointer;
            transition: background .15s, border-color .15s;
        }

        .burger:hover {
            background: var(--sky-soft);
            border-color: var(--sky);
        }

        .burger svg { width: 22px; height: 22px; }
        .burger .bar {
            transition: transform .25s ease, opacity .2s ease;
            transform-origin: center;
        }

        body.nav-open .burger .bar-1 { transform: translateY(6px) rotate(45deg); }
        body.nav-open .burger .bar-2 { opacity: 0; }
        body.nav-open .burger .bar-3 { transform: translateY(-6px) rotate(-45deg); }

        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            flex: 1;
        }

        .mobile-brand .brand-logo { width: 32px; height: 32px; }
        .mobile-brand .brand-name { font-size: 16px; }

        /* ===== Sidebar ===== */
        .sidebar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 24px;
            height: calc(100vh - 48px);
            overflow-y: auto;
            overscroll-behavior: contain;
        }

        .sidebar-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 4px;
            min-width: 0;
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: .02em;
            line-height: 1.1;
        }

        .brand-tag {
            font-size: 9px;
            color: var(--muted);
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .sidebar-close {
            display: none;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            place-items: center;
            border: 0;
            border-radius: 10px;
            background: var(--bg);
            color: var(--navy);
            cursor: pointer;
        }

        .sidebar-close:hover { background: var(--sky-soft); }
        .sidebar-close svg { width: 20px; height: 20px; }

        .menu-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            margin: 26px 4px 10px;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .menu {
            list-style: none;
            display: grid;
            gap: 6px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 44px;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 14px;
            color: var(--muted);
            font-weight: 500;
            transition: background .15s, color .15s;
        }

        .menu a svg {
            width: 19px;
            height: 19px;
            flex-shrink: 0;
        }

        .menu a:hover {
            background: var(--bg);
            color: var(--navy);
        }

        .menu a.active {
            background: var(--sky-soft);
            color: var(--navy);
            font-weight: 700;
            box-shadow: inset 3px 0 0 var(--navy-deep);
        }

        .menu a.active svg { color: var(--navy-deep); }

        .logout-form {
            margin-top: auto;
            padding-top: 20px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            min-height: 44px;
            padding: 11px 14px;
            border: 0;
            border-radius: 12px;
            background: var(--danger);
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(211, 47, 47, .25);
            transition: background .15s, transform .1s;
        }

        .btn-logout:hover { background: var(--danger-dark); }
        .btn-logout:active { transform: translateY(1px); }
        .btn-logout:focus-visible {
            outline: 2px solid var(--danger-dark);
            outline-offset: 2px;
        }

        .overlay { display: none; }

        /* ===== Buttons & inputs ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: 0;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            border-radius: 8px;
            transition: filter .15s;
        }

        .btn:hover { filter: brightness(1.08); }

        .btn:focus-visible,
        input:focus-visible,
        select:focus-visible,
        .menu a:focus-visible,
        .profile:focus-visible,
        .burger:focus-visible,
        .btn-search:focus-visible,
        .sidebar-close:focus-visible {
            outline: 2px solid var(--navy-deep);
            outline-offset: 2px;
        }

        .btn-block {
            width: 100%;
            padding: 9px 12px;
            font-size: 11px;
            background: var(--navy-deep);
            color: #fff;
        }

        .btn-sky {
            padding: 7px 14px;
            font-size: 11px;
            background: var(--sky);
            color: var(--navy);
        }

        .btn-primary {
            padding: 10px 18px;
            font-size: 12px;
            background: var(--navy-deep);
            color: #fff;
        }

        .btn-ghost {
            padding: 6px 10px;
            font-size: 11px;
            background: transparent;
            color: var(--danger);
        }

        .btn-ghost:hover {
            background: var(--danger-soft);
            filter: none;
        }

        /* ===== Main ===== */
        .main { min-width: 0; padding-top: 4px; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .topbar-text { min-width: 0; }

        .topbar h1 {
            font-size: clamp(20px, 3vw, 26px);
            font-weight: 800;
            color: var(--navy);
            line-height: 1.25;
            overflow-wrap: anywhere;
        }

        .topbar p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Tombol "Cari jurusan" */
        .btn-search {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 10px 18px;
            border-radius: 12px;
            background: var(--navy-deep);
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            box-shadow: 0 6px 16px rgba(31, 95, 174, .25);
            transition: filter .15s, transform .15s, box-shadow .15s;
        }

        .btn-search svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .btn-search:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(31, 95, 174, .32);
        }

        .btn-search:active {
            transform: translateY(0);
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px 4px 4px;
            border-radius: 999px;
            border: 1px solid transparent;
            cursor: pointer;
            user-select: none;
            transition: background .15s, border-color .15s;
        }

        .profile:hover,
        .profile.active {
            background: var(--surface);
            border-color: var(--border);
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--sky-soft);
            color: var(--navy-deep);
            font-weight: 700;
            font-size: 14px;
            display: grid;
            place-items: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.2;
        }

        .profile-role { font-size: 11px; color: var(--muted); }
        .section-title { font-size: 17px; font-weight: 700; color: var(--navy); }
        .section-sub { font-size: 12px; color: var(--muted); margin: 2px 0 12px; }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }

        a.card {
            display: block;
            transition: border-color .15s;
        }

        a.card:hover { border-color: var(--sky); }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 12px;
            margin-bottom: 16px;
        }

        .alert-ok { background: var(--ok-soft); color: var(--ok); }
        .alert-err { background: var(--danger-soft); color: var(--danger); }
        .alert-err ul { margin-left: 16px; }
        .footer { font-size: 11px; color: var(--muted); padding: 24px 0 20px; }

        /* ===== Responsive: tablet & HP ===== */
        @media (max-width: 1024px) {
            .app {
                grid-template-columns: minmax(0, 1fr);
                gap: 0;
                padding: 0 16px 16px;
            }

            .mobile-bar {
                position: sticky;
                top: 0;
                z-index: 40;
                display: flex;
                align-items: center;
                gap: 12px;
                margin: 0 -16px 18px;
                padding: calc(10px + env(safe-area-inset-top)) 16px 10px;
                background: rgba(244, 248, 253, .88);
                -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid var(--border);
            }

            .mobile-bar .avatar { width: 40px; height: 40px; }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 60;
                width: min(300px, 86vw);
                height: 100dvh;
                border-radius: 0 22px 22px 0;
                border-left: 0;
                padding: calc(18px + env(safe-area-inset-top)) 16px calc(18px + env(safe-area-inset-bottom));
                transform: translateX(-105%);
                visibility: hidden;
                transition: transform .3s cubic-bezier(.4, 0, .2, 1), visibility 0s linear .3s;
                box-shadow: none;
            }

            body.nav-open .sidebar {
                transform: translateX(0);
                visibility: visible;
                transition-delay: 0s;
                box-shadow: 0 20px 60px rgba(15, 42, 82, .3);
            }

            .sidebar-close { display: grid; }
            .logout-form { margin-top: 24px; padding-top: 0; }

            .overlay {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 50;
                background: rgba(15, 30, 55, .5);
                -webkit-backdrop-filter: blur(2px);
                backdrop-filter: blur(2px);
                opacity: 0;
                visibility: hidden;
                transition: opacity .3s ease, visibility 0s linear .3s;
            }

            body.nav-open .overlay {
                opacity: 1;
                visibility: visible;
                transition-delay: 0s;
            }

            .topbar-right .profile { display: none; }
            .topbar-right { width: 100%; }
            .btn-search { flex: 1; }
        }

        @media (max-width: 480px) {
            .app { padding: 0 12px 12px; }
            .mobile-bar {
                margin: 0 -12px 16px;
                padding-left: 12px;
                padding-right: 12px;
            }
            .topbar { margin-bottom: 18px; gap: 14px; }
        }

        @media (hover: none) {
            .btn-search:hover { transform: none; }
        }

        @media (prefers-reduced-motion: reduce) {
            .sidebar, .overlay, .burger .bar, .btn-search { transition: none !important; }
        }

        @stack('styles')
    </style>
</head>
<body>
@php
    $authUser = auth()->user();
    $nama = $nama ?? ($authUser->name ?? 'Siswa');
    $peran = $peran ?? 'Siswa';
    $foto = $authUser->profile_photo_path ?? null;
@endphp

<div class="app">

    {{-- Bar atas (hanya tampil di tablet & HP) --}}
    <div class="mobile-bar">
        <button type="button" class="burger" id="navToggle" aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                <line class="bar bar-1" x1="4" y1="6" x2="20" y2="6"/>
                <line class="bar bar-2" x1="4" y1="12" x2="20" y2="12"/>
                <line class="bar bar-3" x1="4" y1="18" x2="20" y2="18"/>
            </svg>
        </button>

        <a href="{{ route('dashboard') }}" class="brand mobile-brand">
            <div class="brand-logo">
                <img src="{{ asset('images/logo-lantera.png') }}" alt="Logo LANTERA">
            </div>
            <div class="brand-name">LANTERA</div>
        </a>

        <a href="{{ route('profile.edit') }}" class="avatar" title="Edit profil" aria-label="Edit profil">
            @if ($foto)
                <img src="{{ asset('storage/' . $foto) }}" alt="{{ $nama }}">
            @else
                {{ strtoupper(mb_substr($nama, 0, 1)) }}
            @endif
        </a>
    </div>

    <div class="overlay" id="navOverlay" aria-hidden="true"></div>

    <aside class="sidebar" id="sidebar" aria-label="Navigasi utama">
        <div class="sidebar-head">
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo-lantera.png') }}" alt="Logo LANTERA">
                </div>
                <div>
                    <div class="brand-name">LANTERA</div>
                    <div class="brand-tag">Terangkan masa depan</div>
                </div>
            </div>

            <button type="button" class="sidebar-close" id="navClose" aria-label="Tutup menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                    <line x1="6" y1="6" x2="18" y2="18"/>
                    <line x1="18" y1="6" x2="6" y2="18"/>
                </svg>
            </button>
        </div>

        <div class="menu-label">Menu utama</div>

        <ul class="menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 10.5L12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>
                    </svg>
                    Beranda
                </a>
            </li>

            <li>
                <a href="{{ route('report-cards.index') }}" class="{{ request()->routeIs('report-cards.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                    Nilai Rapor
                </a>
            </li>

            <li>
                <a href="{{ route('majors.index') }}" class="{{ request()->routeIs('majors.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="M21 21l-4.3-4.3"/>
                    </svg>
                    Eksplorasi Jurusan
                </a>
            </li>

            <li>
                <a href="{{ route('career.index') }}" class="{{ request()->routeIs('career.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    Rencana Karier
                </a>
            </li>

            
        </ul>

        {{-- Tombol keluar (paling bawah sidebar) --}}
        <form class="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <path d="M16 17l5-5-5-5"/>
                    <path d="M21 12H9"/>
                </svg>
                Keluar
            </button>
        </form>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-text">
                <h1>@yield('judul')</h1>
                <p>@yield('subjudul')</p>
            </div>

            <div class="topbar-right">
                <a href="{{ route('majors.index') }}" class="btn-search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="M21 21l-4.3-4.3"/>
                    </svg>
                    Cari jurusan
                </a>

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
            </div>
        </header>

        @yield('content')

        <footer class="footer">LANTERA &bull; Terangi langkahmu, raih masa depanmu.</footer>
    </main>
</div>

<script>
(function () {
    var body = document.body;
    var toggle = document.getElementById('navToggle');
    var closeBtn = document.getElementById('navClose');
    var overlay = document.getElementById('navOverlay');
    var sidebar = document.getElementById('sidebar');
    var desktop = window.matchMedia('(min-width: 1025px)');

    function setOpen(open) {
        body.classList.toggle('nav-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');

        if (open) {
            closeBtn.focus({ preventScroll: true });
        }
    }

    toggle.addEventListener('click', function () {
        setOpen(!body.classList.contains('nav-open'));
    });

    closeBtn.addEventListener('click', function () {
        setOpen(false);
        toggle.focus();
    });

    overlay.addEventListener('click', function () {
        setOpen(false);
    });

    // Tutup saat menu dipilih
    sidebar.querySelectorAll('.menu a').forEach(function (a) {
        a.addEventListener('click', function () {
            setOpen(false);
        });
    });

    // Tutup dengan tombol Esc
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && body.classList.contains('nav-open')) {
            setOpen(false);
            toggle.focus();
        }
    });

    // Reset saat layar membesar ke desktop
    var onChange = function (e) {
        if (e.matches) {
            setOpen(false);
        }
    };

    if (desktop.addEventListener) {
        desktop.addEventListener('change', onChange);
    } else if (desktop.addListener) {
        desktop.addListener(onChange);
    }
})();
</script>
</body>
</html>