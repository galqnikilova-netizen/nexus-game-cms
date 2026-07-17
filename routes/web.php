<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::controller(PublicController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/leaderboard', 'leaderboard')->name('leaderboard');
    Route::get('/store', 'store')->name('store');
    Route::get('/skinchanger', 'skinchanger')->name('skinchanger');
    Route::get('/punishments', 'punishments')->name('punishments');
    Route::get('/faq', 'faq')->name('faq');
    Route::get('/rules', 'rules')->name('rules');
    Route::get('/tickets', 'tickets')->name('tickets');
    Route::get('/players/{steamId?}', 'profile')->name('profile');
});

Route::prefix('admin')->name('admin.')->controller(AdminController::class)->group(function (): void {
    Route::get('/', 'dashboard')->name('dashboard');
});
