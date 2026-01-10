@props(['modalId' => 'paymentStatusModal'])

<!-- Payment Status Update Modal -->
<div id="{{ $modalId }}" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50"
    onclick="if(event.target === this) closePaymentModal()">
    <div class="bg-[#0a0a0a] border border-white/10 rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl"
        onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></div>
                <h3 class="font-serif text-2xl font-semibold text-white tracking-tight">Update Payment Status</h3>
            </div>
            <p class="text-white/50 text-sm font-light ml-5">Change the payment status for this registration.</p>
        </div>

        <!-- Form -->
        <form id="paymentStatusForm" method="POST" action="">
            @csrf
            @method('PATCH')

            <!-- Current Status Display -->
            <div class="mb-6 p-4 bg-white/[0.02] border border-white/[0.08] rounded-lg">
                <div class="text-xs text-white/50 mb-1">Current Status</div>
                <div class="text-white font-medium" id="currentRegistrationStatus"></div>
            </div>

            <!-- Payment Status Select -->
            <div class="mb-6">
                <label for="payment_status" class="block text-sm font-medium text-white/70 mb-2">
                    New Payment Status
                </label>
                <select id="payment_status" name="payment_status"
                    class="w-full px-4 py-3 bg-white/[0.02] border border-white/[0.08] rounded-lg text-white focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all">
                    <option value="">Select payment status...</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>

            <!-- Warning Message -->
            <div id="paymentWarning" class="hidden mb-6 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-yellow-400 text-sm" id="paymentWarningText"></p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3">
                <button type="button" onclick="closePaymentModal()"
                    class="flex-1 px-6 py-3 bg-transparent border border-white/20 rounded-lg text-white text-sm font-medium tracking-wide transition-all duration-300 hover:bg-white/5 hover:border-white/30">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-cyan-500/10 border border-cyan-500/50 rounded-lg text-cyan-400 text-sm font-medium tracking-wide transition-all duration-300 hover:bg-cyan-500/20 hover:shadow-[0_0_20px_rgba(0,255,255,0.15)]">
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentRegistrationData = {};

    function openPaymentModal(registrationId, registrationStatus, paymentStatus) {
        currentRegistrationData = {
            id: registrationId,
            status: registrationStatus,
            paymentStatus: paymentStatus
        };

        const modal = document.getElementById('{{ $modalId }}');
        const form = document.getElementById('paymentStatusForm');
        const statusDisplay = document.getElementById('currentRegistrationStatus');
        const paymentSelect = document.getElementById('payment_status');
        const warning = document.getElementById('paymentWarning');

        // Update form action
        form.action = `/admin/registrations/${registrationId}/payment-status`;

        // Display current status
        statusDisplay.innerHTML = `
            <span class="text-sm">Registration: <span class="text-cyan-400">${registrationStatus}</span></span>
            <span class="text-white/30 mx-2">•</span>
            <span class="text-sm">Payment: <span class="text-cyan-400">${paymentStatus}</span></span>
        `;

        // Reset select and warning
        paymentSelect.value = '';
        warning.classList.add('hidden');

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePaymentModal() {
        const modal = document.getElementById('{{ $modalId }}');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Validate payment status changes based on registration status
    document.getElementById('payment_status')?.addEventListener('change', function () {
        const warning = document.getElementById('paymentWarning');
        const warningText = document.getElementById('paymentWarningText');
        const newPaymentStatus = this.value;
        const registrationStatus = currentRegistrationData.status;

        warning.classList.add('hidden');

        // Business logic validation
        if (registrationStatus === 'waitlisted' && newPaymentStatus === 'paid') {
            warningText.textContent = 'Waitlisted registrations cannot be marked as paid. Please confirm the registration first.';
            warning.classList.remove('hidden');
            this.value = '';
        } else if (registrationStatus === 'cancelled' && newPaymentStatus === 'paid') {
            warningText.textContent = 'Cancelled registrations cannot be marked as paid.';
            warning.classList.remove('hidden');
            this.value = '';
        } else if (currentRegistrationData.paymentStatus === 'paid' && newPaymentStatus === 'refunded' && registrationStatus === 'confirmed') {
            warningText.textContent = 'To refund a confirmed registration, please cancel the registration first.';
            warning.classList.remove('hidden');
            this.value = '';
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closePaymentModal();
        }
    });
</script>