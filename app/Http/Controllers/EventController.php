<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Menampilkan daftar event
    public function index()
    {
        // $events = Event::where('ends_at', '>=', now())->orderBy('starts_at', 'asc') // Hanya tampilkan event yang belum berakhir
        $events = Event::orderBy('starts_at', 'desc')->paginate(9);
        return view('events.index', compact('events'));
    }

    // Menampilkan detail event
    public function show(Event $event)
    { // Route Model Binding
        return view('events.show', compact('event'));
    }
}
