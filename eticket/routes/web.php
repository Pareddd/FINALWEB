<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;


Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/events/{event}', [PublicController::class, 'show'])->name('events.show');


Route::middleware('auth')->group(function () {
   
    Route::post('/booking/{ticket}', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/events/{event}/favorite', [FavoriteController::class, 'toggle'])->name('events.favorite');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';