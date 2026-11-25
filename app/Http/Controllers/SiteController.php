<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\KnowledgeArticle;
use App\Models\Post;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->take(3)->get();

        return view('pages.home', compact('posts'));
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function serviceShow(string $slug): View
    {
        $services = $this->serviceCatalog();
        abort_unless(isset($services[$slug]), 404);

        return view('services.show', [
            'slug' => $slug,
            'service' => $services[$slug],
            'services' => $services,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks! Lumenridge will follow up within one business day.');
    }

    public function blog(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function knowledge(): View
    {
        $articles = KnowledgeArticle::query()->where('is_published', true)->orderBy('category')->orderBy('title')->get()->groupBy('category');

        return view('kb.index', compact('articles'));
    }

    public function knowledgeShow(string $slug): View
    {
        $article = KnowledgeArticle::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('kb.show', compact('article'));
    }

    public function chat(Request $request, AiService $ai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:80'],
        ]);

        $result = $ai->chat($data['message'], $data['session_id'] ?? null);

        return response()->json($result);
    }

    /** @return array<string, array<string, string>> */
    protected function serviceCatalog(): array
    {
        return [
            'smart-lighting' => [
                'title' => 'Smart Lighting Control',
                'summary' => 'Scene-based keypads, dimmers, and architectural LED that feel intentional at every hour.',
                'body' => 'Lumenridge designs lighting that matches how you live — morning scenes, evening paths, theater blackout, and vacation modes. We specify processors, keypads, and fixtures that work as one system, then commission scenes with you so the home feels calm instead of complicated.',
                'image' => 'https://images.unsplash.com/photo-1565814329452-517dfc5c8d0e?auto=format&fit=crop&w=1600&q=80',
            ],
            'security-access' => [
                'title' => 'Security & Access Control',
                'summary' => 'Cameras, smart locks, sensors, and monitoring wired into a reliable Front Range stack.',
                'body' => 'From driveway cameras to door locks and glass-break sensors, we integrate security that alerts the right people without false-alarm chaos. Systems are documented, backed up, and tied into lighting and shades when that makes sense for deterrence.',
                'image' => 'https://images.unsplash.com/photo-1557324232-b8917d3c3dcb?auto=format&fit=crop&w=1600&q=80',
            ],
            'climate-hvac' => [
                'title' => 'Climate & HVAC Integration',
                'summary' => 'Smart thermostats, zoning, and air quality that follow occupancy and schedules.',
                'body' => 'Colorado weather swings hard. We integrate climate controls with occupancy, shades, and schedules so rooms stay comfortable without you babysitting the thermostat. Ideal for multi-zone homes, vacation properties, and energy-conscious renovations.',
                'image' => 'https://images.unsplash.com/photo-1585771724683-d6270d0d0c1e?auto=format&fit=crop&w=1600&q=80',
            ],
            'multi-room-av' => [
                'title' => 'Multi-Room AV & Theater',
                'summary' => 'Distributed audio, video switching, and cinema rooms that stay simple to use.',
                'body' => 'Lumenridge builds multi-room audio, hidden speakers, video distribution, and dedicated theaters with clean racks and one-button scenes. Guests should never need a remote tutorial — just press “Movie” or “Dinner” and enjoy.',
                'image' => 'https://images.unsplash.com/photo-1593784991095-a205069470b6?auto=format&fit=crop&w=1600&q=80',
            ],
            'motorized-shades' => [
                'title' => 'Motorized Shades & Daylight',
                'summary' => 'Quiet motors, synced groups, and scenes that protect interiors and privacy.',
                'body' => 'Front Range sun is intense. We specify motorized shades that sync with lighting and climate scenes — morning lift, midday UV protect, evening privacy — with quiet motors and reliable power paths (battery, hardwired, or hybrid).',
                'image' => 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&w=1600&q=80',
            ],
            'network-infrastructure' => [
                'title' => 'Network Infrastructure',
                'summary' => 'Wired backbones, enterprise-grade Wi‑Fi, racks, and UPS before any smart layer goes live.',
                'body' => 'Smart homes fail from bad networks. Lumenridge builds structured cabling, PoE switches, access points, and rack layouts with UPS protection so cameras, locks, and controllers stay online. We document ports, SSIDs, and VLANs for future serviceability.',
                'image' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a2?auto=format&fit=crop&w=1600&q=80',
            ],
        ];
    }
}
