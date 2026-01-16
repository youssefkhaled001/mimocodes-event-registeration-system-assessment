@component('mail::message')
# Registration Confirmed! 🎉

Hello **{{ $attendee->name }}**,

Great news! Your registration for **{{ $event->title }}** has been confirmed.

@component('mail::panel')
## Event Details

**Event:** {{ $event->title }}

**Date & Time:** {{ $event->date_time->format('l, F j, Y \a\t g:i A') }}

**Location:** {{ $event->location }}

**Price:** {{ $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free' }}

**Status:** Confirmed ✓
@endcomponent


We're excited to see you at the event! You'll receive a reminder 24 hours before the event starts.

If you have any questions, feel free to reach out to us.


@component('mail::button', ['url' => url('/register?id=' . $event->id)])
View Event Details
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent