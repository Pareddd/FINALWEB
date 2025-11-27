<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request) {
        $query = Event::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }
        $events = $query->latest()->get();
        return view('welcome', compact('events'));
    }

    public function show(Event $event) {
        $event->load('tickets');
        return view('events.show', compact('event'));
    }
}