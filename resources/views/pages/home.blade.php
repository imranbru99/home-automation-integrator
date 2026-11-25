@extends('layouts.app')

@section('title', 'Lumenridge Automation')
@section('meta_description', 'Premium whole-home smart lighting, security, climate, AV, and network systems installed across Boulder and the Denver metro by Lumenridge Automation.')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>Lumenridge<br>Automation</h1>
        <p>Scene-based lighting. Secure access. Quiet climate. Immersive AV — engineered as one system for Front Range homes that deserve better than box-store gadgets.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a design consult</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">Explore smart systems</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2>Smart home systems</h2>
        <p class="lede">Purpose-built integrations for lighting, security, climate, multi-room AV, motorized shades, and reliable home networks — never a pile of disconnected apps.</p>
        <div class="grid-3">
            @foreach([
                ['smart-lighting','Smart Lighting','Scene control, keypads, and architectural LED that feel intentional.','https://images.unsplash.com/photo-1565814329452-517dfc5c8d0e?auto=format&fit=crop&w=1200&q=80'],
                ['security-access','Security & Access','Cameras, locks, and monitoring wired into one reliable stack.','https://images.unsplash.com/photo-1557324232-b8917d3c3dcb?auto=format&fit=crop&w=1200&q=80'],
                ['climate-hvac','Climate Integration','Thermostats, zoning, and air quality that follow your schedule.','https://images.unsplash.com/photo-1585771724683-d6270d0d0c1e?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$blurb,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad">
                        <h3>{{ $title }}</h3>
                        <p>{{ $blurb }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Why Lumenridge</h2>
        <p class="lede">Boulder-based integrators who treat networking and UX as non-negotiable — because smart homes fail from the router out.</p>
        <div class="grid-3">
            <div class="panel">
                <h3>Design-first installs</h3>
                <p>Every project starts with a walkthrough, device map, and scene plan sized to how you actually live — not a shopping list.</p>
            </div>
            <div class="panel">
                <h3>Reliable infrastructure</h3>
                <p>Wired backbones, clean racks, UPS protection, and Wi‑Fi that covers the whole property before any “smart” layer goes live.</p>
            </div>
            <div class="panel">
                <h3>ERP-run jobs</h3>
                <p>Quotes, installs, inventory, invoices, and follow-ups live in one operations stack — fewer dropped balls on complex builds.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the Lumenridge ERP used to schedule techs, track controllers, and close invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>28</strong> Active jobs</div>
                    <div class="metric"><strong>$218k</strong> Pipeline</div>
                    <div class="metric"><strong>19</strong> Consults booked</div>
                </div>
                <div class="bars">
                    <span style="height:40%"></span><span style="height:65%"></span><span style="height:50%"></span>
                    <span style="height:80%"></span><span style="height:55%"></span><span style="height:90%"></span>
                    <span style="height:70%"></span>
                </div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);margin-top:0">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Projects & scheduling</li>
                    <li>Controllers / sensors inventory</li>
                    <li>Invoices & payments</li>
                    <li>AI content + troubleshooting</li>
                </ul>
                <a class="btn btn-primary" style="margin-top:1rem" href="/admin">Open admin ERP</a>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>From the lab</h2>
        <p class="lede">Guides and notes for homeowners who want systems that stay quiet and reliable.</p>
        <div class="grid-3">
            @forelse($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @empty
                <div class="panel"><p>Blog posts will appear after seeding.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
