<x-app-layout>
    <div class="py-7 px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-12">
                <div
                    class="inline-flex items-center gap-2 text-xs font-medium text-white/50 uppercase tracking-[0.15em] mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></span>
                    <span>Event Management</span>
                </div>
                <h1 class="font-serif text-5xl font-bold text-white mb-4 leading-tight tracking-tight">
                    Events Dashboard
                </h1>
                <p class="text-lg font-light text-white/60 max-w-2xl leading-relaxed">
                    Manage and monitor all your events across different statuses.
                </p>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-8 border-b border-white/[0.08]">
                <div class="flex gap-1 overflow-x-auto">
                    <a href="{{ route('event.index') }}?status=all"
                        class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'all' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                        All Events
                    </a>
                    <a href="{{ route('event.index') }}?status=published"
                        class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'published' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                        Published
                    </a>
                    <a href="{{ route('event.index') }}?status=draft"
                        class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'draft' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                        Draft
                    </a>
                    <a href="{{ route('event.index') }}?status=completed"
                        class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'completed' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                        Completed
                    </a>
                    <a href="{{ route('event.index') }}?status=cancelled"
                        class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'cancelled' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                        Cancelled
                    </a>
                </div>
            </div>

            <!-- Content Card -->
            <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl overflow-hidden">
                <div class="p-8">
                    @if ($events->count() > 0)
                                    <x-table :columns="[
                            'Title',
                            //'Description', // Removed as it takes space and not important
                            'Location',
                            'Date',
                            'Status',
                            'Price',
                            'Revenue',
                        ]" :rows="$events
                            ->map(fn($event) => [
                                $event->title,
                                //\Str::limit($event->description, 50),
                                $event->location,
                                $event->date_time->format('M d, Y g:i A'),
                                [
                                    'text' => ucfirst($event->status),
                                    'color' => [
                                        'Published' => 'rgba(34, 211, 238, 0.1)',
                                        'Cancelled' => 'rgba(239, 68, 68, 0.1)',
                                        'Draft' => 'rgba(156, 163, 175, 0.1)',
                                        'Completed' => 'rgba(59, 130, 246, 0.1)',
                                    ],
                                    'text_color' => [
                                        'Published' => '#22d3ee',
                                        'Cancelled' => '#ef4444',
                                        'Draft' => '#9ca3af',
                                        'Completed' => '#3b82f6',
                                    ]
                                ],
                                $event->price > 0 ? '$' . number_format($event->price, 2) : 'FREE',
                                // Show revenue only for published and completed events
                                in_array($event->status, ['published', 'completed'])
                                ? '$' . number_format($event->total_revenue, 2)
                                : '-',
                            ])
                            ->toArray()" :actions="$status == 'cancelled' || $status == 'completed' ? [] : [
                            [
                                'label' => 'Edit',
                                'icon_name' => 'edit',
                                'url' => 'event.edit',
                            ],
                            [
                                'label' => 'Delete',
                                'icon_name' => 'delete',
                                'url' => 'event.delete',
                                'method' => 'delete',
                            ],
                            [
                                'label' => 'Registrations',
                                'icon_name' => 'users',
                                'url' => 'registerations.index',
                            ],
                        ]" :ids="$events->pluck('id')->toArray()" />

                                    <div class="mt-6">
                                        {{ $events->appends(['status' => $status])->onEachSide(0)->links() }}
                                    </div>
                    @else
                        <div class="text-center py-16">
                            <div class="text-6xl mb-6 opacity-20">○</div>
                            <h3 class="font-serif text-2xl font-semibold text-white mb-2 tracking-tight">
                                No {{ ucfirst($status) }} Events
                            </h3>
                            <p class="text-white/50 text-sm font-light mb-6">
                                @if ($status === 'all')
                                    Create your first event to get started.
                                @else
                                    No events found with {{ $status }} status.
                                @endif
                            </p>
                            <a href="{{ route('event.create') }}"
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