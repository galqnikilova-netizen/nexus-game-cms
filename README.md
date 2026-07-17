# NEXUS Game CMS

Modern self-hosted gaming community CMS built on Laravel 12.

## Neo3 exact-theme migration

The uploaded Neo3 reference archive is the visual source of truth for the project. The migration is intentionally delivered in stages so every public and administrative screen can retain the same component structure, spacing, breakpoints and responsive behavior.

### Stage 1 — exact public shell and homepage

- original Neo3 global CSS and page-module CSS integrated locally
- exact Neo3 sidebar structure and collapse behavior
- exact Neo3 navbar, player search, balance/language controls and Steam login button
- exact mobile tabbar and footer structure
- exact homepage component families: extended activity feed, mode cards, filters, server cards, social banners, slider, donor panel, statistics and reward feed
- NEXUS branding and Bulgarian content mapped onto the original component system
- no bundled third-party font files; safe system fallbacks are used

### Following stages

1. Leaderboard and player profile
2. Store and payment flows
3. Punishments and CSBans views
4. Skinchanger
5. FAQ, rules and tickets
6. Authentication and account area
7. Administration and installer/update system

## Requirements

- PHP 8.2+
- Composer 2
- MySQL 8 / MariaDB 10.6+ or SQLite for local preview

## Install

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Open `http://127.0.0.1:8000`.

## Current baseline

`NEXUS_NEO3_EXACT_STAGE1`
