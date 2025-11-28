<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function organizerDashboard() {
        $events = Event::where('user_id', auth()->id())->with('tickets')->latest()->get();
        return view('organizer.dashboard', compact('events'));
    }

    public function create() { return view('events.create'); }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'image' => 'required|file|image|max:10240',
            'ticket_name' => 'required',
            'ticket_harga' => 'required|numeric',
            'ticket_kuota' => 'required|integer',
        ]);

        $imagePath = $request->file('image')->store('events', 'public');

        $event = Event::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'kategori' => $request->kategori,
            'image' => $imagePath
        ]);

        Ticket::create([
            'event_id' => $event->id,
            'name' => $request->ticket_name,
            'harga' => $request->ticket_harga,
            'kuota' => $request->ticket_kuota,
        ]);

        return redirect()->route('organizer.dashboard')->with('success', 'Event Berhasil Disimpan!');
    }

    public function edit(Event $event) {
        if($event->user_id != auth()->id()) abort(403);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event) {
        if($event->user_id != auth()->id()) abort(403);
        
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image) Storage::disk('public')->delete($event->image);
            $event->image = $request->file('image')->store('events', 'public');
        }

        $event->update([
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'kategori' => $request->kategori,
            'image' => $event->image 
        ]);

        return redirect()->route('organizer.dashboard')->with('success', 'Event Updated!');
    }

    public function destroy(Event $event) {
        if($event->user_id != auth()->id()) abort(403);
        if ($event->image) Storage::disk('public')->delete($event->image);
        $event->delete();
        return redirect()->route('organizer.dashboard')->with('success', 'Event Dihapus!');
    }

    public function storeTicket(Request $request, Event $event) {
        if($event->user_id != auth()->id()) abort(403);

        $request->validate([
            'new_ticket_name' => 'required',
            'new_ticket_harga' => 'required|numeric',
            'new_ticket_kuota' => 'required|integer',
        ]);

        Ticket::create([
            'event_id' => $event->id,
            'name' => $request->new_ticket_name,
            'harga' => $request->new_ticket_harga,
            'kuota' => $request->new_ticket_kuota,
        ]);

        return back()->with('success', 'Tiket baru ditambahkan!');
    }
}