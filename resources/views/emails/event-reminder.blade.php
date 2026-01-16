<x-mail::message>
    # Event Reminder: Tomorrow! ⏰

    Hello **{{ $attendee->name }}**,

    This is a friendly reminder that **{{ $event->title }}** is happening tomorrow!

    <x-mail::panel>
        ## Event Details

        **Event:** {{ $event->title }}
        **Date & Time:** {{ $event->date_time->format('l, F j, Y \a\t g:i A') }}
        **Location:** {{ $event->location }}
        **Your Status:** Confirmed ✓
    </x-mail::panel>

    ### What to bring:
    - Your confirmation (this email)
    - Valid ID
    - Any materials mentioned in the event description

    ### Getting there:
    **Location:** {{ $event->location }}

    We recommend arriving 15 minutes early to check in.

    @if($event->price > 0 && $registration->payment_status === 'pending')
        <x-mail::panel>
            ⚠️ **Payment Reminder**

            Your payment status is currently **pending**. Please complete your payment before the event.
        </x-mail::panel>
    @endif

    We're looking forward to seeing you tomorrow!

    <x-mail::button :url="url('/')">
        View Event Details
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>