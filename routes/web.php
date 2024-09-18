<?php

use App\Filament\Admin\Pages\Chat;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(env('ASSET_PREFIX', '').'/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(env('ASSET_PREFIX', '').'/livewire/livewire.js', $handle);
});
/*
/ END
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // For Filament page
    Route::get('/admin/chat/{thread}', [Chat::class, 'mount'])->name('filament.pages.chat');
    Route::get('/chat/{thread}', [ChatController::class, 'show'])->name('chat.show');
    // For direct chat controller
    Route::get('/chat/{thread}', [ChatController::class, 'index'])->name('chat.list');
    Route::post('/chat/{thread}', [ChatController::class, 'sendMessage']);
});