<x-app-layout>
    <div class="py-7 px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Header -->
            <div class="mb-12">
                <div
                    class="inline-flex items-center gap-2 text-xs font-medium text-white/50 uppercase tracking-[0.15em] mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></span>
                    <span>Registrations Management</span>
                </div>
                <h1 class="font-serif text-5xl font-bold text-white mb-4 leading-tight tracking-tight">
                    Registrations for "{{ $event->title }}"
                </h1>
                <p class="text-lg font-light text-white/60 max-w-2xl leading-relaxed">
                    Manage all registrations for this event.
                </p>
            </div>

            <!-- Dual Filter Tabs -->
            <div class="mb-8 space-y-4 flex flex-col justify-between lg:flex-row">
                <!-- Registration Status Tabs -->
                <div>
                    <p class="text-xs text-white/50 uppercase tracking-wider mb-2">Registration Status</p>
                    <div class="border-b border-white/[0.08]">
                        <div class="flex gap-1 overflow-x-auto">
                            <a href="{{ route('registerations.index', ['event' => $event->id, 'status' => 'all', 'payment_status' => $paymentStatus]) }}"
                                class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'all' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                                All
                            </a>
                            <a href="{{ route('registerations.index', ['event' => $event->id, 'status' => 'confirmed', 'payment_status' => $paymentStatus]) }}"
                                class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'confirmed' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                                Confirmed
                            </a>
                            <a href="{{ route('registerations.index', ['event' => $event->id, 'status' => 'waitlisted', 'payment_status' => $paymentStatus]) }}"
                                class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'waitlisted' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                                Waitlisted
                            </a>
                            <a href="{{ route('registerations.index', ['event' => $event->id, 'status' => 'cancelled', 'payment_status' => $paymentStatus]) }}"
                                class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $status === 'cancelled' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                                Cancelled
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Tabs -->
                <div>
                    <p class="text-xs text-white/50 uppercase tracking-wider mb-2">Payment Status</p>
                    <div class="border-b border-white/[0.08]">
                        <div class="flex gap-1 overflow-x-auto">
                            <a href="{{ route('registerations.index', ['event' => $event->id, 'status' => $status, 'payment_status' => 'all']) }}"
                                class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $paymentStatus === 'all' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                                All
                            </a>
                            <a href="{{ route('registerations.index', ['event' => $event->id, 'status' => $status, 'payment_status' => 'paid']) }}"
                                class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $paymentStatus === 'paid' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                                Paid
                            </a>
                            <a href="{{ route('registerations.index', ['event' => $event->id, 'status' => $status, 'payment_status' => 'pending']) }}"
                                class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $paymentStatus === 'pending' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                                Pending
                            </a>
                            <a href="{{ route('registerations.index', ['event' => $event->id, 'status' => $status, 'payment_status' => 'refunded']) }}"
                                class="px-6 py-3 text-sm font-medium transition-all duration-200 border-b-2 {{ $paymentStatus === 'refunded' ? 'border-cyan-400 text-cyan-400' : 'border-transparent text-white/60 hover:text-white/80 hover:border-white/20' }}">
                                Refunded
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Card -->
            <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl overflow-hidden">
                <div class="p-8">
                    @if($registerations->count() > 0)
                                    <x-table :columns="['Name', 'Email', 'Status', 'Payment Status']"
                                        :rows="$registerations->map(fn($registeration) => [
                            $registeration->attendee->name,
                            $registeration->attendee->email,
                            [
                                'text' => ucfirst($registeration->status),
                                'color' => [
                                    'Confirmed' => 'rgba(34, 211, 238, 0.1)',
                                    'Cancelled' => 'rgba(239, 68, 68, 0.1)',
                                    'Waitlisted' => 'rgba(156, 163, 175, 0.1)',
                                    'Pending' => 'rgba(59, 130, 246, 0.1)'
                                ],
                                'text_color' => [
                                    'Confirmed' => '#22d3ee',
                                    'Cancelled' => '#ef4444',
                                    'Waitlisted' => '#9ca3af',
                                    'Pending' => '#3b82f6'
                                ],
                            ],
                            [
                                'text' => ucfirst($registeration->payment_status),
                                'color' => [
                                    'Paid' => 'rgba(34, 211, 238, 0.1)',
                                    'Refunded' => 'rgba(239, 68, 68, 0.1)',
                                    'Pending' => 'rgba(59, 130, 246, 0.1)'
                                ],
                                'text_color' => [
                                    'Paid' => '#22d3ee',
                                    'Refunded' => '#ef4444',
                                    'Pending' => '#3b82f6'
                                ],
                            ]
                        ])->toArray()" :ids="$registerations->pluck('id')->toArray()" :actions="[
                            [
                                'label' => 'Update Payment',
                                'icon_name' => 'edit',
                                'onclick' => 'payment-modal'
                            ],
                            [
                                'label' => 'Cancel',
                                'icon_name' => 'delete',
                                'url' => 'registerations.cancel',
                                'method' => 'patch'
                            ]
                        ]" :data-attributes="$registerations->map(fn($reg) => [
                                                                                                                                                                                                                                                                                                                    'data-status' => $reg->status,
                                                                                                                                                                                                                                                                                                                    'data-payment-status' => $reg->payment_status
                                                                                                                                                                                                                                                                                                                ])->toArray()" />

                                    <div class="mt-6">
                                        {{ $registerations->appends(['status' => $status, 'payment_status' => $paymentStatus])->onEachSide(0)->links() }}
                                    </div>
                    @else
                        <div class="text-center py-16">
                            <div class="text-6xl mb-6 opacity-20">○</div>
                            <h3 class="font-serif text-2xl font-semibold text-white mb-2 tracking-tight">No Registerations
                                Yet
                            </h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Status Modal -->
    <x-payment-status-modal modal-id="paymentStatusModal" />

    <!-- Cancel Registration Modal -->
    <x-delete-modal modal-id="deleteModal" title="Cancel Registration"
        message="Are you sure you want to cancel this registration? This action cannot be undone."
        confirmText="Cancel Registration" />

    <script>
        // Handle payment modal opening from table actions
        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-action="payment-modal"]')) {
                const button = e.target.closest('[data-action="payment-modal"]');
                const row = button.closest('tr');
                const registrationId = button.getAttribute('data-id');
                const status = row.getAttribute('data-status');
                const paymentStatus = row.getAttribute('data-payment-status');

                openPaymentModal(registrationId, status, paymentStatus);
            }
        });
    </script>
</x-app-layout>