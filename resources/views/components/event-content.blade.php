<div>
    <!-- Modal Content -->
    <div class="">
        <!-- Status Badge -->
        <div class="mb-6 flex items-center gap-3">
            @if( $event->capacity - $event->registrations->count() <= 0)
            <span
                class="inline-block px-4 py-1.5 bg-red-500/10 border border-red-500/20 rounded-lg text-xs font-semibold text-red-400 uppercase tracking-widest">
                Fully Booked</span>
            <span
                class="inline-block px-4 py-1.5 bg-yellow-500/10 border border-yellow-500/20 rounded-lg text-xs font-semibold text-yellow-400 uppercase tracking-widest">
                Waitlist Available</span>
            @else
            <span
                class="inline-block px-4 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-xs font-semibold text-emerald-400 uppercase tracking-widest">
                Available
            </span>
            @endif
        </div>

        <div class="flex justify-between flex-col gap-1 mb-3">
            <!-- Title -->
            <h2 class="font-serif text-4xl sm:text-5xl font-bold text-white mb-3 leading-tight tracking-tight">
                {{ $event->title }}
            </h2>
            <!-- Date & Time -->
            <div>
                <div class="text-xs text-white/40 uppercase tracking-widest font-medium mb-1">Date & Time</div>
                <div class="text-white/90 text-base font-medium">
                    {{ $event->date_time->format('M d, Y • g:i A') }}
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-8 pb-8 border-b border-white/5">
            <h3 class="text-xs text-white/40 uppercase tracking-widest font-medium mb-4">About This Event</h3>
            <p class="overflow-y-auto max-h-[200px] text-white/70 leading-relaxed text-base font-light">
                {{ $event->description }}
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
                    <div class="text-white/90 text-base font-medium">
                        {{ $event->location }}
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
                    <div class="text-white/90 text-base font-medium">
                        {{ $event->capacity }} attendees
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
                    <div class="text-white/90 text-base font-medium">
                        {{ $event->registrations->where('status', 'confirmed')->count() }} registered
                    </div>
                    <div class="text-sm mt-1">
                        {{ $event->capacity - $event->registrations->where('status', 'confirmed')->count() }} spots left
                    </div>
                </div>
            </div>
        </div>

        <!-- Price & CTA -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <!-- Price -->
            <div>
                <div class="text-xs text-white/40 uppercase tracking-widest font-medium mb-2">Price</div>
                <div class="font-serif text-5xl font-bold text-cyan-400 leading-none">
                    @if($event->price > 0)
                        ${{ number_format($event->price, 2) }}
                    @else
                        FREE
                    @endif
                </div>
            </div>

           
        </div>
    </div>
</div>