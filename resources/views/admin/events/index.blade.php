<x-app-layout>
    <div class="py-16 px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-8 p-4 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 rounded-lg backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Header -->
            <div class="mb-12">
                <div
                    class="inline-flex items-center gap-2 text-xs font-medium text-white/50 uppercase tracking-[0.15em] mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></span>
                    <span>Event Management</span>
                </div>
                <h1 class="font-serif text-5xl font-bold text-white mb-4 leading-tight tracking-tight">
                    Created Events
                </h1>
                <p class="text-lg font-light text-white/60 max-w-2xl leading-relaxed">
                    Manage all your events.
                </p>
            </div>

            <!-- Content Card -->
            <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl overflow-hidden">
                <div class="p-8">
                    @if($events->count() > 0)
                                    <x-table :columns="['Title', 'Description', 'Location', 'Date', 'Status', 'Price']"
                                        :rows="$events->map(fn($event) => [
                            $event->title,
                            \Str::limit($event->description, 50),
                            $event->location,
                            $event->date_time->format('M d, Y g:i A'),
                            [
                                'text' => $event->status,
                                'color' => $event->status == 'published' ? 'rgba(34, 211, 238, 0.1)' :
                                    ($event->status == 'cancelled' ? 'rgba(239, 68, 68, 0.1)' :
                                        ($event->status == 'draft' ? 'rgba(156, 163, 175, 0.1)' :
                                            'rgba(59, 130, 246, 0.1)')),
                                'text_color' => $event->status == 'published' ? '#22d3ee' :
                                    ($event->status == 'cancelled' ? '#ef4444' :
                                        ($event->status == 'draft' ? '#9ca3af' :
                                            '#3b82f6'))
                            ],
                            $event->price > 0 ? '$' . number_format($event->price, 2) : 'FREE',
                        ])->toArray()" :actions="[
                            [
                                'label' => 'Edit',
                                'url' => 'edit.event'
                            ],
                            [
                                'label' => 'Delete',
                                'url' => 'delete.event',
                                'method' => 'delete'
                            ],
                            [
                                'label' => 'Registerations',
                                'url' => 'view.event.registerations'
                            ]
                        ]" :ids="$events->pluck('id')->toArray()" />

                                    <div class="mt-6">
                                        {{ $events->onEachSide(0)->links() }}
                                    </div>
                    @else
                        <div class="text-center py-16">
                            <div class="text-6xl mb-6 opacity-20">○</div>
                            <h3 class="font-serif text-2xl font-semibold text-white mb-2 tracking-tight">No Events Yet</h3>
                            <p class="text-white/50 text-sm font-light mb-6">Create your first event to get started.</p>
                            <a href="/admin/create"
                                class="inline-block px-6 py-3 bg-transparent border border-white/20 rounded-md text-white text-sm font-medium tracking-wide transition-all duration-300 hover:bg-cyan-500/10 hover:border-cyan-500/50 hover:text-cyan-400 hover:shadow-[0_0_20px_rgba(0,255,255,0.15)]">
                                + Create Event
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal (placed at page level to avoid overflow clipping) -->
    <x-delete-modal modal-id="deleteModal" />
</x-app-layout>