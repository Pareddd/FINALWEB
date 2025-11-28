<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // ... (Fungsi organizerDashboard, create, store, edit TETAP SAMA seperti sebelumnya) ...
    // ... (Pastikan Anda tetap memiliki fungsi store yang sudah benar dari jawaban sebelumnya) ...

    public function organizerDashboard() {
        $events = Event::where('user_id', auth()->id())->with('tickets')->latest()->get();
        return view('organizer.dashboard', compact('events'));
    }

    public function create() {
        return view('events.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'image' => 'required|file|image|max:10240',
            'tickets' => 'required|array',
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

        return redirect()->route('organizer.dashboard')->with('success', 'Event Berhasil Disimpan!');
    }

    public function edit(Event $event) {
        if (Auth::user()->role !== 'admin' && $event->user_id != auth()->id()) abort(403);
        return view('events.edit', compact('event'));
    }

    // --- FOKUS PERBAIKAN: FUNGSI UPDATE ---
    public function update(Request $request, Event $event) {
        // 1. Cek Hak Akses
        if (Auth::user()->role !== 'admin' && $event->user_id != auth()->id()) abort(403);

        // 2. Validasi
        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'kategori' => 'required',
            'tickets' => 'required|array', // Validasi array tiket
        ]);

        // 3. Update Data Event Utama
        $dataEvent = [
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'kategori' => $request->kategori,
        ];

        // Cek jika ganti gambar
        if ($request->hasFile('image')) {
            if ($event->image) Storage::disk('public')->delete($event->image);
            $dataEvent['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($dataEvent);

        // 4. Update Tiket (Looping)
        foreach ($request->tickets as $t) {
            // Jika data punya ID, berarti ini tiket lama -> UPDATE
            if (isset($t['id'])) {
                $ticket = Ticket::find($t['id']);
                if ($ticket && $ticket->event_id == $event->id) {
                    $ticket->update([
                        'name' => $t['name'],
                        'harga' => $t['harga'],       // Pastikan 'harga'
                        'kuota' => $t['kuota'],       // Pastikan 'kuota'
                        'deskripsi' => $t['deskripsi'] ?? null,
                    ]);
                }
            } 
            // Jika tidak punya ID, berarti tiket baru ditambahkan saat edit -> CREATE
            else {
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

    public function manageBookings(Event $event) {
        if (auth()->user()->role !== 'admin' && $event->user_id !== auth()->id()) abort(403);
        $bookings = \App\Models\Booking::whereIn('ticket_id', $event->tickets->pluck('id'))->with(['user', 'ticket'])->latest()->get();
        return view('events.bookings', compact('event', 'bookings'));
    }
}