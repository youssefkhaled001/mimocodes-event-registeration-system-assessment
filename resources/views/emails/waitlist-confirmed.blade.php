<x-mail::message>
    # Added to Waitlist

    Hello **{{ $attendee->name }}**,

    Thank you for your interest in **{{ $event->title }}**!

    <x-mail::panel>
        ## Event Details

        **Event:** {{ $event->title }}
        **Date & Time:** {{ $event->date_time->format('l, F j, Y \a\t g:i A') }}
        **Location:** {{ $event->location }}
        **Price:** {{ $event->price > 0 ? '$' . number_format($event->price, 2) : 'Free' }}
        **Status:** Waitlisted
    </x-mail::panel>

    Unfortunately, this event has reached full capacity. However, you've been added to the waitlist and will be
    automatically confirmed if a spot becomes available.

    ### What happens next?

    - You'll receive an email immediately if a spot opens up
    - Your position on the waitlist is secured
    - No action is needed from you at this time

    We'll keep you updated on your waitlist status.

    <x-mail::button :url="url('/')">
        Browse Other Events
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>