<?php

namespace App\Services;

use App\Models\Setting;
use Throwable;

class AppearanceService
{
    private ?array $values = null;

    public function all(): array
    {
        if ($this->values !== null) return $this->values;
        try { $stored = Setting::query()->pluck('value', 'key')->all(); } catch (Throwable) { $stored = []; }
        $accent = (string) ($stored['accent.color'] ?? '#91ff2d');
        if (! preg_match('/^#[0-9a-fA-F]{6}$/', $accent)) $accent = '#91ff2d';
        $defaultLocale = (string) ($stored['default.locale'] ?? 'bg');
        return $this->values = [
            'site_name' => (string) ($stored['site.name'] ?? 'NEXUS'),
            'site_tagline' => (string) ($stored['site.tagline'] ?? 'Твоята gaming общност.'),
            'default_locale' => in_array($defaultLocale, ['bg', 'en'], true) ? $defaultLocale : 'bg',
            'accent' => strtolower($accent),
        ];
    }
}
