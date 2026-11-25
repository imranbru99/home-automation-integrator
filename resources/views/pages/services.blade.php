@extends('layouts.app')
@section('title', 'Smart Home Services')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">Lumenridge designs and installs lighting, security, climate, AV, shades, and network systems as one coherent home automation stack.</p>
        <div class="grid-3">
            @foreach([
                ['smart-lighting','Smart Lighting','https://images.unsplash.com/photo-1565814329452-517dfc5c8d0e?auto=format&fit=crop&w=1200&q=80'],
                ['security-access','Security & Access','https://images.unsplash.com/photo-1557324232-b8917d3c3dcb?auto=format&fit=crop&w=1200&q=80'],
                ['climate-hvac','Climate Integration','https://images.unsplash.com/photo-1585771724683-d6270d0d0c1e?auto=format&fit=crop&w=1200&q=80'],
                ['multi-room-av','Multi-Room AV','https://images.unsplash.com/photo-1593784991095-a205069470b6?auto=format&fit=crop&w=1200&q=80'],
                ['motorized-shades','Motorized Shades','https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=1200&q=80'],
                ['network-infrastructure','Network Infrastructure','https://images.unsplash.com/photo-1544197150-b99a580bb7a2?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad"><h3>{{ $title }}</h3></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
