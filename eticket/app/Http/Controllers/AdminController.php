<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $allUsers = User::where('role', '!=', 'admin')->latest()->get();
        
        $pendingOrganizers = User::where('role', 'organizer')
                                 ->where('organizer_status', 'pending')
                                 ->get();
        
        $totalRevenue = Booking::where('status', 'paid')
            ->join('tickets', 'bookings.ticket_id', '=', 'tickets.id')
            ->sum('tickets.harga'); 

        return view('admin.dashboard', compact('allUsers', 'pendingOrganizers', 'totalRevenue'));
    }

    public function approve(User $user) {
        $user->update(['organizer_status' => 'berhasil']);
        return back()->with('success', 'Akun Organizer disetujui.');
    }

    public function reject(User $user) {
        $user->update(['organizer_status' => 'ditolak']);
        return back()->with('error', 'Akun Organizer ditolak.');
    }

    public function destroyUser(User $user) {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus dari sistem.');
    }
}