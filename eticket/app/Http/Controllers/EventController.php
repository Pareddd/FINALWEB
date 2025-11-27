<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // 1. Dashboard Organizer (Menampilkan daftar event milik sendiri)
    public function organizerDashboard() {
        $events = Event::where('user_id', auth()->id())->with('tickets')->latest()->get();
        return view('organizer.dashboard', compact('events'));
    }

    // 2. Form Buat Event Baru
    public function create() {
        return view('events.create');
    }

    // 3. Simpan Event ke Database
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'date_time' => 'required|date',
            'location' => 'required|string',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ticket_name' => 'required|string',
            'ticket_price' => 'required|numeric|min:0',
            'ticket_quota' => 'required|integer|min:1',
        ]);

        $imagePath = $request->file('image')->store('events', 'public');

        $event = Event::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'deskripsi' => $request->description, 
            'tanggal' => $request->date_time,
            'lokasi' => $request->location,
            'kategori' => $request->category,
            'image' => $imagePath
        ]);

        Ticket::create([
            'event_id' => $event->id,
            'name' => $request->ticket_name,
            'harga' => $request->ticket_price,
            'kuota' => $request->ticket_quota,
        ]);

        return redirect()->route('organizer.dashboard')->with('success', 'Event berhasil dibuat!');
    }
}