<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registeration;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
            'payment_status' => 'required|in:pending,paid,refunded'
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
