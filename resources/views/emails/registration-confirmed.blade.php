<x-mail::message>
    # Registration Confirmed! 🎉

    Hello **{{ $attendee->name }}**,

    Great news! Your registration for **{{ $event->title }}** has been confirmed.

    <x-mail::panel>
        ## Event Details

        **Event:** {{ $event->title }}
        **Date & Time:** {{ $event->date_time->format('l, F j, Y \a\t g:i A') }}
        **Location:** {{ $event->location }}
        **Price:** {{ $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free' }}
        **Status:** Confirmed ✓
    </x-mail::panel>

    @if($event->price > 0)
        ### Payment Information
        **Payment Status:** {{ ucfirst($registration->payment_status) }}

        @if($registration->payment_status === 'pending')
            Please complete your payment to secure your spot.
        @endif
    @endif

    We're excited to see you at the event! You'll receive a reminder 24 hours before the event starts.

    If you have any questions, feel free to reach out to us.

    <x-mail::button :url="url('/')">
        View Event Details
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>