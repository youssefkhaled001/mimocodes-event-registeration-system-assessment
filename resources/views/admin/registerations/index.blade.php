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

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-red-400 shadow-[0_0_10px_rgba(239,68,68,0.5)]"></div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

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

            <!-- Content Card -->
            <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl overflow-hidden">
                <div class="p-8">
                    @if($registerations->count() > 0)
                                    <x-table :columns="['Name', 'Email', 'Status', 'Payment Status']"
                                        :rows="$registerations->map(fn($registeration) => [
                            $registeration->attendee->name,
                            $registeration->attendee->email,
                            [
                                'text' => $registeration->status,
                                'color' => $registeration->status == 'confirmed' ? 'rgba(34, 211, 238, 0.1)' :
                                    ($registeration->status == 'cancelled' ? 'rgba(239, 68, 68, 0.1)' :
                                        ($registeration->status == 'waitlisted' ? 'rgba(156, 163, 175, 0.1)' :
                                            'rgba(59, 130, 246, 0.1)')),
                                'text_color' => $registeration->status == 'confirmed' ? '#22d3ee' :
                                    ($registeration->status == 'cancelled' ? '#ef4444' :
                                        ($registeration->status == 'waitlisted' ? '#9ca3af' :
                                            '#3b82f6'))
                            ],
                            [
                                'text' => $registeration->payment_status,
                                'color' => $registeration->payment_status == 'paid' ? 'rgba(34, 211, 238, 0.1)' :
                                    ($registeration->payment_status == 'refunded' ? 'rgba(239, 68, 68, 0.1)' :
                                        'rgba(59, 130, 246, 0.1)'),
                                'text_color' => $registeration->payment_status == 'paid' ? '#22d3ee' :
                                    ($registeration->payment_status == 'refunded' ? '#ef4444' :
                                        '#3b82f6')
                            ]
                        ])->toArray()"
                                        :ids="$registerations->pluck('id')->toArray()" :actions="[
                            [
                                'label' => 'Update Payment',
                                'onclick' => 'payment-modal'
                            ],
                            [
                                'label' => 'Cancel',
                                'url' => 'registerations.cancel',
                                'method' => 'patch'
                            ]
                        ]" :data-attributes="$registerations->map(fn($reg) => [
                                                                    'data-status' => $reg->status,
                                                                    'data-payment-status' => $reg->payment_status
                                                                ])->toArray()" />

                                    <div class="mt-6">
                                        {{ $registerations->onEachSide(0)->links() }}
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