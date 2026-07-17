# NEXUS Game CMS

Modern self-hosted gaming community CMS built on Laravel 12, with a complete dark responsive UI inspired by the uploaded Neo3 reference.

## Implemented foundation

- Laravel 12 application skeleton
- Responsive sidebar, mobile navigation and reusable design system
- Public pages: Home, Leaderboard, Store, Skinchanger, Punishments, FAQ, Rules, Tickets and Player profile
- Admin dashboard foundation
- Demo database schema for servers, players, products, purchases, punishments and tickets
- Bulgarian-first interface with locale-ready structure
- Seed data for immediate local preview
- cPanel/CyberPanel friendly public directory

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

## Design principles

The code does not copy the original site's identity or branding. It rebuilds the visual language as an original NEXUS system: near-black layered surfaces, electric blue accent, compact cards, strong typography, responsive sidebar and consistent component spacing.

## Current status

This is the clean Sprint 1 foundation. Public UI and database structure are ready. Production integrations such as Steam authentication, real game-server polling, CSBans, payment gateways and installer/update automation are intentionally separated for the next backend sprints.
