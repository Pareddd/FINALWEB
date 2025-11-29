<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function organizerDashboard() {
        $events = Event::where('user_id', auth()->id())->with('tickets')->latest()->get();
        return view('organizer.dashboard', compact('events'));
    }

    public function create() {
        $user = Auth::user();
        if ($user->role === 'admin' || ($user->role === 'organizer' && $user->organizer_status === 'berhasil')) {
            return view('events.create');
        }
        abort(403, 'Akses Ditolak');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'image' => 'required|file|image|max:10240',
            
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string',
            'tickets.*.harga' => 'required|numeric|min:0',
            'tickets.*.kuota' => 'required|integer|min:1',
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

        foreach ($request->tickets as $t) {
            Ticket::create([
                'event_id' => $event->id,
                'name' => $t['name'],
                'harga' => $t['harga'],
                'kuota' => $t['kuota'],
                'deskripsi' => $t['deskripsi'] ?? null,
            ]);
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Event dan Semua Tiket Berhasil Dibuat!');
        }
        return redirect()->route('organizer.dashboard')->with('success', 'Event dan Semua Tiket Berhasil Dibuat!');
    }
    
    public function edit(Event $event) {
        if (Auth::user()->role !== 'admin' && $event->user_id != auth()->id()) abort(403);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event) {
        if (Auth::user()->role !== 'admin' && $event->user_id != auth()->id()) abort(403);

        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'tickets' => 'required|array',
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

        foreach ($request->tickets as $t) {
            if (isset($t['id'])) {
                $ticket = Ticket::find($t['id']);
                if ($ticket) {
                    $ticket->update([
                        'name' => $t['name'],
                        'harga' => $t['harga'],
                        'kuota' => $t['kuota'],
                        'deskripsi' => $t['deskripsi'] ?? null,
                    ]);
                }
            } else {
                Ticket::create([
                    'event_id' => $event->id,
                    'name' => $t['name'],
                    'harga' => $t['harga'],
                    'kuota' => $t['kuota'],
                    'deskripsi' => $t['deskripsi'] ?? null,
                ]);
            }
        }

        if (Auth::user()->role === 'admin') return redirect()->route('admin.dashboard')->with('success', 'Event Updated!');
        return redirect()->route('organizer.dashboard')->with('success', 'Event Updated!');
    }

    public function destroy(Event $event) {
        if ($event->user_id != auth()->id()) abort(403);
        if ($event->image) Storage::disk('public')->delete($event->image);
        $event->delete();
        if (Auth::user()->role === 'admin') return redirect()->route('admin.dashboard')->with('success', 'Deleted!');
        return redirect()->route('organizer.dashboard')->with('success', 'Deleted!');
    }

    public function storeTicket(Request $request, Event $event) {
        if (Auth::user()->role !== 'admin' && $event->user_id != auth()->id()) abort(403);
        $request->validate(['new_ticket_name' => 'required', 'new_ticket_harga' => 'required', 'new_ticket_kuota' => 'required']);
        Ticket::create([
            'event_id' => $event->id, 'name' => $request->new_ticket_name,
            'harga' => $request->new_ticket_harga, 'kuota' => $request->new_ticket_kuota,
        ]);
        return back()->with('success', 'Tiket ditambahkan!');
    }

    public function manageBookings(Event $event) {
        if (auth()->user()->role !== 'admin' && $event->user_id !== auth()->id()) abort(403);
        $bookings = \App\Models\Booking::whereIn('ticket_id', $event->tickets->pluck('id'))->with(['user', 'ticket'])->latest()->get();
        return view('events.bookings', compact('event', 'bookings'));
    }
}