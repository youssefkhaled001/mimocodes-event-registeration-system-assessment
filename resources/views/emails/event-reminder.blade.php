@component('mail::message')
# Event Reminder: Tomorrow! ⏰

Hello **{{ $attendee->name }}**,

This is a friendly reminder that **{{ $event->title }}** is happening tomorrow!

@component('mail::panel')
## Event Details

**Event:** {{ $event->title }}

**Date & Time:** {{ $event->date_time->format('l, F j, Y \a\t g:i A') }}

**Location:** {{ $event->location }}

**Your Status:** Confirmed ✓
@endcomponent

**What to bring:**
- Your confirmation (this email)
- Valid ID
- Any materials mentioned in the event description

**Getting there:**

We recommend arriving 15 minutes early to check in at {{ $event->location }}.

@if($event->price > 0 && $registration->payment_status === 'pending')
    @component('mail::panel')
    ⚠️ **Payment Reminder**

    Your payment status is currently pending. Please complete your payment before the event.
    @endcomponent
@endif

We're looking forward to seeing you tomorrow!

@component('mail::button', ['url' => url('/events/' . $event->id)])
View Event Details
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent