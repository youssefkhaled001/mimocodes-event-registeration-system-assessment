@props(['events'])

<!-- Modal -->
<div id="eventModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-8">
    <!-- Backdrop -->
    <div onclick="closeEventModal()" class="absolute inset-0 bg-black/80 backdrop-blur-md"></div>

    <!-- Modal Container -->
    <div class="relative w-full max-w-4xl max-h-[90vh] overflow-y-auto bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl shadow-[0_20px_80px_rgba(0,255,255,0.15)]">
        
        <!-- Gradient top border -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>

        <!-- Close Button -->
        <button onclick="closeEventModal()"
            class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-white/60 hover:text-white hover:bg-white/10 hover:border-cyan-500/30 transition-all duration-300 z-10"
            aria-label="Close modal">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Event Content - One for each event, hidden by default -->
        @foreach($events as $event)
            <div id="event-content-{{ $event->id }}" class="hidden p-8 sm:p-12">
                <x-event-content :event="$event" />
                 <!-- Register Button -->
                <div class="flex justify-center my-3">
                     <a href="/register?id={{ $event->id }}"
                        class="w-full sm:w-auto px-10 py-4 rounded-lg text-base font-semibold tracking-wide transition-all duration-300 text-center bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 text-white hover:from-cyan-500/30 hover:to-blue-500/30 hover:border-cyan-500/50 hover:shadow-[0_0_40px_rgba(0,255,255,0.3)] hover:scale-105">
                        Register for Event
                </a>
                </div>  
            </div>
        @endforeach
    </div>
</div>

<script>
    // Function to open modal and show specific event
    function openEventModal(eventId) {
        // Hide all event contents first
        document.querySelectorAll('[id^="event-content-"]').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Show the selected event content
        const eventContent = document.getElementById('event-content-' + eventId);
        if (eventContent) {
            eventContent.classList.remove('hidden');
        }
        
        // Show the modal
        const modal = document.getElementById('eventModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    // Function to close modal
    function closeEventModal() {
        const modal = document.getElementById('eventModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        // Restore body scroll
        document.body.style.overflow = '';
    }

    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEventModal();
        }
    });
</script>

{{ $slot }}