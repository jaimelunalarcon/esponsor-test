<?php

use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'welcome')->name('dashboard');

    Route::get('/site', [SiteController::class, 'show']);
    Route::post('/site', [SiteController::class, 'upsert']);
    Route::post('/site/publish', [SiteController::class, 'publish']);
});

Route::get('/{slug}', [PublicSiteController::class, 'show'])
    ->where('slug', '^(?!site$|login$|register$|dashboard$).+');

require __DIR__.'/auth.php';