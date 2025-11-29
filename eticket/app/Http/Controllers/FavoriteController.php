<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index() {
        $favorites = Auth::user()->favorites()->with('tickets')->latest()->get();
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Event $event) {
        $user = Auth::user();
        
        if ($user->favorites()->where('event_id', $event->id)->exists()) {
            $user->favorites()->detach($event->id);
            $msg = 'Dihapus dari favorit';
        } else {
            $user->favorites()->attach($event->id);
            $msg = 'Ditambahkan ke favorit';
        }
        
        return back()->with('success', $msg);
    }
}