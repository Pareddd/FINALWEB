<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Event; // <--- PASTIKAN INI ADA
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {

        $allUsers = User::where('role', '!=', 'admin')->latest()->get();
        
        $pendingOrganizers = User::where('role', 'organizer')
                                 ->where('organizer_status', 'pending')
                                 ->get();

        $totalRevenue = Booking::where('status', 'lunas')
            ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->sum('tickets.harga'); 

        $allEvents = Event::with('organizer')->latest()->get();

        return view('admin.dashboard', compact('allUsers', 'pendingOrganizers', 'totalRevenue', 'allEvents'));
    }

    public function approve(User $user) {
        $user->update(['organizer_status' => 'berhasil']);
        return back()->with('success', 'Organizer disetujui.');
    }

    public function reject(User $user) {
        $user->update(['organizer_status' => 'ditolak']);
        return back()->with('error', 'Organizer ditolak.');
    }

    public function destroyUser(User $user) {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}