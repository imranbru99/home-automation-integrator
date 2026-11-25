<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(303) 555-0100',
            ]
        );
        $admin->syncRoles(['admin']);

        User::query()->updateOrCreate(
            ['email' => 'manager@lumenridge.com'],
            [
                'name' => 'Maya Ellison',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(303) 555-0101',
            ]
        )->syncRoles(['manager']);

        User::query()->updateOrCreate(
            ['email' => 'tech@lumenridge.com'],
            [
                'name' => 'Jordan Pike',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(303) 555-0102',
            ]
        )->syncRoles(['staff']);

        $settings = [
            'company_name' => 'Lumenridge Automation',
            'company_phone' => '(303) 555-0182',
            'company_email' => 'hello@lumenridge.com',
            'whatsapp' => '13035550182',
            'service_area' => 'Boulder, Denver, Highlands Ranch, Fort Collins & Front Range',
            'tax_rate' => '8.31',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = [
            ['name' => 'Lighting Processor Kit', 'sku' => 'HA-LIT-PROC', 'category' => 'lighting', 'unit_cost' => 420, 'unit_price' => 780, 'stock_qty' => 12],
            ['name' => 'Scene Keypad (5-button)', 'sku' => 'HA-LIT-KP5', 'category' => 'lighting', 'unit_cost' => 85, 'unit_price' => 165, 'stock_qty' => 48],
            ['name' => 'PoE Camera Bundle (4)', 'sku' => 'HA-SEC-CAM4', 'category' => 'security', 'unit_cost' => 310, 'unit_price' => 590, 'stock_qty' => 16],
            ['name' => 'Smart Lock Pro', 'sku' => 'HA-SEC-LCK', 'category' => 'security', 'unit_cost' => 145, 'unit_price' => 289, 'stock_qty' => 22],
            ['name' => 'Climate Hub + Sensors', 'sku' => 'HA-CLM-HUB', 'category' => 'climate', 'unit_cost' => 190, 'unit_price' => 365, 'stock_qty' => 18],
            ['name' => 'In-Ceiling Speaker Pair', 'sku' => 'HA-AV-SPK', 'category' => 'av', 'unit_cost' => 120, 'unit_price' => 245, 'stock_qty' => 30],
            ['name' => 'Shade Motor QuietDrive', 'sku' => 'HA-SHD-MOT', 'category' => 'shades', 'unit_cost' => 95, 'unit_price' => 185, 'stock_qty' => 36],
            ['name' => 'Network Rack Starter Kit', 'sku' => 'HA-NET-RACK', 'category' => 'network', 'unit_cost' => 260, 'unit_price' => 495, 'stock_qty' => 10],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + ['unit' => 'kit', 'is_active' => true]);
        }

        $customers = collect([
            ['name' => 'Elena Vargas', 'email' => 'elena@example.com', 'phone' => '(303) 555-4401', 'company' => null, 'city' => 'Boulder', 'state' => 'CO', 'zip' => '80302', 'address' => '814 Mapleton Ave'],
            ['name' => 'Chris Novak', 'email' => 'chris@foothillsbuild.com', 'phone' => '(303) 555-4410', 'company' => 'Foothills Build Co.', 'city' => 'Denver', 'state' => 'CO', 'zip' => '80206', 'address' => '2200 E 12th Ave'],
            ['name' => 'Priya Raman', 'email' => 'priya@ridgeviewestates.com', 'phone' => '(720) 555-4499', 'company' => 'Ridgeview Estates', 'city' => 'Highlands Ranch', 'state' => 'CO', 'zip' => '80129', 'address' => '9400 Town Center Dr'],
            ['name' => 'Sam Ortiz', 'email' => 'sam.ortiz@example.com', 'phone' => '(970) 555-4188', 'company' => null, 'city' => 'Fort Collins', 'state' => 'CO', 'zip' => '80525', 'address' => '412 Remington St'],
            ['name' => 'Hannah Cho', 'email' => 'hannah@loftline.dev', 'phone' => '(303) 555-4177', 'company' => 'Loftline Studios', 'city' => 'Denver', 'state' => 'CO', 'zip' => '80205', 'address' => '1550 Wewatta St'],
        ])->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $projects = [
            ['customer' => 0, 'title' => 'Whole-home lighting scenes + keypads', 'service_type' => 'lighting', 'status' => 'scheduled', 'sq_ft' => 3200, 'quoted_amount' => 18400],
            ['customer' => 1, 'title' => 'New-build network rack + Wi‑Fi', 'service_type' => 'network', 'status' => 'in_progress', 'sq_ft' => 4800, 'quoted_amount' => 12600],
            ['customer' => 2, 'title' => 'Estate security + access package', 'service_type' => 'security', 'status' => 'quoted', 'sq_ft' => 6200, 'quoted_amount' => 27800],
            ['customer' => 3, 'title' => 'Theater + distributed audio', 'service_type' => 'av', 'status' => 'completed', 'sq_ft' => 2800, 'quoted_amount' => 21500, 'final_amount' => 22150],
            ['customer' => 4, 'title' => 'Motorized shades + climate scenes', 'service_type' => 'shades', 'status' => 'invoiced', 'sq_ft' => 2100, 'quoted_amount' => 9800, 'final_amount' => 9650],
        ];

        $projectModels = [];
        foreach ($projects as $i => $p) {
            $customer = $customers[$p['customer']];
            $projectModels[] = Project::query()->updateOrCreate(
                ['job_number' => 'JOB-26'.str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $customer->id,
                    'title' => $p['title'],
                    'service_type' => $p['service_type'],
                    'status' => $p['status'],
                    'sq_ft' => $p['sq_ft'],
                    'quoted_amount' => $p['quoted_amount'],
                    'final_amount' => $p['final_amount'] ?? null,
                    'start_date' => now()->subDays(10 - $i)->toDateString(),
                    'site_address' => trim(($customer->address ?? '').', '.$customer->city.', '.$customer->state),
                    'notes' => 'Seeded demo job for Lumenridge ERP.',
                ]
            );
        }

        foreach ([0, 1, 3, 4] as $idx) {
            $project = $projectModels[$idx];
            $invoice = Invoice::query()->updateOrCreate(
                ['invoice_number' => 'INV-26'.str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $project->customer_id,
                    'project_id' => $project->id,
                    'issue_date' => now()->subDays(8 - $idx)->toDateString(),
                    'due_date' => now()->addDays(14)->toDateString(),
                    'subtotal' => $project->final_amount ?? $project->quoted_amount,
                    'tax' => round(($project->final_amount ?? $project->quoted_amount) * 0.0831, 2),
                    'total' => round(($project->final_amount ?? $project->quoted_amount) * 1.0831, 2),
                    'amount_paid' => in_array($project->status, ['completed', 'invoiced'], true) ? round(($project->final_amount ?? $project->quoted_amount) * 1.0831, 2) : 0,
                    'status' => in_array($project->status, ['completed', 'invoiced'], true) ? 'paid' : 'sent',
                ]
            );

            if ($invoice->status === 'paid') {
                Payment::query()->updateOrCreate(
                    ['reference' => 'PMT-'.$invoice->invoice_number],
                    [
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'paid_at' => now()->subDays(3)->toDateString(),
                        'method' => 'card',
                        'notes' => 'Demo payment',
                    ]
                );
            }
        }

        Appointment::query()->updateOrCreate(
            ['title' => 'Design consult — Vargas'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projectModels[0]->id,
                'type' => 'consult',
                'starts_at' => now()->addDays(2)->setTime(10, 0),
                'ends_at' => now()->addDays(2)->setTime(11, 0),
                'status' => 'scheduled',
                'location' => $customers[0]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Network rack install day'],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projectModels[1]->id,
                'type' => 'install',
                'starts_at' => now()->addDays(9)->setTime(8, 0),
                'ends_at' => now()->addDays(9)->setTime(16, 0),
                'status' => 'confirmed',
                'location' => $customers[1]->address,
            ]
        );

        $posts = [
            [
                'title' => 'Why Smart Homes Fail From the Router Out',
                'excerpt' => 'Gadgets on weak Wi‑Fi create support tickets. Lumenridge starts with cabling, PoE, and coverage maps.',
                'cover' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a2?auto=format&fit=crop&w=1400&q=80',
                'body' => "Most “smart home” frustration is not the keypad — it is packet loss, dead zones, and consumer routers under PoE camera load. When locks and lights fight for bandwidth with streaming, scenes feel flaky and owners blame the automation brand.\n\nLumenridge designs structured cabling, enterprise-grade Wi‑Fi, VLANs, and UPS-backed racks before any scene programming. If your system drops offline when the kids start a game, stop adding gadgets and fix the backbone.",
            ],
            [
                'title' => 'Scene Design That Guests Can Actually Use',
                'excerpt' => 'One-button evenings beat twelve remote apps. Here is how we commission lighting, AV, and shades together.',
                'cover' => 'https://images.unsplash.com/photo-1565814329452-517dfc5c8d0e?auto=format&fit=crop&w=1400&q=80',
                'body' => "A good scene is boring in the best way: Dinner lowers shades, softens lights, and routes audio. Movie dims the room and powers the projector. Vacation looks occupied without looking robotic.\n\nWe walk rooms with you, name scenes in plain language, and leave a laminated cheat card. Complexity belongs in the rack — not in your guests’ hands.",
            ],
            [
                'title' => 'Front Range Security Without False Alarm Fatigue',
                'excerpt' => 'Cameras and sensors only help when alerts are trusted. Integration and networking matter as much as lenses.',
                'cover' => 'https://images.unsplash.com/photo-1557324232-b8917d3c3dcb?auto=format&fit=crop&w=1400&q=80',
                'body' => "False alarms train people to ignore notifications. Lumenridge tunes camera placement, motion rules, and door/window sensors around how the household actually moves — pets, mountain wind, and driveway traffic included.\n\nWe document credentials, retention, and who gets which alert. Deterrence lighting scenes can pair with cameras when that fits the property. Ask us for a security walkthrough before you buy another standalone doorbell.",
            ],
        ];
        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'cover_image' => $post['cover'],
                    'is_published' => true,
                    'published_at' => now()->subDays(random_int(2, 20)),
                ]
            );
        }

        $articles = [
            ['category' => 'issues', 'title' => 'Keypad scene does nothing', 'body' => "1. Confirm the lighting processor is online and not in reboot loop.\n2. Check keypad LED power and network/link status.\n3. Verify the scene still exists in the programming software.\n4. Test the load at the dimmer/relay physically.\n5. Re-push the project and retest; document firmware versions."],
            ['category' => 'issues', 'title' => 'Cameras offline after Wi‑Fi change', 'body' => "Consumer router swaps often change subnets or DHCP. Confirm PoE switch power, camera static/DHCP leases, NVR reachability, and VLAN rules. Prefer wired cameras where possible. Rebuild Wi‑Fi coverage maps before blaming the camera brand."],
            ['category' => 'guides', 'title' => 'New-build rough-in checklist', 'body' => "Before drywall: mark keypad locations, AV drops, shade power, camera PoE runs, thermostat wires, and rack location with UPS circuit. Photo every wall plate. Leave pull strings. Coordinate with GC so low-voltage is not painted over."],
            ['category' => 'guides', 'title' => 'How to prepare for a design consult', 'body' => "List must-have rooms (kitchen, primary, theater, exterior). Note pain points (dark halls, dead Wi‑Fi, hard-to-use remotes). Share floor plans if available. Clear attic/crawl access. Lumenridge will propose a phased system map and budget bands."],
            ['category' => 'admin', 'title' => 'Admin ERP quick start', 'body' => "Login at /admin with admin@example.com / password.\n1. Add customers in CRM.\n2. Create a Project/Job with sq ft and quote.\n3. Schedule appointments for consult/install.\n4. Convert completed jobs to invoices and record payments.\n5. Use AI Studio for blog drafts and troubleshooting suggestions.\n6. Update company Settings for phone, WhatsApp, and tax rate."],
            ['category' => 'admin', 'title' => 'Roles: Admin, Manager, Staff', 'body' => "Admin: full ERP + settings + users.\nManager: jobs, inventory, invoices, scheduling.\nStaff: field-facing records and appointment updates.\nAssign roles on the Users resource."],
            ['category' => 'troubleshoot', 'title' => 'Job running over device estimate', 'body' => "Compare as-built device counts vs quote. Log extra keypads, cameras, or shade motors on job notes, create a change-order invoice line, and update inventory stock quantities."],
            ['category' => 'troubleshoot', 'title' => 'Chatbot giving demo answers only', 'body' => "Demo mode is expected without API keys. Add OPENAI_API_KEY or GEMINI_API_KEY to .env, then clear config cache. The public chatbot and AI Studio will prefer live models when keys are present."],
        ];
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    'title' => $article['title'],
                    'category' => $article['category'],
                    'body' => $article['body'],
                    'is_published' => true,
                ]
            );
        }
    }
}
