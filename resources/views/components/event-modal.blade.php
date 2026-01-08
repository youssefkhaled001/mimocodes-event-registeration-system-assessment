<!-- Event Details Modal -->
<div id="eventModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-8">
    <!-- Backdrop -->
    <div onclick="closeEventModal()"
        class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity duration-300" id="modalBackdrop"></div>

    <!-- Modal Container -->
    <div class="relative w-full max-w-4xl max-h-[90vh] overflow-x-hidden bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl shadow-[0_20px_80px_rgba(0,255,255,0.15)] transition-all duration-300 transform"
        id="modalContent">
        <!-- Gradient top border -->
        <div
            class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent">
        </div>

        <!-- Close Button -->
        <button onclick="closeEventModal()"
            class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-white/60 hover:text-white hover:bg-white/10 hover:border-cyan-500/30 transition-all duration-300 z-10"
            aria-label="Close modal">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Modal Content -->
        <div class="p-8 sm:p-12">
            <!-- Status Badge -->
            <div class="mb-6 flex items-center gap-3">
                <span id="modalStatus"
                    class="inline-block px-4 py-1.5 bg-cyan-500/10 border border-cyan-500/20 rounded-lg text-xs font-semibold text-cyan-400 uppercase tracking-widest">
                    Open
                </span>
                <span id="modalAvailability"
                    class="inline-block px-4 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-xs font-semibold text-emerald-400 uppercase tracking-widest">
                    <!-- Dynamic availability status -->
                </span>
            </div>

            <div class="flex justify-between md:flex-row flex-col">
                <!-- Title -->

                <h2 id="modalTitle"
                    class="font-serif text-4xl sm:text-5xl font-bold text-white mb-6 leading-tight tracking-tight">
                    Event Title
                </h2>
                <!-- Date & Time -->
                <div>
                    <div class="text-xs text-white/40 uppercase tracking-widest font-medium mb-1">Date & Time</div>
                    <div id="modalDate" class="text-white/90 text-base font-medium">
                        NA
                    </div>
                </div>
            </div>



            <!-- Description -->
            <div class="mb-8 pb-8 border-b border-white/5">
                <h3 class="text-xs text-white/40 uppercase tracking-widest font-medium mb-4">About This Event</h3>
                <p id="modalDescription"
                    class="overflow-y-auto max-h-[200px] text-white/70 leading-relaxed text-base font-light">
                    Event description will appear here...
                </p>
            </div>

            <!-- Event Details Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8 pb-8 border-b border-white/5">
                <!-- Location -->
                <div class="flex items-start gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-cyan-500/5 border border-cyan-500/10 flex items-center justify-center text-cyan-400 text-xl flex-shrink-0">
                        📍
                    </div>
                    <div class="pt-1">
                        <div class="text-xs text-white/40 uppercase tracking-widest font-medium mb-2">Location</div>
                        <div id="modalLocation" class="text-white/90 text-base font-medium">
                            Location details
                        </div>
                    </div>
                </div>

                <!-- Capacity -->
                <div class="flex items-start gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-cyan-500/5 border border-cyan-500/10 flex items-center justify-center text-cyan-400 text-xl flex-shrink-0">
                        👥
                    </div>
                    <div class="pt-1">
                        <div class="text-xs text-white/40 uppercase tracking-widest font-medium mb-2">Capacity</div>
                        <div id="modalCapacity" class="text-white/90 text-base font-medium">
                            100 attendees
                        </div>
                    </div>
                </div>

                <!-- Registrations -->
                <div class="flex items-start gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-cyan-500/5 border border-cyan-500/10 flex items-center justify-center text-cyan-400 text-xl flex-shrink-0">
                        ✓
                    </div>
                    <div class="pt-1">
                        <div class="text-xs text-white/40 uppercase tracking-widest font-medium mb-2">Registrations
                        </div>
                        <div id="modalRegistrations" class="text-white/90 text-base font-medium">
                            0 registered
                        </div>
                        <div id="modalSpotsLeft" class="text-sm mt-1">
                            <!-- Dynamic spots left -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price & CTA -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <!-- Price -->
                <div>
                    <div class="text-xs text-white/40 uppercase tracking-widest font-medium mb-2">Price</div>
                    <div id="modalPrice" class="font-serif text-5xl font-bold text-cyan-400 leading-none">
                        $0.00
                    </div>
                </div>

                <!-- Register Button -->
                <a id="modalRegisterBtn" href="#"
                    class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 rounded-lg text-white text-base font-semibold tracking-wide transition-all duration-300 hover:from-cyan-500/30 hover:to-blue-500/30 hover:border-cyan-500/50 hover:shadow-[0_0_40px_rgba(0,255,255,0.3)] hover:scale-105 text-center">
                    Register for Event
                </a>
            </div>
        </div>


    </div>
</div>

<style>
    /* Modal animations */
    @keyframes modalFadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes modalSlideUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    #eventModal.show {
        display: flex !important;
        animation: modalFadeIn 0.3s ease-out;
    }

    #eventModal.show #modalContent {
        animation: modalSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
</style>

