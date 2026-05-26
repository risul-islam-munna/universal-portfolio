# Portfolio — Open Source Universal Portfolio CMS

A fully self-hosted portfolio CMS built with **Laravel 13**, **Vue 3**, and **Filament v5**. Manage your entire portfolio — hero, skills, projects, blog, and business highlights — through a clean admin panel, with a fast Vue SPA on the frontend.

Built to be easily customized for any profile type: developer, designer, marketer, doctor, teacher, or any professional.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13, PHP 8.3 |
| Admin Panel | Filament v5 (Livewire + Alpine.js) |
| Frontend | Vue 3 (Composition API) + Pinia + Vue Router |
| Styling | Tailwind CSS v4, CSS custom properties |
| Database | SQLite (easily swappable to MySQL/PostgreSQL) |
| Build | Vite + laravel-vite-plugin |
| Storage | Local disk or Cloudflare R2 (configurable in admin) |

---

## Features

- **Filament Admin Panel** at `/admin` with full CRUD for all content
- **Vue 3 SPA** at `/` with smooth page transitions and typing animation
- **Multi-theme system** — switch color themes without page reload
- **Flexible Settings** — stored as JSON, extendable for any profile type
- **Cloudflare R2 Storage** — configurable from the admin panel (no `.env` edits needed)
- **Blog** with Markdown editor
- **Contact form** with inbox and read/unread tracking
- **REST API** at `/api/v1/` for all public data

---

## Requirements

