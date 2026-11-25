<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lumenridge Automation') — Boulder Smart Homes</title>
    <meta name="description" content="@yield('meta_description', 'Lumenridge Automation designs and installs whole-home smart lighting, security, climate, AV, and network systems across Boulder and the Denver metro.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0a1628;
            --signal: #2bb0ed;
            --signal-deep: #1a8bc7;
            --ember: #ff7a3d;
            --steel: #5b6b7c;
            --surface: #eef4f8;
            --panel: #f7fbfd;
            --mist: #d6e4f0;
            --white: #ffffff;
            --font-display: "Syne", sans-serif;
            --font-body: "Outfit", sans-serif;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font-body);
            color: var(--ink);
            background:
                radial-gradient(1100px 520px at 90% -10%, rgba(43,176,237,.18), transparent 55%),
                radial-gradient(780px 460px at -10% 20%, rgba(255,122,61,.10), transparent 50%),
                linear-gradient(180deg, #f5f9fc 0%, var(--surface) 48%, #dce8f2 100%);
            min-height: 100vh;
        }
        a { color: inherit; text-decoration: none; }
        .wrap { width: min(1120px, calc(100% - 2rem)); margin-inline: auto; }
        .site-header {
            position: sticky; top: 0; z-index: 40;
            backdrop-filter: blur(12px);
            background: rgba(10,22,40,.92);
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: .9rem 0; gap: 1rem;
        }
        .brand {
            font-family: var(--font-display);
            letter-spacing: -.02em;
            font-size: 1.35rem;
            color: #fff;
            font-weight: 800;
        }
        .brand span { color: var(--signal); }
        .nav-links { display: flex; flex-wrap: wrap; gap: .9rem 1.1rem; align-items: center; }
        .nav-links a { color: rgba(255,255,255,.82); font-size: .92rem; font-weight: 500; }
        .nav-links a:hover { color: #fff; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: .4rem; padding: .75rem 1.2rem; border-radius: .4rem;
            font-weight: 700; border: 0; cursor: pointer;
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: var(--signal); color: #fff; box-shadow: 0 10px 24px rgba(43,176,237,.28); }
        .btn-primary:hover { background: var(--signal-deep); }
        .btn-ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.28); }
        .btn-dark { background: var(--ink); color: #fff; }
        .hero {
            min-height: calc(100vh - 64px);
            display: grid;
            align-items: end;
            position: relative;
            overflow: hidden;
            color: #fff;
            background:
                linear-gradient(105deg, rgba(10,22,40,.92) 0%, rgba(10,22,40,.55) 48%, rgba(10,22,40,.3) 100%),
                url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
        }
        .hero-inner { padding: 5.5rem 0 4rem; max-width: 640px; animation: rise .8s ease both; }
        .hero h1 {
            font-family: var(--font-display);
            font-size: clamp(2.6rem, 7vw, 4.2rem);
            line-height: .98;
            margin: 0 0 1rem;
            letter-spacing: -.03em;
        }
        .hero p { font-size: 1.08rem; line-height: 1.6; color: rgba(255,255,255,.88); margin: 0 0 1.5rem; max-width: 34rem; }
        .hero-ctas { display: flex; flex-wrap: wrap; gap: .75rem; }
        .section { padding: 4.5rem 0; }
        .section h2 {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 4vw, 2.55rem);
            letter-spacing: -.02em;
            margin: 0 0 .75rem;
        }
        .lede { color: var(--steel); max-width: 40rem; line-height: 1.6; margin: 0 0 2rem; }
        .grid-3 { display: grid; gap: 1.25rem; grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-2 { display: grid; gap: 1.5rem; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .service-tile {
            position: relative; overflow: hidden; min-height: 260px; color: #fff;
            isolation: isolate; border-radius: .35rem;
        }
        .service-tile img {
            position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2;
            transition: transform .6s ease;
        }
        .service-tile:hover img { transform: scale(1.06); }
        .service-tile::after {
            content: ""; position: absolute; inset: 0; z-index: -1;
            background: linear-gradient(180deg, rgba(10,22,40,.12), rgba(10,22,40,.88));
        }
        .service-tile .pad { position: absolute; left: 0; right: 0; bottom: 0; padding: 1.25rem; }
        .service-tile h3 { margin: 0 0 .35rem; font-family: var(--font-display); letter-spacing: -.01em; }
        .service-tile p { margin: 0; color: rgba(255,255,255,.85); font-size: .92rem; }
        .panel {
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(10,22,40,.06);
            padding: 1.4rem;
            border-radius: .35rem;
        }
        .panel h3 { margin: 0 0 .5rem; font-family: var(--font-display); letter-spacing: -.01em; }
        .dash-preview {
            display: grid; gap: 1rem; grid-template-columns: 1.2fr .8fr;
            background: var(--ink); color: #fff; padding: 1.5rem; overflow: hidden; border-radius: .4rem;
        }
        .metric { padding: 1rem; background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08); border-radius: .3rem; }
        .metric strong { display: block; font-size: 1.6rem; color: var(--signal); font-family: var(--font-display); }
        .bars { display: flex; align-items: end; gap: .45rem; height: 140px; margin-top: 1rem; }
        .bars span {
            flex: 1; border-radius: 2px 2px 0 0;
            background: linear-gradient(180deg, var(--signal), var(--ember));
            animation: grow .9s ease both;
        }
        form.stack { display: grid; gap: .85rem; }
        label { font-weight: 600; font-size: .9rem; }
        input, textarea, select {
            width: 100%; padding: .8rem .9rem; border: 1px solid rgba(10,22,40,.14);
            background: #fff; font: inherit; border-radius: .3rem;
        }
        .flash {
            background: rgba(43,176,237,.12); border: 1px solid rgba(43,176,237,.35);
            color: #0d4a6e; padding: .9rem 1rem; margin-bottom: 1rem; border-radius: .3rem;
        }
        .site-footer {
            background: var(--ink); color: rgba(255,255,255,.78); padding: 2.5rem 0;
            margin-top: 2rem;
        }
        .site-footer .brand { margin-bottom: .5rem; }
        .wa-float {
            position: fixed; right: 1.1rem; bottom: 1.1rem; z-index: 50;
            width: 56px; height: 56px; border-radius: 999px;
            display: grid; place-items: center;
            background: #25d366; color: #fff; font-weight: 800;
            box-shadow: 0 12px 28px rgba(0,0,0,.25);
            animation: pulse 2.4s ease infinite;
        }
        .chat-widget {
            position: fixed; left: 1.1rem; bottom: 1.1rem; z-index: 50; width: min(360px, calc(100vw - 2rem));
        }
        .chat-toggle {
            background: var(--ink); color: #fff; border: 0; padding: .8rem 1rem;
            font-weight: 700; cursor: pointer; width: 100%; border-radius: .3rem;
        }
        .chat-panel {
            display: none; background: #fff; border: 1px solid rgba(10,22,40,.1);
            box-shadow: 0 18px 40px rgba(10,22,40,.18); overflow: hidden; border-radius: .35rem .35rem 0 0;
        }
        .chat-panel.open { display: block; animation: rise .25s ease; }
        .chat-log { height: 240px; overflow: auto; padding: .9rem; background: var(--panel); }
        .bubble { margin: .4rem 0; padding: .65rem .75rem; border-radius: .4rem; max-width: 90%; font-size: .9rem; line-height: 1.4; }
        .bubble.bot { background: #fff; border: 1px solid rgba(10,22,40,.08); }
        .bubble.user { background: var(--ink); color: #fff; margin-left: auto; }
        .chat-form { display: flex; gap: .4rem; padding: .65rem; }
        .chat-form input { flex: 1; }
        @keyframes rise { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: none; } }
        @keyframes grow { from { transform: scaleY(.2); transform-origin: bottom; } to { transform: scaleY(1); } }
        @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        @media (max-width: 900px) {
            .grid-3, .grid-2, .dash-preview { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .hero { min-height: 78vh; }
        }
    </style>
    @stack('head')
</head>
<body>
<header class="site-header">
    <div class="wrap nav">
        <a class="brand" href="{{ route('home') }}">Lumen<span>ridge</span></a>
        <nav class="nav-links">
            <a href="{{ route('services') }}">Services</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('blog') }}">Blog</a>
            <a href="{{ route('knowledge') }}">Knowledge</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a design consult</a>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="wrap">
        <div class="brand">Lumen<span>ridge</span> Automation</div>
        <p>Boulder · Denver · Highlands Ranch · Fort Collins — whole-home smart lighting, security, climate & AV.</p>
        <p style="margin-top:1rem;font-size:.9rem;">(303) 555-0182 · hello@lumenridge.com · <a href="/admin" style="color:var(--signal)">Admin ERP</a></p>
    </div>
</footer>

<a class="wa-float" href="https://wa.me/13035550182" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>

<div class="chat-widget" id="lr-chat">
    <div class="chat-panel" id="chat-panel">
        <div class="chat-log" id="chat-log">
            <div class="bubble bot">Hi — ask Lumenridge about smart lighting, security, climate control, AV, motorized shades, or booking a Front Range design consult.</div>
        </div>
        <form class="chat-form" id="chat-form">
            <input type="text" id="chat-input" placeholder="Ask about home automation…" required maxlength="2000">
            <button class="btn btn-primary" type="submit">Send</button>
        </form>
    </div>
    <button class="chat-toggle" type="button" id="chat-toggle">AI Smart Home Assistant</button>
</div>

<script>
(() => {
    const panel = document.getElementById('chat-panel');
    const toggle = document.getElementById('chat-toggle');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const log = document.getElementById('chat-log');
    const sessionId = 'lr-' + Math.random().toString(36).slice(2);
    toggle.addEventListener('click', () => panel.classList.toggle('open'));
    const add = (text, who) => {
        const el = document.createElement('div');
        el.className = 'bubble ' + who;
        el.textContent = text;
        log.appendChild(el);
        log.scrollTop = log.scrollHeight;
    };
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        add(message, 'user');
        input.value = '';
        try {
            const res = await fetch(@json(route('ai.chat')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message, session_id: sessionId }),
            });
            const data = await res.json();
            add(data.reply || 'Something went wrong.', 'bot');
        } catch (err) {
            add('Network error — please try again or call (303) 555-0182.', 'bot');
        }
    });
})();
</script>
@stack('scripts')
</body>
</html>
