<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;

class PublicController extends Controller {
    public function index() {
        $events = Event::latest()->get();
        return view('welcome', compact('events'));
    }

    public function show(Event $event) {
        $event->load('tickets'); 
        return view('events.show', compact('event'));
    }
}