- PHP 8.3+
- Composer
- Node.js 20+ and npm
- [Laravel Herd](https://herd.laravel.com/) (recommended) or any PHP server

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/your-portfolio.git
cd your-portfolio

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file and generate key
cp .env.example .env
php artisan key:generate

# 5. Create the SQLite database
touch database/database.sqlite

# 6. Run migrations and seed demo data
php artisan migrate --seed

# 7. Create the storage symlink
php artisan storage:link

# 8. Build frontend assets
npm run build

# 9. Create your admin user
php artisan tinker --execute "
    App\Models\User::create([
        'name' => 'Your Name',
        'email' => 'admin@example.com',
        'password' => bcrypt('your-secure-password'),
        'email_verified_at' => now(),
    ]);
"
```

Your portfolio is now available at `http://localhost:8000` (or your configured domain).
The admin panel is at `/admin`.

---

## Development

```bash
# Start the dev server with hot reload
composer run dev

# Or run separately:
php artisan serve
npm run dev
```

---

## Admin Panel

Visit `/admin` and log in with your admin credentials.

### Navigation

| Group | Section | Description |
|---|---|---|
| Portfolio Content | Hero Section | Name, bio, typing animation roles, profile photo, resume |
| Portfolio Content | About Section | Bio text, stats (years/projects/clients), profile photo |
| Portfolio Content | Skills | Name, category, proficiency %, display order |
| Portfolio Content | Services | Title, icon, description, featured flag |
| Portfolio Content | Projects | Title, slug, tech stack, URLs, gallery images |
| Portfolio Content | Experience | Company, role, dates, description |
| Portfolio Content | Education | Institution, degree, years |
| Portfolio Content | Testimonials | Client info, rating, active toggle |
| Portfolio Content | Blog Posts | Markdown editor, cover image, tags, publish date |
| Portfolio Content | Business Highlight | Business name, features list, screenshots |
| Appearance | Themes | Color pickers for primary, accent, background, text, etc. |
| Settings | General Settings | Site info, social links, storage configuration |
| Inbox | Contact Messages | View and manage contact form submissions |

### Dashboard

The dashboard shows live stats: total projects, skills count, published blog posts, and unread contact messages.

---

## Settings & Configuration

All settings are stored as a **JSON blob** in the database — no fixed columns. This makes it trivial to add new settings for future profile types (marketer, doctor, teacher) without any schema changes.

### Adding Custom Settings

To add a new setting:

1. Add the field to the `SettingsPage` form in `app/Filament/Pages/SettingsPage.php`
2. Access it anywhere in code with `Setting::getValue('your_key', 'default')`
3. The API at `/api/v1/settings` returns the entire JSON blob to the frontend

---

## Storage Configuration

By default, uploaded files are stored on the local disk (`storage/app/public`).

To switch to **Cloudflare R2**:

1. Log into the admin panel → Settings → Storage tab
2. Select **Cloudflare R2** as the driver
3. Enter your R2 credentials (Account ID, Access Key, Secret Key, Bucket, Public URL)
4. Save — the app will start using R2 immediately (no restart needed)

> The `StorageServiceProvider` reads these settings from the database at boot time and reconfigures Laravel's filesystem accordingly.

---

## Theming

Themes are stored in the `themes` table and define a set of CSS custom properties (colors). The active theme is applied at runtime by the Vue frontend — no page reload required.

### Available Themes (Demo)

| Theme | Primary | Accent |
|---|---|---|
| Dark Ocean | `#3b82f6` | `#06b6d4` |
| Dark Purple | `#8b5cf6` | `#ec4899` |
| Dark Emerald | `#10b981` | `#f59e0b` |

### Adding a New Theme

1. Go to admin → Appearance → Themes → New Theme
2. Pick a name and colors using the color pickers
3. Set **Active** to switch the live site to the new theme

---

## API Reference

All endpoints are public and read-only (except POST /contact).

Base URL: `/api/v1`

| Method | Endpoint | Description |
|---|---|---|
| GET | `/settings` | Site settings (JSON) |
| GET | `/hero` | Hero section data |
| GET | `/about` | About section data |
| GET | `/skills` | All skills, ordered |
| GET | `/services` | All services |
| GET | `/projects` | All projects |
| GET | `/projects/{slug}` | Single project |
| GET | `/experience` | Work experience |
| GET | `/education` | Education |
| GET | `/testimonials` | Active testimonials |
| GET | `/blog` | Published blog posts |
| GET | `/blog/{slug}` | Single blog post |
| GET | `/business-highlight` | Business section data |
| GET | `/active-theme` | Currently active theme |
| GET | `/themes` | All themes |
| POST | `/contact` | Submit contact form |

### Contact Form Payload

```json
{
  "name": "string (required)",
  "email": "email (required)",
  "subject": "string (optional)",
  "message": "string (required, max 5000)"
}
```

---

## Customizing for Your Profile Type

This portfolio is built to support any professional profile — not just developers.

### Adding a New Section

1. Create a migration: `php artisan make:migration create_portfolio_section_table`
2. Create a model: `php artisan make:model PortfolioSection`
3. Create a Filament resource: `php artisan make:filament-resource PortfolioSection`
4. Add an API endpoint in `app/Http/Controllers/Api/PortfolioController.php`
5. Register the route in `routes/api.php`
6. Add a Vue component in `resources/js/portfolio/components/sections/`

### Future Profile Types

The JSON-based settings system means you can add marketer-specific fields (campaign stats, ad platforms), doctor-specific fields (specializations, clinic hours), or teacher-specific fields (subjects, courses) — all without touching the database schema.

---

## Deployment

### Laravel Cloud (Recommended)

```bash
# Push to GitHub, then connect your repo at cloud.laravel.com
# Set environment variables in the Cloud dashboard
# Laravel Cloud handles zero-downtime deployments automatically
```

### Manual Deployment

```bash
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

---

## Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Commit your changes with a clear message
4. Push to your fork and open a Pull Request

Please follow the existing code style (PSR-12 via Laravel Pint).

---

## Developer Info

Built by **Md. Risul Islam Munna** — Full Stack Developer & SaaS Builder from Bangladesh.

- **GitHub**: [github.com/risul-islam-munna](https://github.com/risul-islam-munna)
- **LinkedIn**: [linkedin.com/in/risul-islam-munna](https://www.linkedin.com/in/risul-islam-munna/)
- **Facebook**: [facebook.com/munna.dev.bd](https://www.facebook.com/munna.dev.bd/)
- **Website**: [facebook.com/munna.dev.bd](https://www.facebook.com/munna.dev.bd/)

---

## License

MIT — free to use for personal and commercial projects.
# universal-portfolio
