<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registeration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('status', 'published')->orderBy('date_time', 'desc')->paginate(6);

        return view('events.index', compact('events'));
    }

    /**
     * Display the admin dashboard with analytics
     */
    public function dashboard()
    {
        // Event Statistics
        $totalEvents = Event::count();
        $publishedEvents = Event::where('status', 'published')->count();
        $draftEvents = Event::where('status', 'draft')->count();
        $completedEvents = Event::where('status', 'completed')->count();
        $cancelledEvents = Event::where('status', 'cancelled')->count();

        // Registration Statistics
        $totalRegistrations = Registeration::count();
        $confirmedRegistrations = Registeration::where('status', 'confirmed')->count();
        $waitlistedRegistrations = Registeration::where('status', 'waitlisted')->count();
        $cancelledRegistrations = Registeration::where('status', 'cancelled')->count();

        // Revenue Statistics
        $totalRevenue = Registeration::where('payment_status', 'paid')
            ->join('events', 'registerations.event_id', '=', 'events.id')
            ->sum('events.price');

        $pendingRevenue = Registeration::where('payment_status', 'pending')
            ->join('events', 'registerations.event_id', '=', 'events.id')
            ->sum('events.price');

        // Upcoming Events (next 5)
        $upcomingEvents = Event::where('status', 'published')
            ->where('date_time', '>', now())
            ->orderBy('date_time', 'asc')
            ->take(5)
            ->withCount(['registrations as confirmed_count' => function ($query) {
                $query->where('status', 'confirmed');
            }])
            ->get();

        // Event Status Distribution (for pie chart)
        $eventStatusData = [
            ['label' => 'Published', 'value' => $publishedEvents, 'color' => '#22d3ee'],
            ['label' => 'Draft', 'value' => $draftEvents, 'color' => '#9ca3af'],
            ['label' => 'Completed', 'value' => $completedEvents, 'color' => '#3b82f6'],
            ['label' => 'Cancelled', 'value' => $cancelledEvents, 'color' => '#ef4444'],
        ];

        // Registration Status Distribution
        $registrationStatusData = [
            ['label' => 'Confirmed', 'value' => $confirmedRegistrations, 'color' => '#22d3ee'],
            ['label' => 'Waitlisted', 'value' => $waitlistedRegistrations, 'color' => '#9ca3af'],
            ['label' => 'Cancelled', 'value' => $cancelledRegistrations, 'color' => '#ef4444'],
        ];

        // Revenue Trend (Last 30 Days)
        $revenueTrend = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyRevenue = Registeration::where('payment_status', 'paid')
                ->join('events', 'registerations.event_id', '=', 'events.id')
                ->whereDate('registerations.updated_at', $date)  // Specify table name to avoid ambiguity
                ->sum('events.price');

            $revenueTrend[] = [
                'date' => now()->subDays($i)->format('M d'),
                'revenue' => $dailyRevenue,
            ];
        }

        return view('admin.dashboard', compact(
            'totalEvents',
            'publishedEvents',
            'draftEvents',
            'completedEvents',
            'cancelledEvents',
            'totalRegistrations',
            'confirmedRegistrations',
            'waitlistedRegistrations',
            'cancelledRegistrations',
            'totalRevenue',
            'pendingRevenue',
            'upcomingEvents',
            'eventStatusData',
            'registrationStatusData',
            'revenueTrend'
        ));
    }

    /**
     * Display admin events page with tabs for different statuses
     * Gets the status from URL parameter (default: 'all')
     */
    public function adminIndex(Request $request)
    {
        // Get status from query parameter, default to 'all'
        $status = $request->get('status', 'all');

        // Build the query with revenue calculation
        $query = Event::query()
            // Count paid registrations for revenue calculation
            ->withCount([
                'registrations as paid_registrations_count' => function ($query) {
                    $query->where('payment_status', 'paid');
                },
            ]);

        // Filter by status if not 'all'
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Order by updated_at for cancelled events (most recently cancelled first)
        // Order by date_time for all other events
        if ($status === 'cancelled') {
            $query->orderBy('updated_at', 'desc');
        } else {
            $query->orderBy('date_time', 'desc');
        }

        // Get paginated events
        $events = $query->paginate(10);

        // Calculate revenue for each event (paid registrations * price)
        $events->getCollection()->transform(function ($event) {
            $event->total_revenue = $event->paid_registrations_count * $event->price;

            return $event;
        });

        return view('admin.events.index', compact('events', 'status'));
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date_time' => 'required|date',
            'location' => 'required',
            'capacity' => 'required|numeric',
            'price' => 'nullable|numeric',
            'status' => 'required|in:published,draft',
        ]);

        // Make sure the event date is at least 24 hours from now
        $eventDateTime = Carbon::parse($request->date_time);
        $minimumDateTime = Carbon::now()->addHours(24);

        if ($eventDateTime->lessThan($minimumDateTime)) {
            return redirect()->route('event.create')->with('error', 'Event date must be at least 24 hours from now!')->withInput();
        }

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date_time' => $request->date_time,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'price' => $request->price ?? 0, // Set Price as Free if null
            'status' => $request->status,
        ]);

        return redirect()->route('event.index')->with('success', 'Event created successfully!');
    }

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
        if ($event->status == 'cancelled' || $event->status == 'completed') {
            return redirect()->route('event.index')->with('error', 'Event cannot be edited!');
        }

        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date_time' => 'required|date',
            'location' => 'required',
            'capacity' => 'required|numeric',
            'price' => 'nullable|numeric',
            'status' => 'required|in:published,draft',
        ]);
        // Make sure the event date is at least 24 hours from now
        $eventDateTime = Carbon::parse($request->date_time);
        $minimumDateTime = Carbon::now()->addHours(24);

        if ($eventDateTime->lessThan($minimumDateTime)) {
            return redirect()->route('event.edit', compact('event'))->with('error', 'Event date must be at least 24 hours from now!')->withInput();
        }

        // If the user tried to decrease capacity below the number of registered users
        if ($event->registrations->count() > $request->capacity) {
            return redirect()->route('event.edit', compact('event'))->with('error', 'Event capacity cannot be decreased below the number of registered users!')->withInput();
        }

        // If the user tried to draft a published event that have registrations
        if ($event->status == 'published' && $event->registrations->count() > 0) {
            return redirect()->route('event.edit', compact('event'))->with('error', 'Published event with existing registrations cannot be drafted!, you can cancel it')->withInput();
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'date_time' => $request->date_time,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'price' => $request->price ?? 0, // Set Price as Free if null
            'status' => $request->status,
        ]);

        return redirect()->route('event.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->update([
            'status' => 'cancelled',
            'updated_at' => now(),
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('event.index', ['status' => 'cancelled'])->with('success', 'Event cancelled successfully!');
    }
}
