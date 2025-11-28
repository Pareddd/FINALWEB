<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request, Ticket $ticket) {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($ticket->kuota < $request->quantity) {
            return back()->with('error', 'Stok tiket habis!');
        }

        DB::transaction(function () use ($request, $ticket) {
       
            $ticket->decrement('kuota', $request->quantity);
            
            Booking::create([
                'user_id' => auth()->id(),
                'ticket_id' => $ticket->id,
                'quantity' => $request->quantity,
                'status' => 'pending' 
            ]);
        });

        return back()->with('success', 'Tiket berhasil dipesan! Menunggu persetujuan Organizer.');
    }
    public function cancel(Booking $booking) {
        if($booking->user_id != auth()->id()) abort(403);

        if($booking->status == 'batal') {
            return back()->with('error', 'Tiket sudah dibatalkan.');
        }

        DB::transaction(function () use ($booking) {
            $booking->ticket->increment('kuota', $booking->quantity);
            $booking->update(['status' => 'batal']);
        });

        return back()->with('success', 'Pesanan dibatalkan. Kuota tiket dikembalikan.');
    }

    public function showTicket(Booking $booking) {
        if ($booking->user_id != auth()->id()) abort(403);

        if ($booking->status != 'lunas') {
            return redirect()->route('dashboard')->with('error', 'Tiket belum disetujui atau dibatalkan.');
        }

        return view('bookings.ticket', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking) {
        $user = auth()->user();
        if ($user->role !== 'admin' && $booking->ticket->event->user_id !== $user->id) {
            abort(403);
        }

        $request->validate(['status' => 'required|in:lunas,batal']);

        DB::transaction(function () use ($request, $booking) {
            
            if ($request->status == 'batal' && $booking->status != 'batal') {
                $booking->ticket->increment('kuota', $booking->quantity);
            }
            
            if ($request->status == 'lunas' && $booking->status == 'batal') {
                if ($booking->ticket->kuota < $booking->quantity) {
                    throw new \Exception('Stok tiket tidak cukup.');
                }
                $booking->ticket->decrement('kuota', $booking->quantity);
            }

            $booking->update(['status' => $request->status]);
        });

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}