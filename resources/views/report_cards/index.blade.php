@extends('layouts.lantera')

@section('title', 'Nilai Rapor — LANTERA')
@section('judul', 'Selamat datang, ' . (auth()->user()->name ?? 'Siswa') . '!')
@section('subjudul', 'Yuk, kenali potensimu dan rancang masa depanmu.')
@section('bantuan', 'Satu langkah kecil hari ini bisa mengubah masa depanmu.')

@push('styles')
    /* ============ Dasar ============ */
    .nr { width: 100%; max-width: 1120px; margin: 0 auto; --nr-pad: 28px; }
    .nr *, .nr *::before, .nr *::after { box-sizing: border-box; }
    .nr-card { background: var(--surface); border: 1px solid var(--border); border-radius: 20px; box-shadow: 0 1px 2px rgba(22, 58, 107, .04), 0 10px 30px rgba(22, 58, 107, .06); }

    /* ============ Hero ============ */
    .nr-hero {
        position: relative; overflow: hidden; isolation: isolate;
        display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, 1fr); gap: 24px; align-items: center;
        padding: 30px; margin-bottom: 22px; border-radius: 24px; color: #fff;
        background: linear-gradient(125deg, var(--navy-deep) 0%, var(--navy) 100%);
        box-shadow: 0 18px 40px rgba(22, 58, 107, .22);
    }
    .nr-hero::before, .nr-hero::after { content: ''; position: absolute; border-radius: 50%; z-index: -1; }
    .nr-hero::before { width: 320px; height: 320px; right: -90px; top: -140px; background: radial-gradient(circle, rgba(255, 255, 255, .18), transparent 70%); }
    .nr-hero::after  { width: 240px; height: 240px; left: 30%; bottom: -150px; background: radial-gradient(circle, rgba(120, 190, 255, .28), transparent 70%); }
    .nr-hero-tag { display: inline-flex; align-items: center; gap: 8px; padding: 5px 12px; border-radius: 999px; background: rgba(255, 255, 255, .14); font-size: 11px; font-weight: 700; letter-spacing: .04em; margin-bottom: 14px; }
    .nr-hero-tag svg { width: 14px; height: 14px; }
    .nr-hero h2 { font-size: clamp(22px, 3.4vw, 30px); font-weight: 800; line-height: 1.2; margin-bottom: 8px; }
    .nr-hero p { font-size: 13px; line-height: 1.7; color: rgba(255, 255, 255, .82); max-width: 460px; }
    .nr-hero-stats { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .nr-stat { padding: 14px 16px; border-radius: 16px; background: rgba(255, 255, 255, .12); border: 1px solid rgba(255, 255, 255, .16); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); min-width: 0; }
    .nr-stat.wide { grid-column: 1 / -1; }
    .nr-stat-label { display: block; font-size: 10.5px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: rgba(255, 255, 255, .7); margin-bottom: 4px; }
    .nr-stat-value { font-size: 24px; font-weight: 800; line-height: 1.15; overflow-wrap: anywhere; }
    .nr-stat-value small { font-size: 12px; font-weight: 500; opacity: .75; }
    .nr-stat-value.sm { font-size: 17px; }
    .nr-prog { height: 7px; margin-top: 10px; border-radius: 999px; background: rgba(255, 255, 255, .18); overflow: hidden; }
    .nr-prog > div { width: 0; height: 100%; border-radius: 999px; background: linear-gradient(90deg, #8fd0ff, #fff); transition: width .35s ease; }

    /* ============ Layout ============ */
    .nr-layout { display: grid; grid-template-columns: minmax(0, 1fr) 330px; gap: 22px; align-items: start; }
    .nr-form { padding: var(--nr-pad); }
    .nr-form h3 { font-size: clamp(17px, 2.4vw, 20px); font-weight: 800; color: var(--navy); }
    .nr-form .nr-form-sub { font-size: 13px; color: var(--muted); margin: 2px 0 22px; }

    /* ----- Bagian bernomor ----- */
    .nr-sec { padding-top: 24px; margin-top: 24px; border-top: 1px dashed var(--border); }
    .nr-sec:first-of-type { padding-top: 0; margin-top: 0; border-top: 0; }
    .nr-sec-head { display: flex; align-items: center; gap: 10px; margin: 0 0 6px; }
    .nr-sec-num { display: grid; place-items: center; width: 28px; height: 28px; flex-shrink: 0; border-radius: 10px; background: linear-gradient(135deg, var(--navy-deep), var(--navy)); color: #fff; font-size: 12px; font-weight: 800; box-shadow: 0 4px 10px rgba(31, 95, 174, .3); }
    .nr-sec-head h4 { font-size: 15px; font-weight: 700; color: var(--navy); }
    .nr-hint { font-size: 12px; line-height: 1.6; color: var(--muted); margin: 0 0 14px 38px; }

    /* ----- Field ----- */
    .nr-selects { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin-left: 38px; }
    .nr-field label.lbl { display: block; font-size: 12px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
    .nr-field select, .nr-field input {
        width: 100%; min-height: 46px; padding: 10px 14px;
        border: 1.5px solid var(--border); border-radius: 12px; background: #fff;
        font-family: inherit; font-size: 14px; color: var(--text);
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .nr-field select:hover, .nr-field input:hover { border-color: #c2d2e6; }
    .nr-field select:focus, .nr-field input:focus { outline: none; border-color: var(--navy-deep); box-shadow: 0 0 0 4px rgba(31, 95, 174, .13); }
    .nr-field select {
        appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%236b7a90' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
    }
    .nr-field input::placeholder { color: #9aa7ba; }
    .nr-field input.invalid { border-color: var(--danger); background: var(--danger-soft); }
    .nr-field input.invalid:focus { box-shadow: 0 0 0 4px rgba(211, 47, 47, .14); }
    .nr input[type=number]::-webkit-inner-spin-button, .nr input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    .nr input[type=number] { -moz-appearance: textfield; }

    /* ----- Kelompok mapel ----- */
    .nr-groups { margin-left: 38px; display: grid; gap: 10px; }
    .nr-group { border: 1.5px solid var(--border); border-radius: 16px; background: #fff; transition: border-color .2s ease, box-shadow .2s ease; }
    .nr-group[open] { border-color: #cfe0f3; box-shadow: 0 6px 18px rgba(22, 58, 107, .07); }
    .nr-group summary {
        list-style: none; cursor: pointer; user-select: none;
        display: flex; align-items: center; gap: 12px;
        min-height: 60px; padding: 10px 16px;
        font-size: 14px; font-weight: 700; color: var(--navy); border-radius: 16px;
    }
    .nr-group summary::-webkit-details-marker { display: none; }
    .nr-group summary:hover { background: var(--bg); }
    .nr-group summary:focus-visible { outline: 2px solid var(--navy-deep); outline-offset: 2px; }
    .nr-group summary::after { content: ''; width: 8px; height: 8px; flex-shrink: 0; border-right: 2px solid var(--muted); border-bottom: 2px solid var(--muted); transform: rotate(45deg); transition: transform .2s ease; margin-left: 2px; }
    .nr-group[open] summary::after { transform: rotate(-135deg); }
    .nr-group-ico { display: grid; place-items: center; width: 36px; height: 36px; flex-shrink: 0; border-radius: 11px; background: var(--sky-soft); color: var(--navy-deep); }
    .nr-group-ico svg { width: 19px; height: 19px; }
    .nr-group-name { flex: 1; min-width: 0; line-height: 1.3; }
    .group-count { margin-left: auto; padding: 4px 11px; border-radius: 999px; background: var(--bg); color: var(--muted); font-size: 11px; font-weight: 700; white-space: nowrap; }
    .nr-group.done .group-count { background: var(--ok-soft); color: var(--ok); }
    .nr-group-body { padding: 16px 16px 6px; border-top: 1px solid var(--border); }
    .nr-row { display: grid; grid-template-columns: minmax(0, 1fr) 180px; align-items: center; gap: 16px; margin-bottom: 14px; }
    .nr-row label { font-size: 13px; line-height: 1.4; color: var(--text); }

    .nr-about { margin-left: 38px; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }

    /* ----- Tombol simpan ----- */
    .nr-actions {
        position: sticky; bottom: 0; z-index: 5;
        margin: 30px calc(var(--nr-pad) * -1) calc(var(--nr-pad) * -1);
        padding: 14px var(--nr-pad);
        background: rgba(255, 255, 255, .92); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px);
        border-top: 1px solid var(--border); border-radius: 0 0 19px 19px;
    }
    .nr-submit {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        min-height: 48px; padding: 12px 26px; border: 0; border-radius: 13px;
        background: linear-gradient(135deg, var(--navy-deep), var(--navy)); color: #fff;
        font: 700 14px 'Inter', sans-serif; cursor: pointer;
        box-shadow: 0 8px 18px rgba(31, 95, 174, .3);
        transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
    }
    .nr-submit svg { width: 18px; height: 18px; transition: transform .2s ease; }
    .nr-submit:hover { filter: brightness(1.08); box-shadow: 0 12px 24px rgba(31, 95, 174, .38); }
    .nr-submit:hover svg { transform: translateX(3px); }
    .nr-submit:active { transform: scale(.98); }
    .nr-submit:focus-visible { outline: 3px solid var(--sky); outline-offset: 3px; }

    /* ============ Panel samping ============ */
    .nr-side { display: grid; gap: 16px; position: sticky; top: 24px; }
    .nr-side .nr-card { padding: 20px; }
    .nr-side-head { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
    .nr-side-ico { display: grid; place-items: center; width: 38px; height: 38px; flex-shrink: 0; border-radius: 12px; background: var(--sky-soft); color: var(--navy-deep); }
    .nr-side-ico svg { width: 20px; height: 20px; }
    .nr-side h4 { font-size: 15px; font-weight: 700; color: var(--navy); line-height: 1.3; }
    .nr-side p { font-size: 13px; line-height: 1.7; color: var(--muted); }
    .nr-secure { display: inline-flex; align-items: center; gap: 8px; margin-top: 14px; padding: 6px 12px; border-radius: 999px; background: var(--ok-soft); color: var(--ok); font-size: 12px; font-weight: 700; }
    .nr-secure svg { width: 16px; height: 16px; }
    .nr-tips { list-style: none; display: grid; gap: 12px; margin-top: 4px; padding: 0; }
    .nr-tips li { display: flex; gap: 10px; align-items: flex-start; font-size: 13px; line-height: 1.5; color: var(--text); }
    .nr-tips svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; color: var(--ok); }

    /* Top 3 live */
    .nr-live { border-color: #cfe0f3; background: linear-gradient(180deg, #fff 0%, var(--sky-soft) 220%); }
    .nr-live-badge { margin-left: auto; display: inline-flex; align-items: center; gap: 6px; padding: 3px 9px; border-radius: 999px; background: var(--ok-soft); color: var(--ok); font-size: 10px; font-weight: 800; letter-spacing: .05em; }
    .nr-live-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; animation: nrPulse 1.6s ease-in-out infinite; }
    @keyframes nrPulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: .35; transform: scale(.7); } }
    .nr-mini-list { display: grid; gap: 10px; }
    .nr-mini { display: grid; grid-template-columns: 28px minmax(0, 1fr) 50px; gap: 10px; align-items: center; padding: 10px 12px; border-radius: 14px; background: #fff; border: 1px solid var(--border); }
    .nr-mini-rank { display: grid; place-items: center; width: 28px; height: 28px; border-radius: 9px; background: var(--sky-soft); color: var(--navy); font-size: 12px; font-weight: 800; }
    .nr-mini:first-child .nr-mini-rank { background: var(--navy-deep); color: #fff; }
    .nr-mini-name { font-size: 13px; font-weight: 700; color: var(--navy); line-height: 1.3; overflow-wrap: anywhere; }
    .nr-mini-lab { font-size: 11px; color: var(--muted); }
    .nr-mini .ring { width: 50px; height: 50px; }
    .nr-mini .ring span { font-size: 12px; }
    .nr-live-empty { font-size: 12.5px; line-height: 1.7; color: var(--muted); padding: 6px 2px; }
    .nr-live-link { display: block; margin-top: 12px; text-align: center; font-size: 12px; font-weight: 700; color: var(--navy-deep); text-decoration: none; }
    .nr-live-link:hover { text-decoration: underline; }

    /* ============ Ring persentase ============ */
    .ring { position: relative; width: 64px; height: 64px; flex-shrink: 0; }
    .ring svg { width: 100%; height: 100%; display: block; }
    .ring .bg { fill: none; stroke: var(--border); stroke-width: 6; }
    .ring .fg { fill: none; stroke: var(--lv, var(--navy-deep)); stroke-width: 6; stroke-linecap: round; transition: stroke-dashoffset .6s ease; }
    .ring span {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; font-weight: 800; line-height: 1; color: var(--navy);
        letter-spacing: -.02em;
    }
    .ring span small { font-size: .6em; font-weight: 700; margin-left: 1px; }

    .lv-high { --lv: var(--ok, #1f9d63); }
    .lv-mid  { --lv: #2f80c9; }
    .lv-low  { --lv: #d9a21b; }
    .lv-none { --lv: var(--danger, #d32f2f); }

    /* ============ Hasil rekomendasi ============ */
    .nr-rec { margin-top: 24px; padding: var(--nr-pad); }
    .nr-rec-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 18px; }
    .nr-rec h3 { font-size: clamp(18px, 2.6vw, 22px); font-weight: 800; color: var(--navy); }
    .nr-rec-sub { font-size: 13px; line-height: 1.7; color: var(--muted); margin-top: 4px; max-width: 640px; }

    .nr-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-bottom: 16px; }
    .nr-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
    .nr-tab { display: inline-flex; align-items: center; gap: 7px; padding: 8px 14px; border: 1.5px solid var(--border); border-radius: 999px; background: #fff; color: var(--muted); font: 700 12px inherit; font-family: inherit; cursor: pointer; transition: all .15s ease; }
    .nr-tab b { display: grid; place-items: center; min-width: 20px; height: 20px; padding: 0 6px; border-radius: 999px; background: var(--bg); color: var(--navy); font-size: 11px; }
    .nr-tab:hover { border-color: #c2d2e6; color: var(--navy); }
    .nr-tab.active { background: var(--navy-deep); border-color: var(--navy-deep); color: #fff; }
    .nr-tab.active b { background: rgba(255, 255, 255, .2); color: #fff; }
    .nr-search { position: relative; min-width: 220px; flex: 0 1 260px; }
    .nr-search svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--muted); pointer-events: none; }
    .nr-search input { width: 100%; min-height: 40px; padding: 8px 14px 8px 36px; border: 1.5px solid var(--border); border-radius: 999px; background: #fff; font: 13px inherit; font-family: inherit; color: var(--text); }
    .nr-search input:focus { outline: none; border-color: var(--navy-deep); box-shadow: 0 0 0 4px rgba(31, 95, 174, .12); }

    .nr-empty { text-align: center; padding: 38px 20px; border: 1.5px dashed var(--border); border-radius: 18px; background: var(--bg); color: var(--muted); font-size: 13px; line-height: 1.8; }
    .nr-empty svg { width: 64px; height: 64px; color: var(--navy-deep); opacity: .85; margin-bottom: 10px; }
    .nr-empty strong { display: block; color: var(--navy); font-size: 15px; margin-bottom: 4px; }

    .nr-res-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
    .nr-res { position: relative; display: grid; grid-template-columns: minmax(0, 1fr) 64px; gap: 14px; align-items: start; padding: 18px; border: 1.5px solid var(--border); border-radius: 18px; background: #fff; transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; animation: nrIn .35s ease both; }
    .nr-res:hover { transform: translateY(-2px); border-color: #cfe0f3; box-shadow: 0 12px 26px rgba(22, 58, 107, .1); }
    @keyframes nrIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
    .nr-res-top { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
    .nr-res-rank { display: grid; place-items: center; min-width: 26px; height: 26px; padding: 0 7px; border-radius: 8px; background: var(--sky-soft); color: var(--navy); font-size: 12px; font-weight: 800; }
    .nr-res-lab { display: inline-block; padding: 3px 10px; border-radius: 999px; background: color-mix(in srgb, var(--lv) 14%, #fff); color: var(--lv); font-size: 11px; font-weight: 800; }
    .nr-res-name { font-size: 16px; font-weight: 800; color: var(--navy); line-height: 1.3; overflow-wrap: anywhere; margin-bottom: 4px; }
    .nr-res-meta { font-size: 12px; line-height: 1.6; color: var(--muted); margin-bottom: 12px; }
    .nr-res-bar { height: 7px; border-radius: 999px; background: var(--bg); border: 1px solid var(--border); overflow: hidden; margin-bottom: 12px; }
    .nr-res-bar > div { height: 100%; border-radius: 999px; background: var(--lv); }
    .nr-res .ring { width: 64px; height: 64px; }
    .nr-tagrow { display: flex; flex-wrap: wrap; gap: 6px; }
    .nr-tag { padding: 3px 10px; border-radius: 999px; border: 1px solid var(--border); background: var(--bg); color: var(--muted); font-size: 11px; }
    .nr-tag.hit { background: var(--ok-soft); border-color: transparent; color: var(--ok); font-weight: 800; }

    /* Kartu unggulan (#1) */
    .nr-res.feat { grid-column: 1 / -1; grid-template-columns: 96px minmax(0, 1fr); gap: 22px; align-items: center; padding: 24px; border: 0; color: #fff; background: linear-gradient(125deg, var(--navy-deep), var(--navy)); box-shadow: 0 16px 34px rgba(22, 58, 107, .24); position: relative; overflow: hidden; }
    .nr-res.feat::after { content: ''; position: absolute; width: 260px; height: 260px; right: -80px; top: -120px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 255, 255, .18), transparent 70%); pointer-events: none; }
    .nr-res.feat .ring { grid-column: 1; grid-row: 1; width: 96px; height: 96px; }
    .nr-res.feat .ring .bg { stroke: rgba(255, 255, 255, .22); }
    .nr-res.feat .ring .fg { stroke: #fff; }
    .nr-res.feat .ring span { color: #fff; font-size: 24px; }
    .nr-res.feat .nr-res-main { grid-column: 2; grid-row: 1; position: relative; z-index: 1; }
    .nr-res.feat .nr-res-name { color: #fff; font-size: 21px; }
    .nr-res.feat .nr-res-meta { color: rgba(255, 255, 255, .82); }
    .nr-res.feat .nr-res-rank { background: #f5c451; color: #3a2a00; }
    .nr-res.feat .nr-res-lab { background: rgba(255, 255, 255, .18); color: #fff; }
    .nr-res.feat .nr-res-bar { background: rgba(255, 255, 255, .16); border-color: transparent; }
    .nr-res.feat .nr-res-bar > div { background: #fff; }
    .nr-res.feat .nr-tag { background: rgba(255, 255, 255, .12); border-color: rgba(255, 255, 255, .18); color: rgba(255, 255, 255, .85); }
    .nr-res.feat .nr-tag.hit { background: #fff; color: var(--navy-deep); }

    .nr-more { display: block; margin: 18px auto 0; padding: 11px 22px; border: 1.5px solid var(--border); border-radius: 12px; background: #fff; color: var(--navy); font: 700 13px inherit; font-family: inherit; cursor: pointer; transition: background .15s ease; }
    .nr-more:hover { background: var(--bg); }
    .nr-note { display: flex; gap: 10px; align-items: flex-start; margin-top: 20px; padding: 14px 16px; border-radius: 14px; background: var(--bg); font-size: 12px; line-height: 1.7; color: var(--muted); }
    .nr-note svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; color: var(--navy-deep); }

    /* ============ Responsive ============ */
    @media (max-width: 1000px) {
        .nr-hero { grid-template-columns: minmax(0, 1fr); }
        .nr-layout { grid-template-columns: minmax(0, 1fr); }
        .nr-side { position: static; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .nr-live { grid-column: 1 / -1; }
    }
    @media (max-width: 760px) {
        .nr-selects, .nr-groups, .nr-about, .nr-hint { margin-left: 0; }
        .nr-res-grid { grid-template-columns: minmax(0, 1fr); }
    }
    @media (max-width: 640px) {
        .nr-side { grid-template-columns: minmax(0, 1fr); }
        .nr-res.feat { grid-template-columns: minmax(0, 1fr); text-align: left; }
        .nr-res.feat .ring, .nr-res.feat .nr-res-main { grid-column: 1; grid-row: auto; }
        .nr-search { flex: 1 1 100%; }
    }
    @media (max-width: 560px) {
        .nr { --nr-pad: 18px; }
        .nr-hero { padding: 22px 18px; border-radius: 20px; }
        .nr-stat-value { font-size: 20px; }
        .nr-selects, .nr-about { grid-template-columns: minmax(0, 1fr); }
        .nr-row { grid-template-columns: minmax(0, 1fr); gap: 6px; margin-bottom: 16px; }
        .nr-field select, .nr-field input { font-size: 16px; }
        .nr-group summary { padding: 10px 12px; gap: 10px; }
        .nr-group-body { padding: 14px 12px 4px; }
        .nr-submit { width: 100%; }
    }
    @media (prefers-reduced-motion: reduce) {
        .nr *, .nr *::before, .nr *::after { animation: none !important; transition: none !important; }
    }
@endpush

@section('content')
@php
    $semesterList = ['Semester 1–5', 'Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5'];
    $kelasList    = ['Kelas X', 'Kelas XI', 'Kelas XII'];

    $mapelGrup = [
        'Kelompok umum' => [
            'Pendidikan_Agama'   => 'Pendidikan Agama dan Budi Pekerti',
            'Pendidikan_Pancasila' => 'Pendidikan Pancasila (PPKn)',
            'Bahasa_Indonesia'   => 'Bahasa Indonesia',
            'Matematika'         => 'Matematika',
            'Bahasa_Inggris'     => 'Bahasa Inggris',
            'Sejarah'            => 'Sejarah',
            'PJOK'               => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
            'Seni_Budaya'        => 'Seni dan Budaya',
            'Informatika_TIK'    => 'Informatika',
            'Projek_IPAS'        => 'IPAS (Ilmu Pengetahuan Alam dan Sosial)',
            'Muatan_Lokal'       => 'Muatan Lokal / Bahasa Daerah',
        ],
        'Pilihan IPA (Sains)' => [
            'Fisika'             => 'Fisika',
            'Kimia'              => 'Kimia',
            'Biologi'            => 'Biologi',
            'Matematika_Lanjut'  => 'Matematika Tingkat Lanjut',
        ],
        'Pilihan IPS (Sosial)' => [
            'Ekonomi'            => 'Ekonomi',
            'Sosiologi'          => 'Sosiologi',
            'Geografi'           => 'Geografi',
            'Antropologi'        => 'Antropologi',
            'Sejarah_Lanjut'     => 'Sejarah Tingkat Lanjut',
        ],
        'Pilihan bahasa & budaya' => [
            'Bahasa_Indonesia_Lanjut' => 'Bahasa Indonesia Tingkat Lanjut',
            'Bahasa_Inggris_Lanjut'   => 'Bahasa Inggris Tingkat Lanjut',
            'Bahasa_Arab'        => 'Bahasa Arab',
            'Bahasa_Jerman'      => 'Bahasa Jerman',
            'Bahasa_Jepang'      => 'Bahasa Jepang',
            'Bahasa_Korea'       => 'Bahasa Korea',
            'Bahasa_Mandarin'    => 'Bahasa Mandarin',
            'Bahasa_Prancis'     => 'Bahasa Prancis',
        ],
        'Seni, keterampilan & kejuruan' => [
            'Seni_Musik'         => 'Seni Musik',
            'Seni_Rupa'          => 'Seni Rupa',
            'Seni_Teater'        => 'Seni Teater',
            'Seni_Tari'          => 'Seni Tari',
            'Prakarya_Kewirausahaan' => 'Prakarya dan Kewirausahaan',
            'Mapel_Kejuruan'     => 'Mata pelajaran kejuruan (SMK)',
        ],
    ];

    $ikonGrup = [
        '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
        '<path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/><path d="M8.5 2h7"/><path d="M7 16h10"/>',
        '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
        '<circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>',
    ];

    $kartuTerakhir = $reportCards->first();
    $skorTerakhir = $kartuTerakhir
        ? (is_array($kartuTerakhir->scores) ? $kartuTerakhir->scores : (json_decode($kartuTerakhir->scores, true) ?? []))
        : [];

    [$semPilih, $kelPilih] = array_pad(explode(' - ', old('semester', $kartuTerakhir->semester ?? ''), 2), 2, null);
    if (! in_array($semPilih, $semesterList, true)) $semPilih = $semesterList[0];
    if (! in_array($kelPilih, $kelasList, true))    $kelPilih = 'Kelas XII';

    // ===== Data jurusan: disiapkan MajorMatcher (dipakai bersama dengan halaman Beranda) =====
    $majorsSource  = isset($majors) ? $majors : \App\Models\Major::all();
    $matcher       = app(\App\Services\MajorMatcher::class);
    $majorsData    = collect($majorsSource)->map(fn ($m) => $matcher->prepare($m))->values();
    $subjectLabels = \App\Services\MajorMatcher::subjectLabels();
@endphp

<div class="nr">

    {{-- ============ Hero ============ --}}
    <section class="nr-hero">
        <div>
            <span class="nr-hero-tag">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2l2.4 6.9H22l-6 4.4 2.3 7L12 16l-6.3 4.3 2.3-7-6-4.4h7.6z"/></svg>
                REKOMENDASI JURUSAN
            </span>
            <h2>Temukan jurusan yang paling cocok untukmu</h2>
            <p>Isi nilai rapor, minat, dan keahlianmu. Persentase kecocokan tiap jurusan dihitung langsung dan diurutkan dari yang paling pas.</p>
        </div>

        <div class="nr-hero-stats" aria-live="polite">
            <div class="nr-stat">
                <span class="nr-stat-label">Mapel terisi</span>
                <div class="nr-stat-value"><span id="sumTerisi">0</span> <small>/ <span id="sumTotal">0</span></small></div>
            </div>
            <div class="nr-stat">
                <span class="nr-stat-label">Rata-rata</span>
                <div class="nr-stat-value" id="sumAvg">–</div>
            </div>
            <div class="nr-stat wide">
                <span class="nr-stat-label">Jurusan terbaik saat ini</span>
                <div class="nr-stat-value sm" id="sumTop">Belum ada nilai</div>
                <div class="nr-prog" role="progressbar" aria-label="Kelengkapan nilai" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="sumBarWrap">
                    <div id="sumBar"></div>
                </div>
            </div>
        </div>
    </section>

    @if (session('success'))
        <div class="alert alert-ok">{{ session('success') }}</div>
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

    <div class="nr-layout">

        <form class="nr-card nr-form" action="{{ route('report-cards.store') }}" method="POST" novalidate>
            @csrf
            <h3>Data nilai akademik</h3>
            <p class="nr-form-sub">Isi sesuai rapor terakhir yang kamu miliki. Rekomendasi diperbarui otomatis.</p>

            <input type="hidden" name="semester" id="semester-gabungan" value="{{ $semPilih }} - {{ $kelPilih }}">

            {{-- 1. Periode --}}
            <section class="nr-sec">
                <div class="nr-sec-head">
                    <span class="nr-sec-num">1</span>
                    <h4>Periode rapor</h4>
                </div>
                <p class="nr-hint">Pilih semester dan kelas dari rapor yang kamu isi.</p>
                <div class="nr-selects">
                    <div class="nr-field">
                        <label class="lbl" for="semester">Semester</label>
                        <select id="semester" onchange="gabungkan()">
                            @foreach ($semesterList as $opt)
                                <option value="{{ $opt }}" @selected($semPilih === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="nr-field">
                        <label class="lbl" for="kelas">Kelas</label>
                        <select id="kelas" onchange="gabungkan()">
                            @foreach ($kelasList as $opt)
                                <option value="{{ $opt }}" @selected($kelPilih === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            {{-- 2. Nilai mata pelajaran --}}
            <section class="nr-sec">
                <div class="nr-sec-head">
                    <span class="nr-sec-num">2</span>
                    <h4>Nilai mata pelajaran</h4>
                </div>
                <p class="nr-hint">Isi hanya mata pelajaran yang kamu ambil. Yang tidak ada di rapormu boleh dikosongkan.</p>

                <div class="nr-groups">
                    @foreach ($mapelGrup as $namaGrup => $daftar)
                        @php
                            $terisi = collect(array_keys($daftar))->filter(
                                fn ($k) => filled(old('scores.' . $k, $skorTerakhir[$k] ?? null))
                            )->count();
                            $buka = $loop->first || $terisi > 0
                                || collect(array_keys($daftar))->contains(fn ($k) => $errors->has('scores.' . $k));
                        @endphp
                        <details class="nr-group mapel-group" @if ($buka) open @endif>
                            <summary>
                                <span class="nr-group-ico" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $ikonGrup[$loop->index] ?? $ikonGrup[0] !!}</svg>
                                </span>
                                <span class="nr-group-name">{{ $namaGrup }}</span>
                                <span class="group-count">{{ $terisi }}/{{ count($daftar) }} terisi</span>
                            </summary>
                            <div class="nr-group-body">
                                @foreach ($daftar as $key => $label)
                                    <div class="nr-row nr-field">
                                        <label for="skor-{{ $key }}">{{ $label }}</label>
                                        <input
                                            type="number" id="skor-{{ $key }}" name="scores[{{ $key }}]"
                                            value="{{ old('scores.' . $key, $skorTerakhir[$key] ?? '') }}"
                                            min="0" max="100" step="0.1" inputmode="decimal"
                                            placeholder="Nilai (0-100)"
                                            class="{{ $errors->has('scores.' . $key) ? 'invalid' : '' }}">
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </div>
            </section>

            {{-- 3. Tentang dirimu --}}
            <section class="nr-sec">
                <div class="nr-sec-head">
                    <span class="nr-sec-num">3</span>
                    <h4>Tentang dirimu</h4>
                </div>
                <p class="nr-hint">Pisahkan dengan koma jika lebih dari satu. Minat &amp; keahlian ikut memengaruhi persentase kecocokan jurusan.</p>
                <div class="nr-about">
                    <div class="nr-field">
                        <label class="lbl" for="interests">Minat</label>
                        <input type="text" id="interests" name="interests"
                               value="{{ old('interests', $kartuTerakhir->interests ?? '') }}"
                               placeholder="Contoh: teknologi, desain"
                               class="{{ $errors->has('interests') ? 'invalid' : '' }}">
                    </div>
                    <div class="nr-field">
                        <label class="lbl" for="skills">Keahlian</label>
                        <input type="text" id="skills" name="skills"
                               value="{{ old('skills', $kartuTerakhir->skills ?? '') }}"
                               placeholder="Contoh: coding, public speaking"
                               class="{{ $errors->has('skills') ? 'invalid' : '' }}">
                    </div>
                </div>
            </section>

            <div class="nr-actions">
                <button type="submit" class="nr-submit">
                    Simpan nilai &amp; lanjut
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </div>
        </form>

        <aside class="nr-side">
            {{-- Top 3 live --}}
            <div class="nr-card nr-live">
                <div class="nr-side-head">
                    <span class="nr-side-ico" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 21h8"/><path d="M12 17v4"/><path d="M7 4h10v5a5 5 0 0 1-10 0z"/><path d="M17 5h3v2a3 3 0 0 1-3 3"/><path d="M7 5H4v2a3 3 0 0 0 3 3"/></svg>
                    </span>
                    <h4>Top 3 untukmu</h4>
                    <span class="nr-live-badge">LIVE</span>
                </div>
                <div id="recMini"></div>
                <a href="#rekomendasi" class="nr-live-link" id="recMiniLink" hidden>Lihat semua jurusan ↓</a>
            </div>

            <div class="nr-card">
                <div class="nr-side-head">
                    <span class="nr-side-ico" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                    </span>
                    <h4>Data kamu, kendalimu</h4>
                </div>
                <p>Nilai digunakan untuk menyusun rekomendasi pendidikan. Hasilnya bukan penentu mutlak masa depan.</p>
                <div class="nr-secure">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                    Aman dan transparan
                </div>
            </div>

            <div class="nr-card">
                <div class="nr-side-head">
                    <span class="nr-side-ico" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="9" y1="18" x2="15" y2="18"/><line x1="10" y1="22" x2="14" y2="22"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/></svg>
                    </span>
                    <h4>Tips mengisi nilai</h4>
                </div>
                <ul class="nr-tips">
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Gunakan nilai dari rapor asli
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Jangan isi perkiraan jika ragu
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Kamu bisa memperbaruinya nanti
                    </li>
                </ul>
            </div>
        </aside>
    </div>

    {{-- ============ Hasil rekomendasi ============ --}}
    <section class="nr-card nr-rec" id="rekomendasi">
        <div class="nr-rec-head">
            <div>
                <h3>Semua rekomendasi jurusan</h3>
                <p class="nr-rec-sub">
                    Persentase dihitung dari nilai mata pelajaran yang relevan dengan jurusan. Mapel relevan yang
                    belum kamu isi menurunkan skor. Jika minat &amp; keahlian diisi, bobotnya 70% nilai dan 30% minat.
                </p>
            </div>
        </div>

        <div class="nr-toolbar">
            <div class="nr-tabs" id="recTabs" role="tablist">
                <button type="button" class="nr-tab active" data-f="all">Semua <b data-c="all">0</b></button>
                <button type="button" class="nr-tab" data-f="high">Sangat cocok <b data-c="high">0</b></button>
                <button type="button" class="nr-tab" data-f="mid">Cocok <b data-c="mid">0</b></button>
                <button type="button" class="nr-tab" data-f="low">Cukup / kurang <b data-c="low">0</b></button>
            </div>
            <label class="nr-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="search" id="recSearch" placeholder="Cari jurusan..." autocomplete="off">
            </label>
        </div>

        <div id="recOut" aria-live="polite"></div>

        <div class="nr-note">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            <span>Hasil ini hanya rekomendasi awal. Tetap pertimbangkan passion, prospek karier, dan syarat seleksi masing-masing kampus.</span>
        </div>
    </section>

    <script>
        function gabungkan() {
            document.getElementById('semester-gabungan').value =
                document.getElementById('semester').value + ' - ' + document.getElementById('kelas').value;
        }

        (function () {
            var MAJORS = @json($majorsData);        // dari MajorMatcher::prepare()
            var LABELS = @json($subjectLabels);     // key mapel -> nama mapel
            var TOP_N = 7;
            var CIRC = 2 * Math.PI * 27;

            var showAll = false, filter = 'all', query = '', lastResults = [], timer = null;

            var groups   = document.querySelectorAll('.mapel-group');
            var elTerisi = document.getElementById('sumTerisi');
            var elTotal  = document.getElementById('sumTotal');
            var elAvg    = document.getElementById('sumAvg');
            var elTop    = document.getElementById('sumTop');
            var elBar    = document.getElementById('sumBar');
            var elWrap   = document.getElementById('sumBarWrap');
            var elInt    = document.getElementById('interests');
            var elSkl    = document.getElementById('skills');
            var recOut   = document.getElementById('recOut');
            var recMini  = document.getElementById('recMini');
            var miniLink = document.getElementById('recMiniLink');
            var tabs     = document.querySelectorAll('#recTabs .nr-tab');
            var elSearch = document.getElementById('recSearch');

            function norm(s) { return String(s).toLowerCase().replace(/\s+/g, ' ').trim(); }
            function normKey(s) { return String(s).toLowerCase().replace(/[\s-]+/g, '_').trim(); }

            function splitTerms(str) {
                var seen = {}, out = [];
                String(str || '').split(/[,;\n]/).forEach(function (t) {
                    var n = norm(t);
                    if (n && !seen[n]) { seen[n] = true; out.push(n); }
                });
                return out;
            }

            function tagMatches(tag, term) {
                var a = norm(tag), b = term;
                if (a === b) return true;
                if (a.length >= 3 && b.length >= 3) { return a.indexOf(b) !== -1 || b.indexOf(a) !== -1; }
                return false;
            }

            function level(p) {
                if (p >= 80) return { text: 'Sangat Cocok', cls: 'lv-high', key: 'high' };
                if (p >= 60) return { text: 'Cocok',        cls: 'lv-mid',  key: 'mid' };
                if (p >= 40) return { text: 'Cukup Cocok',  cls: 'lv-low',  key: 'low' };
                return           { text: 'Kurang Cocok',    cls: 'lv-none', key: 'low' };
            }

            function fmt(n, d) { return n.toFixed(d).replace('.', ','); }

            function el(tag, cls, text) {
                var e = document.createElement(tag);
                if (cls) e.className = cls;
                if (text !== undefined) e.textContent = text;
                return e;
            }

            function ring(pct) {
                var off = CIRC * (1 - pct / 100);
                var box = el('div', 'ring');
                box.innerHTML =
                    '<svg viewBox="0 0 64 64" aria-hidden="true">' +
                    '<circle class="bg" cx="32" cy="32" r="27"/>' +
                    '<circle class="fg" cx="32" cy="32" r="27" transform="rotate(-90 32 32)" ' +
                    'stroke-dasharray="' + CIRC.toFixed(2) + '" stroke-dashoffset="' + off.toFixed(2) + '"/>' +
                    '</svg><span>' + Math.round(pct) + '<small>%</small></span>';
                return box;
            }

            function bacaNilai() {
                var map = {};
                document.querySelectorAll('.mapel-group input[type=number]').forEach(function (i) {
                    if (i.value.trim() === '') return;
                    var v = parseFloat(i.value);
                    if (isNaN(v) || v < 0 || v > 100) return;
                    var m = /scores\[(.+)\]/.exec(i.name);
                    if (m) map[normKey(m[1])] = v;
                });
                return map;
            }

            // Rumus sama dengan MajorMatcher::gradeScore():
            // rata-rata berbobot mapel relevan x faktor cakupan (0,5 - 1)
            function skorNilai(m, grades, avg) {
                var subs = m.subjects || [];
                var wAll = 0, wFill = 0, sum = 0, names = [];

                subs.forEach(function (s) {
                    wAll += s.w;
                    if (grades[s.key] !== undefined) {
                        var g = grades[s.key];
                        var v = s.min > 0 ? Math.min(100, (g / s.min) * 100) : g;
                        wFill += s.w;
                        sum += s.w * v;
                        names.push(LABELS[s.key] || s.key);
                    }
                });

                if (wFill <= 0) {
                    return {
                        pct: avg * 0.5,
                        note: 'Nilai mapel yang relevan belum diisi, jadi hanya memakai rata-rata semua nilai (dikurangi).'
                    };
                }

                var coverage = wFill / wAll;
                return {
                    pct: (sum / wFill) * (0.5 + 0.5 * coverage),
                    note: 'Mapel relevan terisi: ' + names.join(', ') + ' (' + names.length + ' dari ' + subs.length + ').'
                };
            }

            var ICON_EMPTY = '<svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="10" y="8" width="44" height="48" rx="8"/><path d="M20 22h24M20 32h24M20 42h14"/><circle cx="46" cy="44" r="9" fill="#fff"/><path d="M42 44l3 3 5-6"/></svg>';

            function renderEmpty(target, title, msg) {
                target.innerHTML = '<div class="nr-empty">' + ICON_EMPTY + '<strong></strong><span></span></div>';
                target.querySelector('strong').textContent = title;
                target.querySelector('span').textContent = msg;
            }

            function updateTabs(results) {
                var c = { all: results.length, high: 0, mid: 0, low: 0 };
                results.forEach(function (r) { c[level(r.pct).key]++; });
                document.querySelectorAll('#recTabs b[data-c]').forEach(function (b) { b.textContent = c[b.dataset.c]; });
            }

            function renderMini(results) {
                recMini.innerHTML = '';
                if (!results.length) {
                    recMini.appendChild(el('div', 'nr-live-empty', 'Isi minimal satu nilai mata pelajaran, nanti 3 jurusan terbaikmu muncul di sini.'));
                    miniLink.hidden = true;
                    return;
                }
                var list = el('div', 'nr-mini-list');
                results.slice(0, 3).forEach(function (r, i) {
                    var lv = level(r.pct);
                    var row = el('div', 'nr-mini ' + lv.cls);
                    row.appendChild(el('div', 'nr-mini-rank', String(i + 1)));
                    var txt = el('div');
                    txt.appendChild(el('div', 'nr-mini-name', r.name));
                    txt.appendChild(el('div', 'nr-mini-lab', lv.text));
                    row.appendChild(txt);
                    row.appendChild(ring(r.pct));
                    list.appendChild(row);
                });
                recMini.appendChild(list);
                miniLink.hidden = false;
            }

            function card(r, featured, delay) {
                var lv = level(r.pct);
                var c = el('article', 'nr-res ' + lv.cls + (featured ? ' feat' : ''));
                c.style.animationDelay = Math.min(delay * 40, 320) + 'ms';

                var main = el('div', 'nr-res-main');

                var top = el('div', 'nr-res-top');
                top.appendChild(el('span', 'nr-res-rank', (featured ? '★ ' : '#') + r.rank));
                top.appendChild(el('span', 'nr-res-lab', lv.text));
                main.appendChild(top);

                main.appendChild(el('div', 'nr-res-name', r.name));
                if (r.note) main.appendChild(el('div', 'nr-res-meta', r.note));

                var bar = el('div', 'nr-res-bar');
                bar.setAttribute('role', 'progressbar');
                bar.setAttribute('aria-valuemin', '0');
                bar.setAttribute('aria-valuemax', '100');
                bar.setAttribute('aria-valuenow', String(Math.round(r.pct)));
                var fill = el('div');
                fill.style.width = r.pct.toFixed(1) + '%';
                bar.appendChild(fill);
                main.appendChild(bar);

                if (r.tags.length) {
                    var sorted = r.tags.slice().sort(function (a, b) { return (r.matched[b] ? 1 : 0) - (r.matched[a] ? 1 : 0); });
                    var maxTag = featured ? 8 : 5;
                    var tg = el('div', 'nr-tagrow');
                    sorted.slice(0, maxTag).forEach(function (t) {
                        tg.appendChild(el('span', 'nr-tag' + (r.matched[t] ? ' hit' : ''), t));
                    });
                    if (sorted.length > maxTag) tg.appendChild(el('span', 'nr-tag', '+' + (sorted.length - maxTag)));
                    main.appendChild(tg);
                }

                if (featured) {
                    c.appendChild(ring(r.pct));
                    c.appendChild(main);
                } else {
                    c.appendChild(main);
                    c.appendChild(ring(r.pct));
                }
                return c;
            }

            function renderResults() {
                if (!lastResults.length) return;

                var q = norm(query);
                var rows = lastResults.filter(function (r) {
                    if (filter !== 'all' && level(r.pct).key !== filter) return false;
                    if (q && norm(r.name).indexOf(q) === -1) return false;
                    return true;
                });

                recOut.innerHTML = '';
                if (!rows.length) {
                    renderEmpty(recOut, 'Tidak ada jurusan di filter ini', 'Coba ganti tab atau hapus kata pencarian.');
                    return;
                }

                var grid = el('div', 'nr-res-grid');
                var shown = showAll ? rows : rows.slice(0, TOP_N);
                var featuredOn = (filter === 'all' && !q);

                shown.forEach(function (r, i) {
                    grid.appendChild(card(r, featuredOn && i === 0, i));
                });
                recOut.appendChild(grid);

                if (rows.length > TOP_N) {
                    var btn = el('button', 'nr-more',
                        showAll ? 'Tampilkan lebih sedikit' : 'Tampilkan semua (' + rows.length + ' jurusan)');
                    btn.type = 'button';
                    btn.addEventListener('click', function () { showAll = !showAll; renderResults(); });
                    recOut.appendChild(btn);
                }
            }

            function hitungRekomendasi(avg, valid) {
                if (!MAJORS.length) {
                    lastResults = [];
                    updateTabs([]); renderMini([]);
                    elTop.textContent = 'Data jurusan kosong';
                    renderEmpty(recOut, 'Data jurusan belum tersedia', 'Pastikan tabel majors sudah terisi (jalankan MajorKnowledgeSeeder).');
                    return;
                }
                if (valid < 1) {
                    lastResults = [];
                    updateTabs([]); renderMini([]);
                    elTop.textContent = 'Belum ada nilai';
                    renderEmpty(recOut, 'Belum ada rekomendasi', 'Isi minimal satu nilai mata pelajaran di atas, hasilnya langsung muncul di sini.');
                    return;
                }

                var grades = bacaNilai();
                var terms  = splitTerms((elInt ? elInt.value : '') + ',' + (elSkl ? elSkl.value : ''));

                var results = MAJORS.map(function (m) {
                    var sn = skorNilai(m, grades, avg);

                    var matchedTerms = 0, matchedTags = {};
                    terms.forEach(function (t) {
                        var hit = false;
                        m.tags.forEach(function (tag) {
                            if (tagMatches(tag, t)) { hit = true; matchedTags[tag] = true; }
                        });
                        if (hit) matchedTerms++;
                    });

                    var pct = sn.pct;
                    if (terms.length > 0) {
                        pct = sn.pct * 0.7 + ((matchedTerms / terms.length) * 100) * 0.3;
                    }

                    return { name: m.name, tags: m.tags, note: sn.note, matched: matchedTags, pct: Math.max(0, Math.min(100, pct)) };
                }).sort(function (a, b) { return b.pct - a.pct; });

                results.forEach(function (r, i) { r.rank = i + 1; });
                lastResults = results;

                elTop.textContent = results[0].name + ' · ' + Math.round(results[0].pct) + '%';
                updateTabs(results);
                renderMini(results);
                renderResults();
            }

            function hitung() {
                var terisi = 0, total = 0, jumlah = 0, valid = 0;

                groups.forEach(function (g) {
                    var inputs = g.querySelectorAll('input[type=number]');
                    var n = 0;

                    inputs.forEach(function (i) {
                        total++;
                        if (i.value.trim() !== '') {
                            n++;
                            var v = parseFloat(i.value);
                            if (!isNaN(v) && v >= 0 && v <= 100) { jumlah += v; valid++; }
                        }
                    });

                    terisi += n;

                    var badge = g.querySelector('.group-count');
                    if (badge) badge.textContent = n + '/' + inputs.length + ' terisi';
                    g.classList.toggle('done', inputs.length > 0 && n === inputs.length);
                });

                var persen = total > 0 ? Math.round((terisi / total) * 100) : 0;
                var avg = valid > 0 ? jumlah / valid : 0;

                elTerisi.textContent = terisi;
                elTotal.textContent  = total;
                elAvg.textContent    = valid > 0 ? fmt(avg, 1) : '–';
                elBar.style.width    = persen + '%';
                elWrap.setAttribute('aria-valuenow', persen);

                hitungRekomendasi(avg, valid);
            }

            function hitungTunda() {
                clearTimeout(timer);
                timer = setTimeout(hitung, 120);
            }

            document.addEventListener('input', function (e) {
                var t = e.target;
                if (!t || !t.matches) return;

                if (t.matches('.mapel-group input[type=number]')) {
                    var v = parseFloat(t.value);
                    t.classList.toggle('invalid', t.value.trim() !== '' && (isNaN(v) || v < 0 || v > 100));
                    hitungTunda();
                } else if (t.id === 'interests' || t.id === 'skills') {
                    hitungTunda();
                }
            });

            tabs.forEach(function (tb) {
                tb.addEventListener('click', function () {
                    filter = tb.dataset.f;
                    tabs.forEach(function (x) { x.classList.toggle('active', x === tb); });
                    renderResults();
                });
            });

            elSearch.addEventListener('input', function () {
                query = elSearch.value;
                renderResults();
            });

            hitung();
        })();
    </script>

</div>
@endsection