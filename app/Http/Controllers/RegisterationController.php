<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\Registeration;
use App\Services\RegisterationService;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\Rules\Phone;

class RegisterationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $registerations = Registeration::where('event_id', $event->id)
            ->with('attendee')
            ->paginate(15);

        return view('admin.registerations.index', compact('registerations', 'event'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $event = null;

        // Get event ID from query parameter
        if (request()->has('id')) {
            $event = Event::find(request()->id);
        }

        return view('events.register', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (request()->get('registration_type') == 'new') {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => ['nullable', new Phone],
                'company' => 'nullable',
                'event_id' => 'required',
            ]);
            // Make sure this isn't an existing user
            if (Attendee::where('email', $validatedData['email'])->exists()) {
                return redirect()->back()->withErrors(['email' => 'Email already exists, Select Existing User to register.'])->withInput();
            }
            // Make sure the phone number (if provided) isn't associated to an existing user
            if (Attendee::where('phone', $validatedData['phone'])->exists()) {
                return redirect()->back()->withErrors(['phone' => 'Phone already exists, Select Existing User to register.'])->withInput();
            }

            // Create Attendee
            $attendee = Attendee::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'company' => $validatedData['company'],
            ]);

        } else {
            $validatedData = $request->validate([
                'email' => 'required',
                'event_id' => 'required',
            ]);
            // Find Attendee
            $attendee = Attendee::where('email', $validatedData['email'])->first();
            // Make sure this is an existing user
            if (! $attendee) {
                return redirect()->back()->withErrors(['email' => 'Email does not exist, Select New User to register.'])->withInput();
            }
        }

        // Try to register the attendee for the event
        try {
            $registeration = RegisterationService::register($attendee, $validatedData['event_id']);

            // Check registration status and show appropriate message
            if ($registeration->status == 'waitlisted') {
                return redirect()->back()->with('success', 'Registered successfully. You are on the waitlist.');
            } else {
                return redirect()->back()->with('success', 'Registered successfully. Your spot is confirmed!');
            }
        } catch (\Exception $e) {
            // Handle specific exceptions from the service
            $errorMessage = $e->getMessage();

            // Provide user-friendly error messages
            if (str_contains($errorMessage, 'not published')) {
                return redirect()->back()->with('error', 'This event is not currently available for registration.')->withInput();
            } elseif (str_contains($errorMessage, 'already registered')) {
                return redirect()->back()->with('error', 'You are already registered for this event.')->withInput();
            } elseif (str_contains($errorMessage, 'already started')) {
                return redirect()->back()->with('error', 'This event has already started.')->withInput();
            } else {
                return redirect()->back()->with('error', 'Something went wrong. Please try again later.')->withInput();
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Registeration $registeration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registeration $registeration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registeration $registeration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registeration $registeration)
    {
        //
    }

    /**
     * Update the payment status of a registration.
     */
    public function updatePaymentStatus(Request $request, Registeration $registeration)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,refunded',
        ]);

        $newPaymentStatus = $request->payment_status;

        // Business logic validation
        if ($registeration->status === 'waitlisted' && $newPaymentStatus === 'paid') {
            return back()->with('error', 'Waitlisted registrations cannot be marked as paid. Please confirm the registration first.');
        }

        if ($registeration->status === 'cancelled' && $newPaymentStatus === 'paid') {
            return back()->with('error', 'Cancelled registrations cannot be marked as paid.');
        }

        if ($registeration->payment_status === 'paid' && $newPaymentStatus === 'refunded' && $registeration->status === 'confirmed') {
            return back()->with('error', 'To refund a confirmed registration, please cancel the registration first.');
        }

        // Update payment status
        $registeration->payment_status = $newPaymentStatus;
        $registeration->save();

        return back()->with('success', 'Payment status updated successfully.');
    }

    /**
     * Cancel a registration.
     */
    public function cancel(Registeration $registeration)
    {
        if ($registeration->status === 'cancelled') {
            return back()->with('error', 'This registration is already cancelled.');
        }

        $registeration->status = 'cancelled';

        // If the registration was paid, set payment status to refunded
        if ($registeration->payment_status === 'paid') {
            $registeration->payment_status = 'refunded';
        }

        $registeration->save();

        return back()->with('success', 'Registration cancelled successfully.');
    }
}
