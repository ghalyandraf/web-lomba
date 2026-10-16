@php
    $notifSuccess = session('success');
    $notifError   = session('error')
        ?? (($errors->any() && empty($skipErrors))
            ? 'Periksa kembali isian formulir: ' . $errors->first()
            : null);
    $notifMsg  = $notifSuccess ?: $notifError;
    $notifType = $notifSuccess ? 'ok' : 'err';
@endphp

@if ($notifMsg)
<style>
    .ntf-backdrop {
        position: fixed; inset: 0; z-index: 9999;
        display: flex; align-items: center; justify-content: center;
        padding: 20px;
        background: rgba(15, 42, 82, .45);
        -webkit-backdrop-filter: blur(3px); backdrop-filter: blur(3px);
        animation: ntfFade .2s ease both;
    }
    .ntf-backdrop.closing { animation: ntfOut .2s ease both; }
    .ntf-box {
        position: relative; overflow: hidden;
        width: min(400px, 100%);
        padding: 30px 26px 24px;
        text-align: center;
        background: #fff; border-radius: 22px;
        box-shadow: 0 30px 70px rgba(15, 42, 82, .35);
        animation: ntfPop .3s cubic-bezier(.2, .8, .2, 1) both;
    }
    .ntf-box::before {
        content: ''; position: absolute; left: 0; right: 0; top: 0; height: 4px;
        background: linear-gradient(90deg, #3fc58a, #1e7e4f);
    }
    .ntf-box.err::before { background: linear-gradient(90deg, #e57368, #c0392b); }
    .ntf-ico {
        display: grid; place-items: center;
        width: 62px; height: 62px; margin: 0 auto 16px;
        border-radius: 20px; background: #e6f6ee; color: #1e7e4f;
    }
    .ntf-box.err .ntf-ico { background: #fdecea; color: #c0392b; }
    .ntf-ico svg { width: 30px; height: 30px; fill: none; stroke: currentColor; stroke-width: 2.4; stroke-linecap: round; stroke-linejoin: round; }
    .ntf-title { font-size: 18px; font-weight: 800; color: #0f2a52; margin: 0 0 8px; }
    .ntf-text { font-size: 13px; line-height: 1.7; color: #64748b; margin: 0 0 20px; overflow-wrap: anywhere; }
    .ntf-btn {
        min-width: 120px; padding: 11px 24px; border: 0; border-radius: 12px;
        background: #1f5fae; color: #fff; cursor: pointer;
        font: 700 13px 'Inter', sans-serif;
        box-shadow: 0 8px 18px rgba(31, 95, 174, .28);
    }
    .ntf-box.err .ntf-btn { background: #c0392b; box-shadow: 0 8px 18px rgba(192, 57, 43, .25); }
    .ntf-btn:hover { filter: brightness(1.08); }
    .ntf-btn:focus-visible { outline: 3px solid #7dc3ff; outline-offset: 3px; }
    .ntf-bar { position: absolute; left: 0; bottom: 0; height: 3px; width: 100%; background: currentColor; opacity: .35; transform-origin: left; animation: ntfBar 4s linear both; color: #1e7e4f; }
    .ntf-box.err .ntf-bar { color: #c0392b; }
    @keyframes ntfFade { from { opacity: 0; } to { opacity: 1; } }
    @keyframes ntfOut  { from { opacity: 1; } to { opacity: 0; } }
    @keyframes ntfPop  { from { opacity: 0; transform: translateY(14px) scale(.94); } to { opacity: 1; transform: none; } }
    @keyframes ntfBar  { from { transform: scaleX(1); } to { transform: scaleX(0); } }
    @media (prefers-reduced-motion: reduce) {
        .ntf-backdrop, .ntf-box, .ntf-bar { animation: none !important; }
    }
</style>

<div class="ntf-backdrop" id="ntfBackdrop" role="alertdialog" aria-modal="true" aria-labelledby="ntfTitle" aria-describedby="ntfText">
    <div class="ntf-box {{ $notifType }}">
        <div class="ntf-ico" aria-hidden="true">
            @if ($notifType === 'ok')
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            @else
                <svg viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            @endif
        </div>
        <h3 class="ntf-title" id="ntfTitle">{{ $notifType === 'ok' ? 'Berhasil' : 'Terjadi kesalahan' }}</h3>
        <p class="ntf-text" id="ntfText">{{ $notifMsg }}</p>
        <button type="button" class="ntf-btn" id="ntfOk">OK</button>
        @if ($notifType === 'ok')
            <span class="ntf-bar" aria-hidden="true"></span>
        @endif
    </div>
</div>

<script>
    (function () {
        var bd = document.getElementById('ntfBackdrop');
        if (!bd) return;
        var timer = null;

        function tutup() {
            clearTimeout(timer);
            document.removeEventListener('keydown', onKey);
            bd.classList.add('closing');
            setTimeout(function () { if (bd.parentNode) bd.parentNode.removeChild(bd); }, 200);
        }
        function onKey(e) { if (e.key === 'Escape' || e.key === 'Enter') tutup(); }

        document.getElementById('ntfOk').addEventListener('click', tutup);
        bd.addEventListener('click', function (e) { if (e.target === bd) tutup(); });
        document.addEventListener('keydown', onKey);
        document.getElementById('ntfOk').focus();

        @if ($notifType === 'ok')
        timer = setTimeout(tutup, 4000);   // sukses hilang otomatis; error menunggu ditutup manual
        @endif
    })();
</script>
@endif