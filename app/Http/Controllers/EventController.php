<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('status', 'published')->paginate(6);

        return view('events.index', compact('events'));
    }

    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $events = Event::paginate(10);

        return view('admin.dashboard', compact('events'));
    }

    // Display all events for admin
    public function adminIndex()
    {
        $events = Event::paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('dashboard')->with('success', 'Event deleted successfully!');
    }
}
