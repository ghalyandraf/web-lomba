<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Profile - LANTERA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f4f8fd; --surface: #ffffff; --border: #dfe7f1;
            --navy: #163a6b; --navy-deep: #2467b3; --navy-darker: #1b4f8f; --sky: #4aa8f0; --sky-soft: #e3effb;
            --text: #1b2b45; --muted: #6b7a90; --danger: #d32f2f; --danger-dark: #b71c1c; --danger-soft: #fdecea;
            --ok: #1e7e4f; --ok-soft: #e6f6ee;
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
        .menu-label { font-size: 11px; font-weight: 600; color: var(--navy); margin: 22px 4px 10px; }
        .menu { list-style: none; display: grid; gap: 6px; }
        .menu a { display: block; padding: 11px 14px; border-radius: 10px; font-size: 13px; color: var(--muted); font-weight: 500; }
        .menu a.active { background: var(--sky-soft); color: var(--navy); font-weight: 700; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; border: 0; cursor: pointer; font-family: inherit; font-weight: 600; border-radius: 8px; transition: filter .15s, background .15s; }
        .btn:hover { filter: brightness(1.08); }
        .btn:focus-visible, .menu a:focus-visible, .btn-upload:focus-within { outline: 2px solid var(--navy-deep); outline-offset: 2px; }
        .btn-primary { padding: 10px 18px; font-size: 12px; background: var(--navy-deep); color: #fff; }
        .btn-outline { padding: 10px 18px; font-size: 12px; background: var(--surface); color: var(--text); border: 1px solid var(--border); }

        /* Tombol kembali (biru) */
        .btn-back { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 11px 14px; border: 0; border-radius: 10px; background: var(--navy-deep); color: #fff; font-family: inherit; font-size: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 6px rgba(36, 103, 179, .25); transition: background .15s, transform .1s; }
        .btn-back:hover { background: var(--navy-darker); }
        .btn-back:active { transform: translateY(1px); }
        .btn-back:focus-visible { outline: 2px solid var(--navy-darker); outline-offset: 2px; }
        .sidebar > .btn-back { margin-top: auto; }   /* nempel di paling bawah sidebar */
        .btn-back-bottom { display: none; margin-top: 22px; }

        /* Main */
        .main { min-width: 0; }
        .topbar { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; padding-bottom: 14px; margin-bottom: 22px; border-bottom: 2px solid var(--navy); }
        .topbar h1 { font-size: 24px; font-weight: 700; color: var(--navy); line-height: 1.2; }
        .topbar p { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .profile { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--sky-soft); color: var(--navy-deep); font-weight: 700; font-size: 14px; display: grid; place-items: center; overflow: hidden; flex-shrink: 0; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile-name { font-size: 12px; font-weight: 700; color: var(--navy); line-height: 1.2; }
        .profile-role { font-size: 10px; color: var(--muted); }

        .section-title { font-size: 17px; font-weight: 700; color: var(--navy); }
        .section-sub { font-size: 12px; color: var(--muted); margin: 2px 0 14px; }

        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; }

        /* Alerts */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 12px; margin-bottom: 16px; }
        .alert-ok { background: var(--ok-soft); color: var(--ok); display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .alert-ok a { font-weight: 700; text-decoration: underline; }
        .alert-err { background: var(--danger-soft); color: var(--danger-dark); }
        .alert-err ul { margin-left: 16px; }

        /* Foto profil */
        .photo-card { padding: 16px 20px 18px; margin-bottom: 18px; box-shadow: 0 2px 6px rgba(22, 58, 107, .08); }
        .photo-card h3 { font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
        .photo-row { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
        .photo-box { width: 90px; height: 90px; border-radius: 4px; background: var(--sky-soft); color: var(--navy-deep); font-weight: 700; font-size: 40px; display: grid; place-items: center; overflow: hidden; flex-shrink: 0; }
        .photo-box img { width: 100%; height: 100%; object-fit: cover; }
        .photo-info h4 { font-size: 16px; font-weight: 700; color: #2c4f7c; margin-bottom: 8px; }
        .btn-upload { display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px; border: 1px solid var(--sky); border-radius: 10px; background: var(--surface); color: var(--navy-deep); font-size: 11px; font-weight: 600; cursor: pointer; transition: background .15s; }
        .btn-upload:hover { background: var(--sky-soft); }
        .btn-upload input { position: absolute; width: 1px; height: 1px; opacity: 0; overflow: hidden; }
        .photo-hint { font-size: 10px; color: var(--muted); margin: 6px 0 0 4px; }
        .photo-remove { display: flex; align-items: center; gap: 6px; font-size: 11px; color: var(--muted); margin: 6px 0 0 4px; cursor: pointer; }

        /* Informasi pribadi */
        .info-card { padding: 28px; }
        .info-card h3 { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 18px; }
        .field { margin-bottom: 18px; }
        .field label { display: block; font-size: 11px; color: var(--muted); }
        .field input, .field select {
            width: 100%; padding: 5px 0 7px; border: 0; border-bottom: 1px solid var(--border);
            background: transparent; font-family: inherit; font-size: 13px; color: var(--text); border-radius: 0;
        }
        .field input:focus, .field select:focus { outline: none; border-bottom-color: var(--navy-deep); box-shadow: 0 1px 0 var(--navy-deep); }
        .field select {
            width: 180px; max-width: 100%; appearance: none; cursor: pointer; padding-right: 22px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7a90' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 2px center;
        }
        .form-foot { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-top: 30px; }
        .form-hint { font-size: 11px; color: var(--sky); }
        .form-actions { display: flex; gap: 10px; }

        @media (max-width: 1024px) {
            .app { grid-template-columns: 1fr; padding: 16px; }
            .sidebar { position: static; height: auto; }
            .sidebar > .btn-back { display: none; }   /* sidebar ada di atas, pakai tombol bawah form */
            .btn-back-bottom { display: flex; }
        }
        @media (max-width: 760px) {
            .topbar { flex-direction: column; }
            .info-card { padding: 20px; }
            .form-foot { flex-direction: column; align-items: stretch; }
            .form-actions { justify-content: flex-end; }
        }
    </style>
</head>
<body>
@php
    $peran   = $peran ?? 'Siswa';
    $inisial = strtoupper(mb_substr($user->name, 0, 1));
    $fotoUrl = $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
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

        <div class="menu-label">Pengaturan akun</div>
        <ul class="menu">
            <li><a href="{{ route('profile.edit') }}" class="active">Edit Profile</a></li>
        </ul>

        {{-- Tombol kembali (paling bawah sidebar, desktop) --}}
        <a href="{{ route('dashboard') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Dashboard
        </a>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h1>Edit Profile Siswa</h1>
                <p>Platform Pendamping Pendidikan</p>
            </div>
            <div class="profile">
                <div class="avatar">
                    @if ($fotoUrl)
                        <img src="{{ $fotoUrl }}" alt="{{ $user->name }}">
                    @else
                        {{ $inisial }}
                    @endif
                </div>
                <div>
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-role">{{ $peran }}</div>
                </div>
            </div>
        </header>

        <h2 class="section-title">Pengaturan akun / Edit Profile</h2>
        <p class="section-sub">Perbarui informasi diri untuk pengalaman belajar yang lebih personal.</p>

        @if (session('success'))
            <div class="alert alert-ok">
                <span>{{ session('success') }}</span>
                <a href="{{ route('dashboard') }}">Kembali ke Dashboard &rarr;</a>
            </div>
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

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Foto profile --}}
            <section class="card photo-card">
                <h3>Foto Profile</h3>
                <div class="photo-row">
                    <div class="photo-box" id="photoPreview">
                        @if ($fotoUrl)
                            <img src="{{ $fotoUrl }}" alt="{{ $user->name }}">
                        @else
                            {{ $inisial }}
                        @endif
                    </div>
                    <div class="photo-info">
                        <h4>Foto Profile Siswa</h4>
                        <label class="btn-upload">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                            Ubah foto mu disini
                            <input type="file" name="photo" id="photoInput" accept="image/png,image/jpeg">
                        </label>
                        <p class="photo-hint" id="photoHint">PNG/JPG &middot; Maks. 2 MB</p>
                        @if ($fotoUrl)
                            <label class="photo-remove">
                                <input type="checkbox" name="remove_photo" value="1"> Hapus foto saat ini
                            </label>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Informasi pribadi --}}
            <section class="card info-card">
                <h3>Informasi pribadi</h3>

                <div class="field">
                    <label for="name">Nama lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="field">
                    <label for="asal_sekolah">Asal sekolah</label>
                    <input type="text" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah', $user->asal_sekolah) }}" placeholder="Contoh: SMAN 1 Jakarta">
                </div>

                <div class="field">
                    <label for="kelas">Kelas</label>
                    <select id="kelas" name="kelas">
                        <option value="">Pilih kelas</option>
                        @foreach ($kelasList as $k)
                            <option value="{{ $k }}" {{ old('kelas', $user->kelas) === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-foot">
                    <span class="form-hint">Pastikan informasi yang kamu masukkan sudah benar.</span>
                    <div class="form-actions">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </section>
        </form>

        {{-- Tombol kembali (layar kecil, di bawah form) --}}
        <a href="{{ route('dashboard') }}" class="btn-back btn-back-bottom">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Dashboard
        </a>
    </main>
</div>

<script>
    // Preview foto sebelum diupload
    document.getElementById('photoInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        document.getElementById('photoHint').textContent = file.name + ' · ' + (file.size / 1024 / 1024).toFixed(2) + ' MB';

        const reader = new FileReader();
        reader.onload = function (ev) {
            document.getElementById('photoPreview').innerHTML = '<img src="' + ev.target.result + '" alt="Preview">';
        };
        reader.readAsDataURL(file);
    });
</script>
</body>
</html>