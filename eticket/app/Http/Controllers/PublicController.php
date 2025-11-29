<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request) {
        $query = Event::query();

        if ($request->has('search') && $request->search != '') {
            
            $search = trim($request->search);
            
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')        
                  ->orWhere('kategori', 'like', '%' . $search . '%')  
                  ->orWhere('lokasi', 'like', '%' . $search . '%')    
                  ->orWhere('deskripsi', 'like', '%' . $search . '%'); 
            });
        }
        // -----------------------------

        $events = $query->latest()->get();
        return view('welcome', compact('events'));
    }

    public function show(Event $event) {
        $event->load('tickets');
        return view('events.show', compact('event'));
    }
}