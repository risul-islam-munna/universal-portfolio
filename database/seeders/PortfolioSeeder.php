<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\BlogPost;
use App\Models\BusinessHighlight;
use App\Models\Education;
use App\Models\Experience;
use App\Models\HeroSection;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdminUser();
        $this->seedSettings();
        $this->seedThemes();
        $this->seedHero();
        $this->seedAbout();
        $this->seedSkills();
        $this->seedServices();
        $this->seedProjects();
        $this->seedExperience();
        $this->seedEducation();
        $this->seedTestimonials();
        $this->seedBlog();
        $this->seedBusinessHighlight();
    }

    // ─── Settings ────────────────────────────────────────────────────────────────
    
    // Create default admin account with email '

    private function seedAdminUser(): void
    {
        $adminEmail = 'hello@munna.dev';
        $adminPassword = 'password';
        $adminUser = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => $adminEmail,
            'password' => Hash::make($adminPassword),
            'email_verified_at' => now(),
        ]);
    }
    
    // Each key is stored as its own row in the KV settings table under theme='default'.
    // firstOrCreate ensures existing user-edited values are never overwritten on re-seed.

    private function seedSettings(): void
    {
        $defaults = [
            // General
            'site_title' => 'Munna | Full Stack Developer',
            'tagline' => 'Full Stack Developer · DevOps Engineer · Entrepreneur. Building impactful digital products from Bangladesh.',
            'meta_description' => 'Md. Risul Islam Munna — Full Stack Developer, DevOps Engineer & Entrepreneur with 7+ years of experience. Founder of Bee Hook.',
            'contact_email' => 'hello@munna.dev',
            'phone' => '+880 1776-XXXXXX',
            'address' => 'Dhaka, Bangladesh',
            'google_analytics_id' => null,

            // Social — stored as a single JSON array of {name, url, svg_icon} objects
            'social_links' => json_encode([
                [
                    'name' => 'GitHub',
                    'url' => 'https://github.com/risul-islam-munna',
                    'svg_icon' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>',
                ],
                [
                    'name' => 'LinkedIn',
                    'url' => 'https://www.linkedin.com/in/risul-islam-munna/',
                    'svg_icon' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                ],
                [
                    'name' => 'WhatsApp',
                    'url' => '',
                    'svg_icon' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
                ],
                [
                    'name' => 'Telegram',
                    'url' => '',
                    'svg_icon' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
                ],
                [
                    'name' => 'Facebook',
                    'url' => 'https://www.facebook.com/munna.dev.bd/',
                    'svg_icon' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                ],
                [
                    'name' => 'X / Twitter',
                    'url' => '',
                    'svg_icon' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.261 5.632zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                ],
                [
                    'name' => 'YouTube',
                    'url' => '',
                    'svg_icon' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                ],
                [
                    'name' => 'Instagram',
                    'url' => '',
                    'svg_icon' => '<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
                ],
            ]),

            // Storage
            'storage_driver' => 'local',
            'r2_account_id' => null,
            'r2_access_key' => null,
            'r2_secret_key' => null,
            'r2_bucket' => null,
            'r2_public_url' => null,
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(
                ['theme' => 'default', 'key' => $key],
                ['value' => $value, 'status' => true],
            );
        }
    }

    // ─── Themes ──────────────────────────────────────────────────────────────────
    // component = the frontend registry key (resources/js/themes/registry.ts).
    // config    = colour overrides on top of the component package's defaults.

    private function seedThemes(): void
    {
        $themes = [
            [
                'name' => 'Dark Ocean',
                'slug' => 'dark-ocean',
                'component' => 'default',
                'is_active' => true,
                'config' => [
                    'primary' => '#3b82f6',
                    'secondary' => '#0f172a',
                    'accent' => '#06b6d4',
                    'bg' => '#0f172a',
                    'surface' => '#1e293b',
                    'text' => '#f1f5f9',
                    'muted' => '#94a3b8',
                    'border' => '#334155',
                ],
            ],
            [
                'name' => 'Dark Purple',
                'slug' => 'dark-purple',
                'component' => 'default',
                'is_active' => false,
                'config' => [
                    'primary' => '#8b5cf6',
                    'secondary' => '#0d0d1a',
                    'accent' => '#ec4899',
                    'bg' => '#0d0d1a',
                    'surface' => '#1a1a2e',
                    'text' => '#f8f9fa',
                    'muted' => '#9ca3af',
                    'border' => '#2d2d4a',
                ],
            ],
            [
                'name' => 'Dark Emerald',
                'slug' => 'dark-emerald',
                'component' => 'default',
                'is_active' => false,
                'config' => [
                    'primary' => '#10b981',
                    'secondary' => '#0a1628',
                    'accent' => '#f59e0b',
                    'bg' => '#0a1628',
                    'surface' => '#111827',
                    'text' => '#f9fafb',
                    'muted' => '#9ca3af',
                    'border' => '#1f2937',
                ],
            ],
            [
                'name' => 'Light Minimal',
                'slug' => 'light-minimal',
                'component' => 'default',
                'is_active' => false,
                'config' => [
                    'primary' => '#2563eb',
                    'secondary' => '#ffffff',
                    'accent' => '#0ea5e9',
                    'bg' => '#f8fafc',
                    'surface' => '#ffffff',
                    'text' => '#0f172a',
                    'muted' => '#64748b',
                    'border' => '#e2e8f0',
                ],
            ],
        ];

        foreach ($themes as $theme) {
            Theme::firstOrCreate(
                ['slug' => $theme['slug']],
                $theme,
            );
        }
    }

    // ─── Hero ─────────────────────────────────────────────────────────────────────

    private function seedHero(): void
    {
        HeroSection::firstOrCreate([], [
            'name' => 'Risul Islam Munna',
            'designation' => 'Full Stack Developer & Entrepreneur',
            'bio' => 'I craft scalable web & mobile applications with 7+ years of hands-on experience. Founder of Bee Hook — an e-commerce SaaS platform powering thousands of online businesses. Passionate about clean architecture, DevOps automation, and AI-powered solutions.',
            'cta_label' => 'Hire Me',
            'cta_link' => '#contact',
            'typing_roles' => [
                'Laravel Developer',
                'Vue.js Developer',
                'Flutter Developer',
                'DevOps Engineer',
                'SaaS Builder',
                'AI Automation Expert',
            ],
        ]);
    }

    // ─── About ────────────────────────────────────────────────────────────────────

    private function seedAbout(): void
    {
        AboutSection::firstOrCreate([], [
            'bio' => "Hi, I'm Munna — a Full Stack Developer, DevOps Engineer, and entrepreneur based in Dhaka, Bangladesh. With over 7 years of professional experience, I specialize in building production-grade Laravel backends, reactive Vue.js frontends, and cross-platform Flutter apps.\n\nI'm the founder of Bee Hook, a SaaS platform that automates e-commerce operations for online businesses across Bangladesh. I believe in writing clean, maintainable code and shipping products that users actually love.\n\nWhen I'm not coding, I'm exploring new technologies, mentoring developers, or working on open-source projects.",
            'years_experience' => 7,
            'projects_completed' => 150,
            'clients_served' => 80,
            'technologies_used' => 30,
        ]);
    }

    // ─── Skills ───────────────────────────────────────────────────────────────────

    private function seedSkills(): void
    {
        $skills = [
            // Backend
            ['name' => 'Laravel',              'category' => 'Backend',  'proficiency' => 95, 'display_order' => 1],
            ['name' => 'PHP',                  'category' => 'Backend',  'proficiency' => 92, 'display_order' => 2],
            ['name' => 'Node.js',              'category' => 'Backend',  'proficiency' => 72, 'display_order' => 3],
            ['name' => 'MySQL',                'category' => 'Backend',  'proficiency' => 90, 'display_order' => 4],
            ['name' => 'PostgreSQL',           'category' => 'Backend',  'proficiency' => 82, 'display_order' => 5],
            ['name' => 'Redis',                'category' => 'Backend',  'proficiency' => 80, 'display_order' => 6],
            // Frontend
            ['name' => 'Vue.js',               'category' => 'Frontend', 'proficiency' => 92, 'display_order' => 7],
            ['name' => 'React',                'category' => 'Frontend', 'proficiency' => 80, 'display_order' => 8],
            ['name' => 'TypeScript',           'category' => 'Frontend', 'proficiency' => 82, 'display_order' => 9],
            ['name' => 'Tailwind CSS',         'category' => 'Frontend', 'proficiency' => 95, 'display_order' => 10],
            // Mobile
            ['name' => 'Flutter',              'category' => 'Mobile',   'proficiency' => 88, 'display_order' => 11],
            ['name' => 'Dart',                 'category' => 'Mobile',   'proficiency' => 85, 'display_order' => 12],
            ['name' => 'Ionic',                'category' => 'Mobile',   'proficiency' => 75, 'display_order' => 13],
            // DevOps
            ['name' => 'Docker',               'category' => 'DevOps',   'proficiency' => 90, 'display_order' => 14],
            ['name' => 'Linux / Server',       'category' => 'DevOps',   'proficiency' => 88, 'display_order' => 15],
            ['name' => 'Nginx',                'category' => 'DevOps',   'proficiency' => 85, 'display_order' => 16],
            ['name' => 'CI/CD (GitHub Actions)', 'category' => 'DevOps',  'proficiency' => 82, 'display_order' => 17],
            // Cloud
            ['name' => 'AWS (EC2, S3, RDS)',   'category' => 'Cloud',    'proficiency' => 85, 'display_order' => 18],
            ['name' => 'Cloudflare',           'category' => 'Cloud',    'proficiency' => 80, 'display_order' => 19],
            // AI
            ['name' => 'OpenAI / GPT',         'category' => 'AI',       'proficiency' => 75, 'display_order' => 20],
            // ['name' => 'LangChain',            'category' => 'AI',       'proficiency' => 65, 'display_order' => 21],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }
    }

    // ─── Services ─────────────────────────────────────────────────────────────────

    private function seedServices(): void
    {
        $services = [
            [
                'title' => 'Full Stack Web Development',
                'icon' => '🌐',
                'description' => 'End-to-end web application development using Laravel + Vue.js or React. From database design and REST API to production deployment — I handle the full lifecycle.',
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'title' => 'Mobile App Development',
                'icon' => '📱',
                'description' => 'Cross-platform mobile apps with Flutter (iOS & Android) or Ionic. Native-like performance with a single codebase, published to both stores.',
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'title' => 'DevOps & Server Management',
                'icon' => '⚙️',
                'description' => 'Docker containerization, CI/CD pipelines with GitHub Actions, AWS/VPS infrastructure setup, Nginx configuration, SSL, and 24/7 monitoring.',
                'is_featured' => true,
                'display_order' => 3,
            ],
            [
                'title' => 'SaaS Product Development',
                'icon' => '🚀',
                'description' => 'Full-cycle SaaS product development — from MVP to a production-ready multi-tenant application with subscription billing, role management, and analytics.',
                'is_featured' => false,
                'display_order' => 4,
            ],
            [
                'title' => 'API Design & Integration',
                'icon' => '🔗',
                'description' => 'RESTful API design, third-party integrations (payment gateways, Facebook Graph API, Google APIs), webhook systems, and OpenAPI documentation.',
                'is_featured' => false,
                'display_order' => 5,
            ],
            [
                'title' => 'AI & Automation',
                'icon' => '🤖',
                'description' => 'Integrate AI capabilities into your product using OpenAI GPT, build automation workflows, chatbots, content generation pipelines, and data processing systems.',
                'is_featured' => false,
                'display_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['title' => $service['title']], $service);
        }
    }

    // ─── Projects ─────────────────────────────────────────────────────────────────

    private function seedProjects(): void
    {
        $projects = [
            [
                'title' => 'Bee Hook — E-commerce SaaS',
                'slug' => 'bee-hook-ecommerce-saas',
                'description' => "Bee Hook is a comprehensive e-commerce SaaS platform built to automate and scale online business operations in Bangladesh.\n\n**Key Features:**\n- Facebook shop automation — auto-respond to comments, manage orders from Messenger\n- Multi-store management from a single dashboard\n- Built-in marketing tools: Facebook Pixel + Google Tag Manager\n- Real-time inventory tracking with low-stock alerts\n- Integrated payment gateways including local Bangladeshi methods (bKash, Nagad)\n- Flutter-powered mobile app for sellers (iOS & Android)\n- Subscription billing with Stripe\n- Multi-tenant architecture supporting 1000+ businesses",
                'tech_stack' => ['Laravel', 'Vue.js', 'Flutter', 'MySQL', 'Redis', 'Docker', 'AWS', 'Pusher'],
                'project_url' => 'https://beehook.app',
                'github_url' => null,
                'category' => 'SaaS',
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'title' => 'Multi-tenant ERP System',
                'slug' => 'multi-tenant-erp-system',
                'description' => "A full-featured ERP system with multi-tenant architecture designed for medium-sized businesses.\n\n**Modules:**\n- HR & Payroll management\n- Inventory & warehouse management\n- Accounting with double-entry bookkeeping\n- CRM and customer management\n- Reporting and analytics dashboard\n- Role-based access control\n\n**Deployed on AWS** with auto-scaling, RDS PostgreSQL, ElastiCache Redis, and CloudFront CDN.",
                'tech_stack' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Redis', 'AWS', 'Docker'],
                'project_url' => null,
                'github_url' => null,
                'category' => 'Enterprise',
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'title' => 'Real-time Chat & Collaboration',
                'slug' => 'realtime-chat-collaboration',
                'description' => "A Slack-like real-time communication platform built for a UK-based digital agency.\n\n**Features:**\n- Channels, direct messages, and threads\n- File sharing with preview\n- Video/audio calls (WebRTC)\n- Message search and pinning\n- Bot integrations\n- Mobile-responsive PWA\n\n**Implemented** with Laravel WebSockets, Vue.js, and Redis pub/sub for real-time message delivery.",
                'tech_stack' => ['Laravel', 'Vue.js', 'WebSockets', 'MySQL', 'Redis', 'WebRTC'],
                'project_url' => null,
                'github_url' => null,
                'category' => 'Communication',
                'is_featured' => false,
                'display_order' => 3,
            ],
            [
                'title' => 'Flutter Delivery App',
                'slug' => 'flutter-delivery-app',
                'description' => "A full-featured food & grocery delivery app with three panels: Customer, Delivery Boy, and Restaurant/Admin.\n\n**Customer app features:**\n- Real-time order tracking on a map\n- Multiple payment methods\n- Order history and reorder\n- Push notifications\n\n**Built with** Flutter (iOS + Android), Laravel REST API, Google Maps SDK, Firebase for push notifications.",
                'tech_stack' => ['Flutter', 'Laravel', 'MySQL', 'Google Maps', 'Firebase', 'Stripe'],
                'project_url' => null,
                'github_url' => null,
                'category' => 'Mobile',
                'is_featured' => false,
                'display_order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(['slug' => $project['slug']], $project);
        }
    }

    // ─── Experience ───────────────────────────────────────────────────────────────

    private function seedExperience(): void
    {
        $experiences = [
            [
                'company_name' => 'Bee Hook',
                'role' => 'Founder & Lead Developer',
                'start_date' => '2021-01-01',
                'end_date' => null,
                'is_current' => true,
                'description' => "Founded Bee Hook from zero — a SaaS platform that automates e-commerce for online businesses in Bangladesh. Responsible for the full product lifecycle: architecture, development, infrastructure, hiring, and growth.\n\n• Built the entire platform solo for the first 2 years\n• Grew to 1000+ active businesses on the platform\n• Led a team of 5 developers\n• Managed AWS infrastructure serving 50k+ requests/day",
                'display_order' => 1,
            ],
            [
                'company_name' => 'Freelance / Upwork',
                'role' => 'Full Stack Developer',
                'start_date' => '2018-06-01',
                'end_date' => '2021-12-31',
                'is_current' => false,
                'description' => "Delivered 50+ successful projects for clients across USA, UK, Australia, and Canada on Upwork and direct contracts.\n\n• Built multi-tenant SaaS platforms, e-commerce stores, and REST APIs\n• Specialized in Laravel backends and Vue.js frontends\n• Developed Flutter apps published on App Store and Google Play\n• Maintained a 5-star rating with 100% Job Success Score",
                'display_order' => 2,
            ],
            [
                'company_name' => 'Local Software Company',
                'role' => 'Junior PHP Developer',
                'start_date' => '2017-01-01',
                'end_date' => '2018-05-31',
                'is_current' => false,
                'description' => "Started my professional career building web applications for local businesses in Bangladesh.\n\n• Developed e-commerce sites, school management systems, and business portals\n• Learned Laravel, MySQL, and jQuery in a production environment\n• Collaborated with a small team of 6 developers",
                'display_order' => 3,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::firstOrCreate(
                ['company_name' => $exp['company_name'], 'role' => $exp['role']],
                $exp,
            );
        }
    }

    // ─── Education ────────────────────────────────────────────────────────────────

    private function seedEducation(): void
    {
        Education::firstOrCreate(
            ['institution_name' => 'National University, Bangladesh'],
            [
                'institution_name' => 'National University, Bangladesh',
                'degree' => 'Bachelor of Science',
                'field_of_study' => 'Computer Science & Engineering',
                'start_year' => 2015,
                'end_year' => 2019,
                'description' => 'Focused on data structures, algorithms, software engineering, database systems, and computer networks.',
                'display_order' => 1,
            ],
        );
    }

    // ─── Testimonials ─────────────────────────────────────────────────────────────

    private function seedTestimonials(): void
    {
        $testimonials = [
            [
                'client_name' => 'Sarah Johnson',
                'designation' => 'CEO',
                'company' => 'TechVentures Inc.',
                'message' => 'Munna built an outstanding e-commerce platform for us. His technical expertise, attention to detail, and proactive communication made the whole process smooth. Delivered ahead of schedule!',
                'rating' => 5,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'client_name' => 'Ahmed Al-Rashid',
                'designation' => 'CTO',
                'company' => 'StartupHub Dubai',
                'message' => 'We hired Munna for a complex multi-tenant SaaS backend. He grasped our requirements quickly and delivered a rock-solid Laravel API. Excellent communication throughout. Highly recommended!',
                'rating' => 5,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'client_name' => 'Emma Williams',
                'designation' => 'Product Manager',
                'company' => 'Digital Agency UK',
                'message' => 'The Flutter app Munna built runs beautifully on both iOS and Android. His DevOps setup also cut our server costs by 40%. A rare developer who understands both product and infrastructure.',
                'rating' => 5,
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'client_name' => 'James Mitchell',
                'designation' => 'Founder',
                'company' => 'E-commerce Startup, Australia',
                'message' => "Munna is one of the best developers I've worked with on Upwork. He built a full-stack marketplace app from scratch, including real-time features, payment integration, and admin dashboard. 10/10.",
                'rating' => 5,
                'is_active' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['client_name' => $t['client_name']], $t);
        }
    }

    // ─── Blog ─────────────────────────────────────────────────────────────────────

    private function seedBlog(): void
    {
        $posts = [
            [
                'title' => 'Building a Multi-tenant SaaS with Laravel: Lessons from Bee Hook',
                'slug' => 'building-multi-tenant-saas-laravel',
                'content' => "# Building a Multi-tenant SaaS with Laravel\n\nAfter 3 years running Bee Hook, I've learned a lot about building multi-tenant applications at scale. Here are the key architectural decisions that made the difference.\n\n## Choosing the Tenancy Model\n\nFor Bee Hook, I chose **database-per-tenant** approach early on. It gives strong data isolation, makes backups straightforward, and allows tenant-specific scaling. The trade-off is more complex migrations and higher operational overhead.\n\n## The Package: Stancl/Tenancy\n\nI use [stancl/tenancy](https://tenancyforlaravel.com/) for Laravel. It handles:\n\n- Tenant identification (by domain or subdomain)\n- Database switching\n- Storage isolation\n- Queue isolation\n\n```php\n// Tenant model\nclass Tenant extends Model implements TenantWithDatabase\n{\n    use HasDatabase, HasDomains;\n}\n```\n\n## Subscription Billing\n\nI integrated **Stripe** with Laravel Cashier for subscription management. Each tenant has a Stripe customer ID and a subscription tied to a plan.\n\n## Key Lessons\n\n1. **Design for isolation from day one** — retrofitting multi-tenancy is painful\n2. **Use event-based architecture** — decouples tenant operations\n3. **Monitor per-tenant** — use tags in your observability stack\n4. **Cache tenant resolution** — don't hit the DB on every request",
                'tags' => ['Laravel', 'SaaS', 'Multi-tenancy', 'PHP'],
                'is_published' => true,
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => 'Flutter vs React Native in 2024: My Real-World Take After 3 Years',
                'slug' => 'flutter-vs-react-native-2024',
                'content' => "# Flutter vs React Native: My Experience After 3 Years\n\nI've built production apps with both frameworks. Here's my honest comparison.\n\n## Performance\n\n**Flutter wins.** Dart compiles to native ARM code and renders using its own engine (Skia/Impeller). There's no JavaScript bridge bottleneck. Complex animations and heavy list views perform noticeably better in Flutter.\n\n## Developer Experience\n\nBoth are great, but Flutter has the edge:\n\n- **Hot reload** is faster and more reliable\n- **Dart** is strongly typed and feels similar to Java/Kotlin\n- **Widget tree** is verbose but predictable\n- **pub.dev** has grown significantly — most packages you need exist\n\n## When I Choose Flutter\n\n- High-performance UIs (animations, games, charts)\n- B2C apps where UI consistency matters\n- Teams coming from Java/Kotlin/Swift backgrounds\n\n## My Verdict\n\nFor new projects in 2024, I default to **Flutter**. The performance, DX, and growing ecosystem make it the better long-term bet for most mobile apps.",
                'tags' => ['Flutter', 'React Native', 'Mobile', 'Dart'],
                'is_published' => true,
                'published_at' => now()->subMonth(),
            ],
            [
                'title' => 'Docker + GitHub Actions: My CI/CD Setup for Every Project',
                'slug' => 'docker-github-actions-cicd-setup',
                'content' => "# My Docker + GitHub Actions CI/CD Setup\n\nEvery project I build now ships with a standardized CI/CD pipeline on day one. Here's the exact setup I use.\n\n## Project Structure\n\n```\n├── docker/\n│   ├── nginx/default.conf\n│   └── php/Dockerfile\n├── docker-compose.yml\n├── docker-compose.prod.yml\n└── .github/workflows/deploy.yml\n```\n\n## GitHub Actions Workflow\n\n```yaml\nname: Deploy\non:\n  push:\n    branches: [main]\n\njobs:\n  deploy:\n    runs-on: ubuntu-latest\n    steps:\n      - uses: actions/checkout@v4\n      - name: Deploy to server\n        uses: appleboy/ssh-action@v1\n        with:\n          host: \${{ secrets.SERVER_HOST }}\n          key: \${{ secrets.SSH_KEY }}\n          script: |\n            cd /var/www/app\n            git pull origin main\n            docker compose -f docker-compose.prod.yml up -d --build\n            docker compose exec app php artisan migrate --force\n            docker compose exec app php artisan config:cache\n```\n\n## Zero-Downtime Deploys\n\nFor zero-downtime, I use **Nginx upstream switching** with two containers (blue/green). The GitHub Action builds the new container, health-checks it, then switches Nginx upstream.",
                'tags' => ['DevOps', 'Docker', 'GitHub Actions', 'CI/CD', 'Laravel'],
                'is_published' => true,
                'published_at' => now()->subWeeks(2),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::firstOrCreate(['slug' => $post['slug']], $post);
        }
    }

    // ─── Business Highlight ───────────────────────────────────────────────────────

    private function seedBusinessHighlight(): void
    {
        BusinessHighlight::firstOrCreate([], [
            'name' => 'Bee Hook',
            'tagline' => 'Automate Your Online Business',
            'description' => 'Bee Hook is a powerful e-commerce SaaS platform designed to streamline and automate online business operations. Manage your Facebook shop, process orders, track inventory, run marketing campaigns, and grow your business — all from one dashboard. Trusted by 1000+ businesses in Bangladesh.',
            'website_url' => 'https://beehook.app',
            'app_store_link' => null,
            'play_store_link' => null,
            'features' => [
                ['title' => 'Facebook Shop Automation',  'description' => 'Auto-respond to comments, process Messenger orders, and manage your Facebook shop without manual effort.'],
                ['title' => 'Multi-store Dashboard',     'description' => 'Manage multiple online stores from a single, unified dashboard with real-time sync.'],
                ['title' => 'Built-in Analytics',        'description' => 'Facebook Pixel, Google Tag Manager, and custom analytics baked in — no setup required.'],
                ['title' => 'Seller Mobile App',         'description' => 'Flutter-powered iOS and Android app for sellers to manage orders and inventory on the go.'],
                ['title' => 'Inventory Management',      'description' => 'Real-time stock tracking, low-stock alerts, and automated reorder notifications.'],
                ['title' => 'Local Payment Integration', 'description' => 'bKash, Nagad, Rocket, and card payments supported out of the box for Bangladeshi businesses.'],
            ],
        ]);
    }
}
