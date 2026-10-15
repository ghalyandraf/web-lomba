<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#163a6b">
    <meta name="description" content="Masuk ke LANTERA dan temukan jurusan kuliah yang sesuai dengan potensimu.">

    <title>Masuk - LANTERA</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-lantera.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-lantera.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --bg: #f4f8fd;
            --surface: #ffffff;
            --border: #e3ebf5;
            --navy: #163a6b;
            --navy-deep: #1f5fae;
            --navy-darker: #17508f;
            --sky: #5bb5e0;
            --sky-soft: #e8f3fd;
            --text: #1b2b45;
            --muted: #6b7a90;
            --danger: #dc4545;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }

        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR */

        .nav {
            height: 76px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, .88);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .nav-inner {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            min-width: 0;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 18px;
            line-height: 1.25;
            color: var(--navy);
            font-weight: 700;
            letter-spacing: .035em;
        }

        .brand-tag {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: .035em;
        }

        .nav-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 15px;
            border: 1px solid var(--border);
            background: white;
            color: var(--navy);
            border-radius: 9px;
            font-size: 12px;
            font-weight: 600;
            transition: .2s ease;
        }

        .nav-back:hover {
            border-color: var(--sky);
            background: var(--sky-soft);
        }

        /* MAIN LAYOUT */

        .main {
            flex: 1;
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 48px 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-layout {
            width: 100%;
            max-width: 1000px;
            display: grid;
            grid-template-columns: 1fr .88fr;
            align-items: stretch;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 22px 65px rgba(22, 58, 107, .09);
        }

        /* BRANDING PANEL */

        .intro {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 590px;
            padding: 46px 40px;
            color: white;
            background: linear-gradient(
                145deg,
                #163a6b 0%,
                #1f5fae 65%,
                #267bb8 100%
            );
        }

        .intro::before {
            content: "";
            position: absolute;
            width: 390px;
            height: 390px;
            top: -150px;
            right: -170px;
            border-radius: 50%;
            background: radial-gradient(
                circle,
                rgba(91, 181, 224, .48),
                transparent 68%
            );
            pointer-events: none;
        }

        .intro::after {
            content: "";
            position: absolute;
            width: 330px;
            height: 330px;
            bottom: -180px;
            left: -120px;
            border-radius: 50%;
            background: radial-gradient(
                circle,
                rgba(91, 181, 224, .25),
                transparent 68%
            );
            pointer-events: none;
        }

        .intro > * {
            position: relative;
            z-index: 1;
        }

        .intro-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .intro-logo-box {
            width: 62px;
            height: 62px;
            padding: 7px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            background: white;
            border: 1px solid rgba(255, 255, 255, .55);
            border-radius: 17px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .12);
        }

        .intro-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .intro-brand-name {
            font-size: 23px;
            line-height: 1.3;
            font-weight: 700;
            letter-spacing: .09em;
        }

        .intro-brand-tag {
            margin-top: 2px;
            font-size: 10px;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .75);
        }

        .intro-content {
            margin: 54px 0;
        }

        .intro-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, .20);
            border-radius: 99px;
            background: rgba(255, 255, 255, .09);
            color: rgba(255, 255, 255, .95);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .025em;
        }

        .intro-badge i {
            color: #a8e2ff;
            font-size: 9px;
        }

        .intro h1 {
            max-width: 410px;
            margin: 23px 0 17px;
            font-size: clamp(29px, 3.4vw, 40px);
            line-height: 1.2;
            letter-spacing: -.045em;
            font-weight: 700;
        }

        .intro h1 span {
            color: #a8e2ff;
        }

        .intro-description {
            max-width: 370px;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
            line-height: 1.9;
        }

        .intro-features {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .intro-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, .92);
            font-size: 12px;
            font-weight: 500;
        }

        .feature-icon {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 10px;
            color: white;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .12);
        }

        .feature-icon i {
            font-size: 13px;
        }

        .intro-footer {
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, .17);
            font-size: 10px;
            color: rgba(255, 255, 255, .65);
        }

        /* LOGIN FORM */

        .form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 38px;
            background: white;
        }

        .form-heading {
            margin-bottom: 30px;
        }

        .form-eyebrow {
            display: inline-block;
            margin-bottom: 11px;
            color: var(--navy-deep);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .form-heading h2 {
            color: var(--navy);
            font-size: 27px;
            font-weight: 700;
            letter-spacing: -.045em;
            line-height: 1.3;
        }

        .form-heading p {
            margin-top: 9px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 13px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 11px;
            line-height: 1.7;
        }

        .alert i {
            margin-top: 3px;
            flex-shrink: 0;
        }

        .alert-error {
            color: #b42323;
            background: #fff1f1;
            border: 1px solid #f7d3d3;
        }

        .alert-success {
            color: #18794e;
            background: #edfbf3;
            border: 1px solid #cceedd;
        }

        .form-fields {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            color: #30435e;
            font-size: 12px;
            font-weight: 600;
        }

        .input-wrap {
            height: 48px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 14px;
            background: #fbfdff;
            border: 1px solid #dfe7f1;
            border-radius: 10px;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .input-wrap:focus-within {
            background: white;
            border-color: var(--navy-deep);
            box-shadow: 0 0 0 3px rgba(31, 95, 174, .08);
        }

        .input-wrap > i {
            flex-shrink: 0;
            color: #91a0b4;
            font-size: 14px;
        }

        .input-wrap input {
            width: 100%;
            height: 100%;
            min-width: 0;
            border: 0;
            outline: none;
            background: transparent;
            color: var(--text);
            font-size: 12px;
        }

        .input-wrap input::placeholder {
            color: #a5b1c1;
        }

        .toggle-password {
            border: 0;
            background: transparent;
            color: #91a0b4;
            cursor: pointer;
            padding: 5px;
            transition: color .2s;
        }

        .toggle-password:hover {
            color: var(--navy-deep);
        }

        .submit-btn {
            width: 100%;
            min-height: 48px;
            margin-top: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 10px;
            color: white;
            background: var(--navy-deep);
            box-shadow: 0 6px 16px rgba(31, 95, 174, .20);
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            transition: background .2s, transform .2s, box-shadow .2s;
        }

        .submit-btn:hover {
            background: var(--navy-darker);
            box-shadow: 0 9px 22px rgba(31, 95, 174, .25);
            transform: translateY(-1px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn i {
            font-size: 11px;
            transition: transform .2s;
        }

        .submit-btn:hover i {
            transform: translateX(3px);
        }

        .register-prompt {
            margin-top: 25px;
            text-align: center;
            color: var(--muted);
            font-size: 11px;
        }

        .register-prompt a {
            margin-left: 3px;
            color: var(--navy-deep);
            font-weight: 700;
        }

        .register-prompt a:hover {
            text-decoration: underline;
        }

        .form-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 27px 0 17px;
            color: #a1adbd;
            font-size: 9px;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .form-divider::before,
        .form-divider::after {
            content: "";
            height: 1px;
            flex: 1;
            background: var(--border);
        }

        .form-note {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            color: #8290a3;
            font-size: 10px;
        }

        .form-note i {
            color: var(--navy-deep);
        }

        /* FOOTER */

        .page-footer {
            padding: 0 24px 24px;
            text-align: center;
            color: #8290a3;
            font-size: 10px;
        }

        .page-footer strong {
            color: var(--navy);
            letter-spacing: .07em;
        }

        /* ANIMATION */

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-layout {
            animation: fadeUp .55s ease both;
        }

        /* RESPONSIVE */

        @media (max-width: 850px) {
            .main {
                padding: 36px 22px;
            }

            .auth-layout {
                max-width: 520px;
                grid-template-columns: 1fr;
            }

            .intro {
                min-height: auto;
                padding: 30px;
            }

            .intro-content {
                margin: 30px 0 25px;
            }

            .intro h1 {
                max-width: 430px;
                font-size: 30px;
                margin: 17px 0 12px;
            }

            .intro-description {
                max-width: 440px;
            }

            .intro-features {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .intro-footer {
                margin-top: 25px;
                padding-top: 16px;
            }

            .form-panel {
                padding: 35px 30px;
            }

            .form-heading {
                margin-bottom: 25px;
            }
        }

        @media (max-width: 480px) {
            .nav {
                height: 68px;
            }

            .nav-inner {
                padding: 0 18px;
            }

            .brand-logo {
                width: 39px;
                height: 39px;
            }

            .brand-name {
                font-size: 16px;
            }

            .brand-tag {
                font-size: 9px;
            }

            .nav-back {
                padding: 8px 11px;
                font-size: 11px;
            }

            .main {
                padding: 22px 15px 30px;
            }

            .auth-layout {
                border-radius: 17px;
            }

            .intro {
                padding: 24px 22px;
            }

            .intro-logo-box {
                width: 51px;
                height: 51px;
                border-radius: 14px;
            }

            .intro-brand-name {
                font-size: 19px;
            }

            .intro-brand-tag {
                font-size: 8px;
            }

            .intro-content {
                margin: 25px 0;
            }

            .intro h1 {
                font-size: 27px;
            }

            .intro-description {
                font-size: 12px;
            }

            .intro-features {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .feature-icon {
                width: 31px;
                height: 31px;
            }

            .form-panel {
                padding: 29px 22px;
            }

            .form-heading h2 {
                font-size: 25px;
            }

            .page-footer {
                padding: 0 16px 20px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
<div class="page">

    
    {{-- MAIN --}}
    <main class="main">

        <div class="auth-layout">

            {{-- PANEL BRANDING --}}
            <aside class="intro">

                <div class="intro-brand">
                    <div class="intro-logo-box">
                        <img
                            src="{{ asset('images/logo-lantera.png') }}"
                            alt="Logo LANTERA"
                            width="60"
                            height="60"
                        >
                    </div>

                    <div>
                        <div class="intro-brand-name">LANTERA</div>
                        <div class="intro-brand-tag">Terangkan masa depan</div>
                    </div>
                </div>

                <div class="intro-content">

                    <div class="intro-badge">
                        <i class="fa-solid fa-sparkles"></i>
                        Platform Pendamping Pejuang SNBT
                    </div>

                    <h1>
                        Terangi langkahmu,
                        <span>pilih jurusan</span> yang tepat.
                    </h1>

                    <p class="intro-description">
                        Kenali potensimu melalui analisis nilai rapor,
                        eksplorasi pilihan jurusan, dan perencanaan karier
                        untuk membantu mempersiapkan masa depanmu.
                    </p>

                </div>

                <div>
                    <div class="intro-features">

                        <div class="intro-feature">
                            <span class="feature-icon">
                                <i class="fa-solid fa-chart-column"></i>
                            </span>
                            <span>Analisis nilai rapor</span>
                        </div>

                        <div class="intro-feature">
                            <span class="feature-icon">
                                <i class="fa-solid fa-compass"></i>
                            </span>
                            <span>Eksplorasi pilihan jurusan</span>
                        </div>

                        <div class="intro-feature">
                            <span class="feature-icon">
                                <i class="fa-solid fa-route"></i>
                            </span>
                            <span>Perencanaan masa depan</span>
                        </div>

                    </div>

                    <div class="intro-footer">
                        Satu langkah kecil hari ini, menuju masa depan yang lebih terang.
                    </div>
                </div>

            </aside>

            {{-- PANEL LOGIN --}}
            <section class="form-panel">

                <div class="form-heading">
                    <span class="form-eyebrow">Selamat datang kembali</span>

                    <h2>Masuk ke akunmu</h2>

                    <p>
                        Masukkan email dan password untuk melanjutkan
                        perjalananmu bersama LANTERA.
                    </p>
                </div>

                {{-- ERROR VALIDATION --}}
                @if ($errors->any())
                    <div class="alert alert-error" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                {{-- SUCCESS MESSAGE --}}
                @if (session('success'))
                    <div class="alert alert-success" role="status">
                        <i class="fa-solid fa-circle-check"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="form-fields">

                        {{-- EMAIL --}}
                        <div class="field">
                            <label for="email">Alamat email</label>

                            <div class="input-wrap">
                                <i class="fa-regular fa-envelope"></i>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    autocomplete="email"
                                    maxlength="255"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="field">
                            <label for="password">Password</label>

                            <div class="input-wrap">
                                <i class="fa-solid fa-lock"></i>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    required
                                >

                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="toggle-password"
                                    aria-label="Tampilkan password"
                                    aria-pressed="false"
                                >
                                    <i id="passwordIcon" class="fa-regular fa-eye"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="submit-btn">
                        <span>Masuk ke akun</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>

                </form>

                <div class="register-prompt">
                    Belum punya akun?
                    <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>

                <div class="form-divider">LANTERA</div>

                <div class="form-note">
                    <i class="fa-solid fa-compass"></i>
                    <span>Mulai langkahmu menuju jurusan impian.</span>
                </div>

            </section>

        </div>

    </main>

    {{-- FOOTER --}}
    <footer class="page-footer">
        <strong>LANTERA</strong>
        &bull; Terangi langkahmu, raih masa depanmu.
        <br>
        &copy; {{ date('Y') }} LANTERA. Semua hak dilindungi.
    </footer>

</div>

<script>
    (function () {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const passwordIcon = document.getElementById('passwordIcon');

        toggleButton.addEventListener('click', function () {
            const showPassword = passwordInput.type === 'password';

            passwordInput.type = showPassword ? 'text' : 'password';

            passwordIcon.classList.toggle('fa-eye', !showPassword);
            passwordIcon.classList.toggle('fa-eye-slash', showPassword);

            toggleButton.setAttribute('aria-pressed', String(showPassword));
            toggleButton.setAttribute(
                'aria-label',
                showPassword ? 'Sembunyikan password' : 'Tampilkan password'
            );
        });
    })();
</script>

</body>
</html>