<script>
    function openEventModal(eventId) {
        // Find the button that was clicked to get event data
        const button = document.querySelector(`button[data-event-id="${eventId}"]`);

        if (!button) return;

        // Get event data from data attributes
        const eventData = {
            id: button.dataset.eventId,
            title: button.dataset.eventTitle,
            description: button.dataset.eventDescription,
            date: button.dataset.eventDate,
            location: button.dataset.eventLocation,
            capacity: parseInt(button.dataset.eventCapacity),
            price: parseFloat(button.dataset.eventPrice),
            status: button.dataset.eventStatus,
            registrations: parseInt(button.dataset.eventRegisterations)
        };

        // Calculate availability
        const spotsLeft = eventData.capacity - eventData.registrations;
        const isFull = spotsLeft <= 0;
        const isAlmostFull = spotsLeft > 0 && spotsLeft <= eventData.capacity * 0.2; // Less than 20% left

        // Populate modal with event data
        document.getElementById('modalTitle').textContent = eventData.title;
        document.getElementById('modalDescription').textContent = eventData.description || 'No description available.';
        document.getElementById('modalDate').textContent = eventData.date;
        document.getElementById('modalLocation').textContent = eventData.location;
        document.getElementById('modalCapacity').textContent = `${eventData.capacity} attendees`;

        // Update status badge
        const statusBadge = document.getElementById('modalStatus');
        statusBadge.textContent = eventData.status;

        // Reset status badge classes
        statusBadge.className = 'inline-block px-4 py-1.5 rounded-lg text-xs font-semibold uppercase tracking-widest';

        // Apply status-specific styling
        if (eventData.status.toLowerCase() === 'open') {
            statusBadge.classList.add('bg-cyan-500/10', 'border', 'border-cyan-500/20', 'text-cyan-400');
        } else if (eventData.status.toLowerCase() === 'closed' || eventData.status.toLowerCase() === 'finished') {
            statusBadge.classList.add('bg-red-500/10', 'border', 'border-red-500/20', 'text-red-400');
        } else if (eventData.status.toLowerCase() === 'cancelled') {
            statusBadge.classList.add('bg-gray-500/10', 'border', 'border-gray-500/20', 'text-gray-400');
        } else {
            statusBadge.classList.add('bg-yellow-500/10', 'border', 'border-yellow-500/20', 'text-yellow-400');
        }

        // Update availability badge
        const availabilityBadge = document.getElementById('modalAvailability');
        availabilityBadge.className = 'inline-block px-4 py-1.5 rounded-lg text-xs font-semibold uppercase tracking-widest';

        if (isFull) {
            availabilityBadge.textContent = 'Event Full';
            availabilityBadge.classList.add('bg-red-500/10', 'border', 'border-red-500/20', 'text-red-400');
        } else if (isAlmostFull) {
            availabilityBadge.textContent = 'Almost Full';
            availabilityBadge.classList.add('bg-yellow-500/10', 'border', 'border-yellow-500/20', 'text-yellow-400');
        } else {
            availabilityBadge.textContent = 'Spots Available';
            availabilityBadge.classList.add('bg-emerald-500/10', 'border', 'border-emerald-500/20', 'text-emerald-400');
        }

        // Update registrations info
        document.getElementById('modalRegistrations').textContent = `${eventData.registrations} registered`;

        const spotsLeftElement = document.getElementById('modalSpotsLeft');
        if (isFull) {
            spotsLeftElement.textContent = 'No spots available';
            spotsLeftElement.className = 'text-sm mt-1 text-red-400 font-medium';
        } else if (isAlmostFull) {
            spotsLeftElement.textContent = `Only ${spotsLeft} spot${spotsLeft === 1 ? '' : 's'} left!`;
            spotsLeftElement.className = 'text-sm mt-1 text-yellow-400 font-medium';
        } else {
            spotsLeftElement.textContent = `${spotsLeft} spot${spotsLeft === 1 ? '' : 's'} available`;
            spotsLeftElement.className = 'text-sm mt-1 text-emerald-400/80';
        }

        // Format and display price
        const priceElement = document.getElementById('modalPrice');
        if (eventData.price > 0) {
            priceElement.textContent = `$${eventData.price.toFixed(2)}`;
            priceElement.classList.remove('text-emerald-400');
            priceElement.classList.add('text-cyan-400');
        } else {
            priceElement.textContent = 'FREE';
            priceElement.classList.remove('text-cyan-400');
            priceElement.classList.add('text-emerald-400');
        }

        // Update register button
        const registerBtn = document.getElementById('modalRegisterBtn');
        registerBtn.href = `/register?id=${eventData.id}`;

        // Reset button classes
        registerBtn.className = 'w-full sm:w-auto px-10 py-4 rounded-lg text-base font-semibold tracking-wide transition-all duration-300 text-center';

        // Update button based on event status
        if (isFull || eventData.status.toLowerCase() === 'closed' || eventData.status.toLowerCase() === 'finished') {
            registerBtn.textContent = isFull ? 'Event Full' : 'Registration Closed';
            registerBtn.classList.add('bg-gray-500/10', 'border', 'border-gray-500/20', 'text-gray-400', 'cursor-not-allowed', 'opacity-60');
            registerBtn.onclick = (e) => e.preventDefault();
        } else if (eventData.status.toLowerCase() === 'cancelled') {
            registerBtn.textContent = 'Event Cancelled';
            registerBtn.classList.add('bg-red-500/10', 'border', 'border-red-500/20', 'text-red-400', 'cursor-not-allowed', 'opacity-60');
            registerBtn.onclick = (e) => e.preventDefault();
        } else {
            registerBtn.textContent = isAlmostFull ? 'Register Now - Limited Spots!' : 'Register for Event';
            registerBtn.classList.add('bg-gradient-to-r', 'from-cyan-500/20', 'to-blue-500/20', 'border', 'border-cyan-500/30', 'text-white', 'hover:from-cyan-500/30', 'hover:to-blue-500/30', 'hover:border-cyan-500/50', 'hover:shadow-[0_0_40px_rgba(0,255,255,0.3)]', 'hover:scale-105');
            registerBtn.onclick = null;
        }

        // Show modal
        const modal = document.getElementById('eventModal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEventModal() {
        const modal = document.getElementById('eventModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeEventModal();
        }
    });
</script>