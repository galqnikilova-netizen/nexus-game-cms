<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameServerController as AdminGameServerController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SteamAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\Admin\NewsPostController as AdminNewsPostController;
use App\Http\Controllers\Admin\StoreProductController as AdminStoreProductController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['bg', 'en'], true), 404);
    session(['locale' => $locale]);
    if (auth()->check()) auth()->user()->update(['locale' => $locale]);
    return back();
})->name('locale.switch');

Route::get('/install', [InstallController::class, 'create'])->name('install');
Route::post('/install', [InstallController::class, 'store'])->middleware('throttle:5,1')->name('install.store');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/servers', [ServerController::class, 'index'])->name('servers.index');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('/bans', [BanController::class, 'index'])->name('bans.index');
Route::get('/community', [PageController::class, 'community'])->name('community.index');
Route::get('/shop', [StoreController::class, 'index'])->name('shop.index');
Route::post('/shop/{product}/purchase', [StoreController::class, 'purchase'])->middleware('auth')->name('shop.purchase');
Route::post('/balance', [BalanceController::class, 'store'])->middleware(['auth','throttle:5,1'])->name('balance.store');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::get('/auth/steam', [SteamAuthController::class, 'redirect'])->name('auth.steam');
Route::get('/auth/steam/callback', [SteamAuthController::class, 'callback'])->middleware('throttle:10,1')->name('auth.steam.callback');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:login');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'can:access-admin'])->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('servers', AdminGameServerController::class)->except(['show']);
    Route::get('modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::patch('modules/{module}/toggle', [ModuleController::class, 'toggle'])->name('modules.toggle');
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::resource('users', UserController::class)->only(['index','edit','update']);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('news', AdminNewsPostController::class)->except(['show']);
    Route::resource('products', AdminStoreProductController::class)->except(['show']);
});
