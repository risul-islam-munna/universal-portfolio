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

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Settings ────────────────────────────────────────────────────────────
        Setting::firstOrCreate([], [
            'data' => [
                'site_title' => 'Munna | Full Stack Developer',
                'tagline' => 'Building scalable products that make a difference.',
                'meta_description' => 'Md. Risul Islam Munna — Full Stack Developer, DevOps Engineer & Entrepreneur with 7 years of experience. Founder of Bee Hook.',
                'contact_email' => 'hello@munna.dev',
                'phone' => '+880 1776-XXXXXX',
                'address' => 'Dhaka, Bangladesh',
                'github_url' => 'https://github.com/risul-islam-munna',
                'linkedin_url' => 'https://www.linkedin.com/in/risul-islam-munna/',
                'facebook_url' => 'https://www.facebook.com/munna.dev.bd/',
                'twitter_url' => null,
                'youtube_url' => null,
                'instagram_url' => null,
                'google_analytics_id' => null,
                'storage_driver' => 'local',
                'r2_account_id' => null,
                'r2_access_key' => null,
                'r2_secret_key' => null,
                'r2_bucket' => null,
                'r2_public_url' => null,
            ],
        ]);

        // ─── Hero Section ─────────────────────────────────────────────────────────
        HeroSection::firstOrCreate([], [
            'name' => 'Md. Risul Islam Munna',
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

        // ─── About Section ────────────────────────────────────────────────────────
        AboutSection::firstOrCreate([], [
            'bio' => "Hi, I'm Munna — a Full Stack Developer, DevOps Engineer, and entrepreneur based in Dhaka, Bangladesh. With over 7 years of professional experience, I specialize in building production-grade Laravel backends, reactive Vue.js frontends, and cross-platform Flutter apps.\n\nI'm the founder of Bee Hook, a SaaS platform that automates e-commerce operations for online businesses across Bangladesh. I believe in writing clean, maintainable code and shipping products that users actually love.\n\nWhen I'm not coding, I'm exploring new technologies, mentoring developers, or working on open-source projects.",
            'years_experience' => 7,
            'projects_completed' => 150,
            'clients_served' => 80,
            'technologies_used' => 30,
        ]);

        // ─── Skills ───────────────────────────────────────────────────────────────
        $skills = [
            // Backend
            ['name' => 'Laravel', 'category' => 'Backend', 'proficiency' => 95, 'display_order' => 1],
            ['name' => 'PHP', 'category' => 'Backend', 'proficiency' => 92, 'display_order' => 2],
            ['name' => 'Node.js', 'category' => 'Backend', 'proficiency' => 72, 'display_order' => 3],
            ['name' => 'MySQL', 'category' => 'Backend', 'proficiency' => 90, 'display_order' => 4],
            ['name' => 'PostgreSQL', 'category' => 'Backend', 'proficiency' => 82, 'display_order' => 5],
            ['name' => 'Redis', 'category' => 'Backend', 'proficiency' => 80, 'display_order' => 6],
            // Frontend
            ['name' => 'Vue.js', 'category' => 'Frontend', 'proficiency' => 92, 'display_order' => 7],
            ['name' => 'React', 'category' => 'Frontend', 'proficiency' => 80, 'display_order' => 8],
            ['name' => 'TypeScript', 'category' => 'Frontend', 'proficiency' => 82, 'display_order' => 9],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'proficiency' => 95, 'display_order' => 10],
            // Mobile
            ['name' => 'Flutter', 'category' => 'Mobile', 'proficiency' => 88, 'display_order' => 11],
            ['name' => 'Dart', 'category' => 'Mobile', 'proficiency' => 85, 'display_order' => 12],
            ['name' => 'Ionic', 'category' => 'Mobile', 'proficiency' => 75, 'display_order' => 13],
            // DevOps & Cloud
            ['name' => 'Docker', 'category' => 'DevOps', 'proficiency' => 90, 'display_order' => 14],
            ['name' => 'Linux / Server', 'category' => 'DevOps', 'proficiency' => 88, 'display_order' => 15],
            ['name' => 'Nginx', 'category' => 'DevOps', 'proficiency' => 85, 'display_order' => 16],
            ['name' => 'CI/CD (GitHub Actions)', 'category' => 'DevOps', 'proficiency' => 82, 'display_order' => 17],
            ['name' => 'AWS (EC2, S3, RDS)', 'category' => 'Cloud', 'proficiency' => 85, 'display_order' => 18],
            ['name' => 'Cloudflare', 'category' => 'Cloud', 'proficiency' => 80, 'display_order' => 19],
            // AI
            ['name' => 'OpenAI / GPT', 'category' => 'AI', 'proficiency' => 75, 'display_order' => 20],
            ['name' => 'LangChain', 'category' => 'AI', 'proficiency' => 65, 'display_order' => 21],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }

        // ─── Services ─────────────────────────────────────────────────────────────
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

        // ─── Projects ─────────────────────────────────────────────────────────────
        $projects = [
            [
                'title' => 'Bee Hook — E-commerce SaaS',
                'slug' => 'bee-hook-ecommerce-saas',
                'description' => "Bee Hook is a comprehensive e-commerce SaaS platform built to automate and scale online business operations in Bangladesh.\n\n**Key Features:**\n- Facebook shop automation — auto-respond to comments, manage orders from Messenger\n- Multi-store management from a single dashboard\n- Built-in marketing tools: Facebook Pixel + Google Tag Manager\n- Real-time inventory tracking with low-stock alerts\n- Integrated payment gateways including local Bangladeshi methods (bKash, Nagad)\n- Flutter-powered mobile app for sellers (iOS & Android)\n- Subscription billing with Stripe\n- Multi-tenant architecture supporting 1000+ businesses\n\n**Tech Stack:** Laravel, Vue.js, Flutter, MySQL, Redis, Docker, AWS, Pusher",
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

        // ─── Experience ───────────────────────────────────────────────────────────
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
                'description' => "Delivered 50+ successful projects for clients across USA, UK, Australia, and Canada on Upwork and direct contracts.\n\n• Built multi-tenant SaaS platforms, e-commerce stores, and REST APIs\n• Specialized in Laravel backends and Vue.js frontends\n• Developed Flutter apps published on App Store and Google Play\n• Maintained a 5-star rating on Upwork with 100% Job Success Score",
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
            Experience::firstOrCreate(['company_name' => $exp['company_name'], 'role' => $exp['role']], $exp);
        }

        // ─── Education ────────────────────────────────────────────────────────────
        Education::firstOrCreate(['institution_name' => 'National University, Bangladesh'], [
            'institution_name' => 'National University, Bangladesh',
            'degree' => 'Bachelor of Science',
            'field_of_study' => 'Computer Science & Engineering',
            'start_year' => 2015,
            'end_year' => 2019,
            'description' => 'Focused on data structures, algorithms, software engineering, database systems, and computer networks.',
            'display_order' => 1,
        ]);

        // ─── Testimonials ─────────────────────────────────────────────────────────
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
                'message' => 'Munna is one of the best developers I\'ve worked with on Upwork. He built a full-stack marketplace app from scratch, including real-time features, payment integration, and admin dashboard. 10/10.',
                'rating' => 5,
                'is_active' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['client_name' => $t['client_name']], $t);
        }

        // ─── Blog Posts ───────────────────────────────────────────────────────────
        $posts = [
            [
                'title' => 'Building a Multi-tenant SaaS with Laravel: Lessons from Bee Hook',
                'slug' => 'building-multi-tenant-saas-laravel',
                'content' => "# Building a Multi-tenant SaaS with Laravel\n\nAfter 3 years running Bee Hook, I've learned a lot about building multi-tenant applications at scale. Here are the key architectural decisions that made the difference.\n\n## Choosing the Tenancy Model\n\nFor Bee Hook, I chose **database-per-tenant** approach early on. It gives strong data isolation, makes backups straightforward, and allows tenant-specific scaling. The trade-off is more complex migrations and higher operational overhead.\n\n## The Package: Stancl/Tenancy\n\nI use [stancl/tenancy](https://tenancyforlaravel.com/) for Laravel. It handles:\n\n- Tenant identification (by domain or subdomain)\n- Database switching\n- Storage isolation\n- Queue isolation\n\n```php\n// Tenant model\nclass Tenant extends Model implements TenantWithDatabase\n{\n    use HasDatabase, HasDomains;\n}\n```\n\n## Subscription Billing\n\nI integrated **Stripe** with Laravel Cashier for subscription management. Each tenant has a Stripe customer ID and a subscription tied to a plan.\n\n## Key Lessons\n\n1. **Design for isolation from day one** — retrofitting multi-tenancy is painful\n2. **Use event-based architecture** — decouples tenant operations\n3. **Monitor per-tenant** — use tags in your observability stack\n4. **Cache tenant resolution** — don't hit the DB on every request\n\nThe full architecture took 6 months to stabilize, but it's now serving 1000+ tenants reliably.",
                'tags' => ['Laravel', 'SaaS', 'Multi-tenancy', 'PHP'],
                'is_published' => true,
                'published_at' => now()->subMonths(2),
            ],
            [
                'title' => 'Flutter vs React Native in 2024: My Real-World Take After 3 Years',
                'slug' => 'flutter-vs-react-native-2024',
                'content' => "# Flutter vs React Native: My Experience After 3 Years\n\nI've built production apps with both frameworks. Here's my honest comparison.\n\n## Performance\n\n**Flutter wins.** Dart compiles to native ARM code and renders using its own engine (Skia/Impeller). There's no JavaScript bridge bottleneck. Complex animations and heavy list views perform noticeably better in Flutter.\n\n## Developer Experience\n\nBoth are great, but Flutter has the edge:\n\n- **Hot reload** is faster and more reliable\n- **Dart** is strongly typed and feels similar to Java/Kotlin\n- **Widget tree** is verbose but predictable\n- **pub.dev** has grown significantly — most packages you need exist\n\n## Code Sharing\n\nFlutter shares ~95% of code between iOS and Android (and web, desktop with some work). React Native is similar but needs more platform-specific bridges for certain native features.\n\n## When I Choose Flutter\n\n- High-performance UIs (animations, games, charts)\n- B2C apps where UI consistency matters\n- Teams coming from Java/Kotlin/Swift backgrounds\n\n## When I'd Use React Native\n\n- Team is already strong in React/JavaScript\n- Web + Mobile code sharing is a priority (Expo)\n- More niche native integrations needed\n\n## My Verdict\n\nFor new projects in 2024, I default to **Flutter**. The performance, DX, and growing ecosystem make it the better long-term bet for most mobile apps.",
                'tags' => ['Flutter', 'React Native', 'Mobile', 'Dart'],
                'is_published' => true,
                'published_at' => now()->subMonth(),
            ],
            [
                'title' => 'Docker + GitHub Actions: My CI/CD Setup for Every Project',
                'slug' => 'docker-github-actions-cicd-setup',
                'content' => "# My Docker + GitHub Actions CI/CD Setup\n\nEvery project I build now ships with a standardized CI/CD pipeline on day one. Here's the exact setup I use.\n\n## Project Structure\n\n```\n├── docker/\n│   ├── nginx/\n│   │   └── default.conf\n│   └── php/\n│       └── Dockerfile\n├── docker-compose.yml\n├── docker-compose.prod.yml\n└── .github/\n    └── workflows/\n        └── deploy.yml\n```\n\n## The Dockerfile (PHP-FPM)\n\n```dockerfile\nFROM php:8.3-fpm-alpine\n\nRUN apk add --no-cache \\\n    postgresql-dev \\\n    && docker-php-ext-install pdo_pgsql opcache\n\nCOPY --from=composer:2 /usr/bin/composer /usr/bin/composer\n\nWORKDIR /var/www/html\nCOPY . .\n\nRUN composer install --no-dev --optimize-autoloader\n```\n\n## GitHub Actions Workflow\n\n```yaml\nname: Deploy\non:\n  push:\n    branches: [main]\n\njobs:\n  deploy:\n    runs-on: ubuntu-latest\n    steps:\n      - uses: actions/checkout@v4\n      - name: Deploy to server\n        uses: appleboy/ssh-action@v1\n        with:\n          host: \${{ secrets.SERVER_HOST }}\n          key: \${{ secrets.SSH_KEY }}\n          script: |\n            cd /var/www/app\n            git pull origin main\n            docker compose -f docker-compose.prod.yml up -d --build\n            docker compose exec app php artisan migrate --force\n            docker compose exec app php artisan config:cache\n```\n\n## Zero-Downtime Deploys\n\nFor zero-downtime, I use **Nginx upstream switching** with two containers (blue/green). The GitHub Action builds the new container, health-checks it, then switches Nginx upstream.\n\nThis setup has served me well across 20+ client projects and all of Bee Hook's infrastructure.",
                'tags' => ['DevOps', 'Docker', 'GitHub Actions', 'CI/CD', 'Laravel'],
                'is_published' => true,
                'published_at' => now()->subWeeks(2),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::firstOrCreate(['slug' => $post['slug']], $post);
        }

        // ─── Business Highlight ───────────────────────────────────────────────────
        BusinessHighlight::firstOrCreate([], [
            'name' => 'Bee Hook',
            'tagline' => 'Automate Your Online Business',
            'description' => 'Bee Hook is a powerful e-commerce SaaS platform designed to streamline and automate online business operations. Manage your Facebook shop, process orders, track inventory, run marketing campaigns, and grow your business — all from one dashboard. Trusted by 1000+ businesses in Bangladesh.',
            'website_url' => 'https://beehook.app',
            'app_store_link' => null,
            'play_store_link' => null,
            'features' => [
                ['title' => 'Facebook Shop Automation', 'description' => 'Auto-respond to comments, process Messenger orders, and manage your Facebook shop without manual effort.'],
                ['title' => 'Multi-store Dashboard', 'description' => 'Manage multiple online stores from a single, unified dashboard with real-time sync.'],
                ['title' => 'Built-in Analytics', 'description' => 'Facebook Pixel, Google Tag Manager, and custom analytics baked in — no setup required.'],
                ['title' => 'Seller Mobile App', 'description' => 'Flutter-powered iOS and Android app for sellers to manage orders and inventory on the go.'],
                ['title' => 'Inventory Management', 'description' => 'Real-time stock tracking, low-stock alerts, and automated reorder notifications.'],
                ['title' => 'Local Payment Integration', 'description' => 'bKash, Nagad, Rocket, and card payments supported out of the box for Bangladeshi businesses.'],
            ],
        ]);

        // ─── Themes ───────────────────────────────────────────────────────────────
        Theme::firstOrCreate(['slug' => 'dark-ocean'], [
            'name' => 'Dark Ocean',
            'slug' => 'dark-ocean',
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
        ]);

        Theme::firstOrCreate(['slug' => 'dark-purple'], [
            'name' => 'Dark Purple',
            'slug' => 'dark-purple',
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
        ]);

        Theme::firstOrCreate(['slug' => 'dark-emerald'], [
            'name' => 'Dark Emerald',
            'slug' => 'dark-emerald',
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
        ]);

        Theme::firstOrCreate(['slug' => 'light-minimal'], [
            'name' => 'Light Minimal',
            'slug' => 'light-minimal',
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
        ]);
    }
}
