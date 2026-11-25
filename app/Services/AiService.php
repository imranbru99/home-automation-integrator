<?php

namespace App\Services;

use App\Models\ChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = [
        [
            'q' => 'how long install timeline schedule project',
            'a' => 'Most residential lighting or security packages take 1–4 days on site depending on rough-in status. Whole-home AV + automation builds are phased across construction. Lumenridge typically books design consults within 2–3 business days across Boulder and the Denver metro.',
        ],
        [
            'q' => 'cost price estimate quote smart home automation',
            'a' => 'Front Range smart home projects often range from about $4,500 for focused lighting/security packages to $45,000+ for whole-home lighting, AV, shades, and network infrastructure. Remodels and new builds differ. Request a free design consult for a written quote.',
        ],
        [
            'q' => 'lighting scene keypad dimmer led',
            'a' => 'We design scene-based lighting with keypads, dimmers, and architectural LED. Morning, evening, theater, and vacation scenes are commissioned with you so the home feels calm — not like a gadget maze.',
        ],
        [
            'q' => 'security camera lock access monitoring',
            'a' => 'Lumenridge integrates cameras, smart locks, sensors, and monitoring into one reliable stack with documented networking. Alerts go to the right people without false-alarm chaos, and systems can tie into lighting scenes for deterrence.',
        ],
        [
            'q' => 'climate thermostat hvac zoning air',
            'a' => 'We integrate smart thermostats, zoning, and air quality with occupancy and shade scenes so rooms stay comfortable through Colorado temperature swings — without babysitting the thermostat.',
        ],
        [
            'q' => 'av theater speaker multi room audio video',
            'a' => 'Multi-room audio, video switching, and cinema rooms are built with clean racks and one-button scenes. Guests should never need a remote tutorial — just press Movie or Dinner.',
        ],
        [
            'q' => 'shades motorized blinds daylight privacy',
            'a' => 'Motorized shades sync with lighting and climate for morning lift, midday UV protect, and evening privacy. We specify quiet motors with reliable power paths for Front Range sun intensity.',
        ],
        [
            'q' => 'network wifi rack infrastructure cable',
            'a' => 'Smart homes fail from bad networks. We build structured cabling, PoE switches, access points, racks, and UPS protection before any automation layer goes live — documented for future serviceability.',
        ],
        [
            'q' => 'schedule appointment consult contact',
            'a' => 'Call or text (303) 555-0182, use the contact form, or WhatsApp us. Design consults for Boulder, Denver, Highlands Ranch, Fort Collins, and nearby Front Range cities are usually available within 2–3 business days.',
        ],
    ];

    public function chat(string $message, ?string $sessionId = null): array
    {
        $reply = null;
        $source = 'demo';

        if ($key = config('services.openai.key')) {
            try {
                $reply = $this->callOpenAi($message, $key);
                $source = 'openai';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply && ($gemini = config('services.gemini.key'))) {
            try {
                $reply = $this->callGemini($message, $gemini);
                $source = 'gemini';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply) {
            $reply = $this->demoReply($message);
            $source = 'demo';
        }

        ChatLog::query()->create([
            'session_id' => $sessionId,
            'message' => $message,
            'reply' => $reply,
            'source' => $source,
        ]);

        return ['reply' => $reply, 'source' => $source];
    }

    public function generate(string $type, string $prompt): string
    {
        $message = match ($type) {
            'blog' => "Write a concise SEO blog post outline and intro for a home automation integrator about: {$prompt}",
            'description' => "Write a compelling product/service description for smart home systems: {$prompt}",
            'automation' => "Suggest 5 practical AI automations for a home automation SME ERP related to: {$prompt}",
            'troubleshoot' => "Troubleshoot this home automation operations issue with clear steps: {$prompt}",
            default => $prompt,
        };

        $result = $this->chat($message);

        return $result['reply'];
    }

    protected function demoReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $word) {
                if ($word !== '' && str_contains($hay, $word)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best;
        }

        return 'Thanks for reaching Lumenridge Automation. We design and install whole-home smart lighting, security, climate, AV, shades, and network systems across Boulder and the Denver metro. Ask about pricing, scenes, cameras, or scheduling—or call (303) 555-0182 for a free design consult.';
    }

    protected function callOpenAi(string $message, string $key): string
    {
        $response = Http::withToken($key)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the Lumenridge Automation assistant for a Boulder, CO home automation integrator. Be concise, practical, and focused on smart lighting, security, climate, multi-room AV, motorized shades, and network infrastructure. Never invent illegal claims.',
                    ],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'choices.0.message.content', 'Unable to generate a response.');
    }

    protected function callGemini(string $message, string $key): string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "You are Lumenridge Automation assistant (Boulder home automation). Answer briefly:\n{$message}"],
                        ],
                    ],
                ],
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', 'Unable to generate a response.');
    }
}
