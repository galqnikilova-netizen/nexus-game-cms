# NEXUS Game CMS

Modern self-hosted gaming community CMS built on Laravel 12.

## Neo3 exact-theme migration

The uploaded Neo3 reference archive is the visual source of truth for the project. The migration is intentionally delivered in stages so every public and administrative screen retains the same component structure, spacing, breakpoints and responsive behavior.

### Stage 1 — public shell and homepage

- original Neo3 global CSS and page-module CSS integrated locally
- Neo3 sidebar structure and collapse behavior
- Neo3 navbar, player search, balance/language controls and Steam login button
- mobile tabbar and footer structure
- homepage component families: activity feed, mode cards, filters, server cards, banners, statistics and reward feed
- NEXUS branding and Bulgarian content mapped onto the Neo3 component system
- no bundled third-party font files; safe system fallbacks are used

### Stage 2 — leaderboard and player profile

- leaderboard rebuilt from the uploaded `leaderboard.html` structure
- original top-three medal presentation and leaderboard module class system
- sticky information/filter card, server filter, sorting and online-only filtering
- clickable player rows with Steam-ID profile resolution
- Neo3 player profile shell with overview, matches, weapons and achievements tabs
- responsive table and mobile profile navigation

### Stage 3 — store and checkout presentation

- store rebuilt from the uploaded `store.html` class structure
- Neo3 product cards, period selector, benefits list, category/server filters and price sorting
- client-side basket with totals, Steam-ID field and checkout modal
- responsive two-column/tablet and single-column/mobile presentation
- real payment gateway submission is intentionally deferred to the backend integration stage

### Following stages

1. Punishments and CSBans views
2. Skinchanger
3. FAQ, rules and tickets
4. Authentication and account area
5. Administration and installer/update system

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

`NEXUS_NEO3_EXACT_STAGE3`
