<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;

// --- 1. AREA PUBLIK (GUEST) ---
// Halaman Depan
Route::get('/', [PublicController::class, 'index'])->name('home');

// --- 2. AREA AUTH (HARUS LOGIN) ---
Route::middleware('auth')->group(function () {

    // Profile Routes (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ROLE: USER BIASA ---
    Route::middleware('role:user')->group(function () {
        Route::post('/booking/{ticket}', [BookingController::class, 'store'])->name('booking.store');
        Route::post('/events/{event}/favorite', [FavoriteController::class, 'toggle'])->name('events.favorite');
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });

    // --- ROLE: ADMIN ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::patch('/admin/approve/{user}', [AdminController::class, 'approve'])->name('admin.approve');
    });

    // --- ROLE: ORGANIZER ---
    Route::middleware('role:organizer')->group(function () {
        // Dashboard Organizer (List Event)
        Route::get('/organizer/dashboard', [EventController::class, 'organizerDashboard'])->name('organizer.dashboard');
        
        // CRUD Event (Create & Store)
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
    });

});

// --- 3. DETAIL EVENT (TARUH PALING BAWAH) ---
// Agar URL "events/create" tidak dianggap sebagai ID event
Route::get('/events/{event}', [PublicController::class, 'show'])->name('events.show');

require __DIR__.'/auth.php';