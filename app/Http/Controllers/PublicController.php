<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final class PublicController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'servers' => $this->servers(),
            'punishments' => $this->punishmentsData(),
            'purchases' => $this->purchases(),
            'stats' => [
                ['label' => 'Играчи онлайн', 'value' => '1 248', 'meta' => '+12.8% днес', 'icon' => 'users'],
                ['label' => 'Активни сървъри', 'value' => '18 / 20', 'meta' => '90% uptime', 'icon' => 'server'],
                ['label' => 'Регистрирани', 'value' => '52 834', 'meta' => '+186 тази седмица', 'icon' => 'shield'],
                ['label' => 'Изиграни часове', 'value' => '18 421', 'meta' => 'последните 24 ч.', 'icon' => 'clock'],
            ],
        ]);
    }

    public function leaderboard(): View
    {
        return view('pages.leaderboard', ['players' => $this->players()]);
    }

    public function store(): View
    {
        return view('pages.store', ['products' => $this->products(), 'servers' => $this->servers()]);
    }

    public function skinchanger(): View
    {
        return view('pages.skinchanger', ['weapons' => $this->weapons()]);
    }

    public function punishments(): View
    {
        return view('pages.punishments', ['punishments' => $this->punishmentsData(14)]);
    }

    public function faq(): View
    {
        return view('pages.faq');
    }

    public function rules(): View
    {
        return view('pages.rules');
    }

    public function tickets(): View
    {
        return view('pages.tickets');
    }

    public function profile(?string $steamId = null): View
    {
        return view('pages.profile', [
            'player' => $this->players()[0],
            'recentMatches' => $this->recentMatches(),
            'weaponStats' => $this->weapons(),
        ]);
    }

    private function servers(): array
    {
        return [
            ['name' => 'NEXUS #1 PUBLIC', 'mode' => 'PUBLIC', 'map' => 'de_mirage', 'players' => 28, 'slots' => 32, 'ping' => 18, 'accent' => 'violet'],
            ['name' => 'NEXUS #2 RETAKES', 'mode' => 'RETAKES', 'map' => 'de_inferno', 'players' => 19, 'slots' => 24, 'ping' => 24, 'accent' => 'cyan'],
            ['name' => 'NEXUS #3 AWP', 'mode' => 'AWP', 'map' => 'awp_lego_2', 'players' => 14, 'slots' => 20, 'ping' => 31, 'accent' => 'orange'],
            ['name' => 'NEXUS #4 ARENA', 'mode' => '1V1', 'map' => 'am_dust2', 'players' => 11, 'slots' => 18, 'ping' => 22, 'accent' => 'rose'],
        ];
    }

    private function players(): array
    {
        return [
            ['rank' => 1, 'name' => 'ROG_STRIX', 'steam' => 'STEAM_1:1:20482001', 'rating' => 2148, 'kills' => 1842, 'deaths' => 991, 'kd' => 1.86, 'wins' => 128, 'hours' => 342, 'trend' => '+84', 'status' => 'online'],
            ['rank' => 2, 'name' => 'xFury', 'steam' => 'STEAM_1:0:54211992', 'rating' => 2076, 'kills' => 1721, 'deaths' => 1044, 'kd' => 1.65, 'wins' => 119, 'hours' => 314, 'trend' => '+42', 'status' => 'online'],
            ['rank' => 3, 'name' => 'm1rage', 'steam' => 'STEAM_1:1:8841037', 'rating' => 1984, 'kills' => 1638, 'deaths' => 1089, 'kd' => 1.50, 'wins' => 104, 'hours' => 288, 'trend' => '+19', 'status' => 'away'],
            ['rank' => 4, 'name' => 'deadinside', 'steam' => 'STEAM_1:0:66117321', 'rating' => 1927, 'kills' => 1594, 'deaths' => 1123, 'kd' => 1.42, 'wins' => 101, 'hours' => 271, 'trend' => '-8', 'status' => 'offline'],
            ['rank' => 5, 'name' => 'k0bra', 'steam' => 'STEAM_1:1:99012442', 'rating' => 1892, 'kills' => 1511, 'deaths' => 1098, 'kd' => 1.38, 'wins' => 98, 'hours' => 249, 'trend' => '+31', 'status' => 'online'],
            ['rank' => 6, 'name' => 'Luna', 'steam' => 'STEAM_1:0:11702092', 'rating' => 1825, 'kills' => 1439, 'deaths' => 1088, 'kd' => 1.32, 'wins' => 91, 'hours' => 230, 'trend' => '+12', 'status' => 'offline'],
            ['rank' => 7, 'name' => 'n0scope', 'steam' => 'STEAM_1:1:77311421', 'rating' => 1774, 'kills' => 1376, 'deaths' => 1064, 'kd' => 1.29, 'wins' => 87, 'hours' => 218, 'trend' => '-17', 'status' => 'away'],
            ['rank' => 8, 'name' => 'Vortex', 'steam' => 'STEAM_1:0:44201531', 'rating' => 1732, 'kills' => 1298, 'deaths' => 1022, 'kd' => 1.27, 'wins' => 82, 'hours' => 201, 'trend' => '+6', 'status' => 'online'],
        ];
    }

    private function punishmentsData(int $limit = 6): array
    {
        $rows = [
            ['player' => 'toxic.exe', 'reason' => 'Обиди и провокации', 'admin' => 'ROG_STRIX', 'server' => 'PUBLIC', 'duration' => '2 часа', 'status' => 'active', 'time' => 'преди 3 мин.'],
            ['player' => 'WallHack?', 'reason' => 'Непозволен софтуер', 'admin' => 'NEXUS Guard', 'server' => 'RETAKES', 'duration' => 'Перманентен', 'status' => 'active', 'time' => 'преди 11 мин.'],
            ['player' => 'xXProXx', 'reason' => 'Спам в чата', 'admin' => 'm1rage', 'server' => 'AWP', 'duration' => '30 мин.', 'status' => 'expired', 'time' => 'преди 28 мин.'],
            ['player' => 'NoName', 'reason' => 'AFK / пречене', 'admin' => 'AutoMod', 'server' => 'ARENA', 'duration' => '10 мин.', 'status' => 'expired', 'time' => 'преди 46 мин.'],
            ['player' => 'ragequit', 'reason' => 'Груб език', 'admin' => 'k0bra', 'server' => 'PUBLIC', 'duration' => '1 час', 'status' => 'active', 'time' => 'преди 1 ч.'],
            ['player' => 'flashbang', 'reason' => 'Умишлен team flash', 'admin' => 'xFury', 'server' => 'RETAKES', 'duration' => '4 часа', 'status' => 'active', 'time' => 'преди 2 ч.'],
        ];
        return array_slice(array_merge($rows, $rows, $rows), 0, $limit);
    }

    private function purchases(): array
    {
        return [
            ['name' => 'k0bra', 'product' => 'NEXUS PRIME', 'price' => '19.99 лв.', 'time' => 'преди 4 мин.'],
            ['name' => 'Vortex', 'product' => 'VIP 30 дни', 'price' => '8.99 лв.', 'time' => 'преди 17 мин.'],
            ['name' => 'Luna', 'product' => '500 NEXUS Coins', 'price' => '5.00 лв.', 'time' => 'преди 31 мин.'],
            ['name' => 'm1rage', 'product' => 'Admin Trial', 'price' => '14.99 лв.', 'time' => 'преди 52 мин.'],
        ];
    }

    private function products(): array
    {
        return [
            ['name' => 'NEXUS PRIME', 'type' => 'VIP + ADMIN', 'price' => '19.99', 'period' => '30 дни', 'popular' => true, 'features' => ['VIP slot и резервирано място', 'Цветен чат и custom tag', 'Admin команди ниво B', 'Двойни NEXUS Coins']],
            ['name' => 'VIP CORE', 'type' => 'VIP', 'price' => '8.99', 'period' => '30 дни', 'popular' => false, 'features' => ['VIP slot', 'Knife round избор', 'Допълнителни skin presets', 'Приоритетна поддръжка']],
            ['name' => 'ADMIN TRIAL', 'type' => 'ADMIN', 'price' => '14.99', 'period' => '14 дни', 'popular' => false, 'features' => ['Основни admin команди', 'Достъп до admin dashboard', 'Audit log', 'Проверка преди активиране']],
            ['name' => 'COIN PACK', 'type' => 'BALANCE', 'price' => '5.00', 'period' => '500 coins', 'popular' => false, 'features' => ['500 NEXUS Coins', 'Моментално активиране', 'Без срок на валидност', 'Използвай в магазина']],
        ];
    }

    private function weapons(): array
    {
        return [
            ['name' => 'AK-47', 'skin' => 'Neon Rider', 'kills' => 648, 'accuracy' => 31, 'headshots' => 54, 'gradient' => 'g-purple'],
            ['name' => 'M4A1-S', 'skin' => 'Printstream', 'kills' => 481, 'accuracy' => 36, 'headshots' => 49, 'gradient' => 'g-cyan'],
            ['name' => 'AWP', 'skin' => 'Chromatic Aberration', 'kills' => 329, 'accuracy' => 67, 'headshots' => 18, 'gradient' => 'g-rose'],
            ['name' => 'Desert Eagle', 'skin' => 'Blaze', 'kills' => 214, 'accuracy' => 42, 'headshots' => 71, 'gradient' => 'g-orange'],
            ['name' => 'USP-S', 'skin' => 'Kill Confirmed', 'kills' => 192, 'accuracy' => 39, 'headshots' => 64, 'gradient' => 'g-red'],
            ['name' => 'Glock-18', 'skin' => 'Gamma Doppler', 'kills' => 177, 'accuracy' => 34, 'headshots' => 57, 'gradient' => 'g-green'],
        ];
    }

    private function recentMatches(): array
    {
        return [
            ['map' => 'de_mirage', 'score' => '13 : 8', 'result' => 'Победа', 'kd' => '24 / 14', 'rating' => '+31', 'time' => 'днес, 14:32'],
            ['map' => 'de_inferno', 'score' => '10 : 13', 'result' => 'Загуба', 'kd' => '18 / 19', 'rating' => '-16', 'time' => 'вчера, 22:14'],
            ['map' => 'de_ancient', 'score' => '13 : 4', 'result' => 'Победа', 'kd' => '27 / 11', 'rating' => '+42', 'time' => 'вчера, 19:48'],
            ['map' => 'de_nuke', 'score' => '13 : 11', 'result' => 'Победа', 'kd' => '21 / 18', 'rating' => '+18', 'time' => '15 юли, 23:09'],
        ];
    }
}
