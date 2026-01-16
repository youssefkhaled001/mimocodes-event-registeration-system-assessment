@component('mail::message')
# Great News! You're Confirmed! 🎉

Hello **{{ $attendee->name }}**,

Excellent news! A spot has opened up for **{{ $event->title }}**, and you've been automatically promoted from the
waitlist to confirmed status.

@component('mail::panel')
## Event Details

**Event:** {{ $event->title }}

**Date & Time:** {{ $event->date_time->format('l, F j, Y \a\t g:i A') }}

**Location:** {{ $event->location }}

**Price:** {{ $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free' }}

**Status:** Confirmed ✓
@endcomponent

@if($event->price > 0)
    **Payment Information**

    **Payment Status:** {{ ucfirst($registration->payment_status) }}

    @if($registration->payment_status === 'pending')
        ⚠️ Please complete your payment as soon as possible to secure your spot.
    @endif
@endif

Your spot is now guaranteed! We're excited to have you join us.

You'll receive a reminder 24 hours before the event starts.

@component('mail::button', ['url' => url('/events/' . $event->id)])
View Event Details
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent