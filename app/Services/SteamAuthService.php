<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SteamAuthService
{
    private const OPENID = 'https://steamcommunity.com/openid/login';

    public function redirectUrl(Request $request): string
    {
        return self::OPENID.'?'.http_build_query([
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
            'openid.mode' => 'checkid_setup',
            'openid.return_to' => route('auth.steam.callback'),
            'openid.realm' => $request->getSchemeAndHttpHost(),
            'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        ]);
    }

    public function verify(Request $request): string
    {
        // PHP normalizes dots in query keys to underscores. Only restore the
        // OpenID namespace separator; claimed_id and return_to keep underscores.
        $parameters = collect($request->query())
            ->filter(fn ($value, $key) => str_starts_with((string) $key, 'openid_'))
            ->mapWithKeys(fn ($value, $key) => ['openid.'.substr((string) $key, 7) => $value])
            ->all();

        $claimed = (string) ($parameters['openid.claimed_id'] ?? '');
        if (! preg_match('#^https://steamcommunity\.com/openid/id/(\d{17,20})$#', $claimed, $match)) {
            throw new RuntimeException('Invalid Steam identity.');
        }

        $parameters['openid.mode'] = 'check_authentication';
        $response = Http::asForm()->timeout(10)->post(self::OPENID, $parameters);
        if (! $response->successful() || ! str_contains($response->body(), 'is_valid:true')) {
            throw new RuntimeException('Steam verification failed.');
        }

        return $match[1];
    }

    public function profile(string $steamId): array
    {
        $key = config('services.steam.api_key');
        if (! $key) {
            return ['steamid' => $steamId, 'personaname' => 'Steam Player', 'profileurl' => 'https://steamcommunity.com/profiles/'.$steamId, 'avatarfull' => null];
        }
        $response = Http::timeout(10)->get('https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/', ['key' => $key, 'steamids' => $steamId]);
        return $response->successful() ? ($response->json('response.players.0') ?? []) : [];
    }
}
