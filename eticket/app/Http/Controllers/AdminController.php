<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $pendingOrganizers = User::where('role', 'organizer')
                                 ->where('organizer_status', 'pending')
                                 ->get();

        return view('admin.dashboard', compact('pendingOrganizers'));
    }

    public function approveOrganizer(User $user) {
        $user->update(['organizer_status' => 'berhasil']);
        return back()->with('success', 'Organizer berhasil disetujui.');
    }
}