<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;

class FavoriteController extends Controller {
    public function toggle(Event $event) {
        $user = auth()->user();
        // Cek apakah sudah ada di favorit
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