<?php

use App\Http\Controllers\ReceiptsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('receipts', ReceiptsController::class)->only('index', 'store');
});

require __DIR__.'/settings.php';
