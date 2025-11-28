<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;

// 1. PUBLIC (GUEST)
Route::get('/', [PublicController::class, 'index'])->name('home');

// 2. AUTH (LOGIN DULU)
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- USER BIASA ---
    Route::middleware('role:user')->group(function () {
        // Dashboard User
        Route::get('/dashboard', function () {
            $bookings = App\Models\Booking::where('user_id', auth()->id())->with('ticket.event')->latest()->get();
            return view('dashboard', compact('bookings'));
        })->name('dashboard');
        
        // Booking Actions
        Route::post('/booking/{ticket}', [BookingController::class, 'store'])->name('booking.store');
        Route::patch('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
        
        // LIHAT TIKET (INI ROUTE BARU)
        Route::get('/booking/{booking}/ticket', [BookingController::class, 'showTicket'])->name('booking.show');
        
        // Favorite
        Route::post('/events/{event}/favorite', [FavoriteController::class, 'toggle'])->name('events.favorite');
    });

    // --- ADMIN ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::patch('/admin/approve/{user}', [AdminController::class, 'approve'])->name('admin.approve');
        Route::patch('/admin/reject/{user}', [AdminController::class, 'reject'])->name('admin.reject');
        Route::delete('/admin/user/{user}', [AdminController::class, 'destroyUser'])->name('admin.deleteUser');
    });

    // --- ORGANIZER ---
    Route::middleware('role:organizer')->group(function () {
        Route::get('/organizer/pending', function() {
            return view('organizer.pending');
        })->name('organizer.pending');

        Route::middleware('organizer.status')->group(function() {
            Route::get('/organizer/dashboard', [EventController::class, 'organizerDashboard'])->name('organizer.dashboard');
            
            Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
            Route::post('/events', [EventController::class, 'store'])->name('events.store');
            
            Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
            Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
            Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
            
            Route::post('/events/{event}/tickets', [EventController::class, 'storeTicket'])->name('tickets.store');
        });
    });

});

// 3. DETAIL EVENT (WAJIB DI BAWAH)
Route::get('/events/{event}', [PublicController::class, 'show'])->name('events.show');

require __DIR__.'/auth.php';