<?php
namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller {
    public function store(Request $request, Ticket $ticket) {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($ticket->kuota < $request->quantity) {
            return back()->with('error', 'Stok habis!');
        }

        DB::transaction(function () use ($request, $ticket) {
            $ticket->decrement('kuota', $request->quantity);
            Booking::create([
                'user_id' => auth()->id(),
                'ticket_id' => $ticket->id,
                'quantity' => $request->quantity,
                'status' => 'lunas'
            ]);
        });

        return back()->with('success', 'Tiket berhasil dibeli!');
    }
}