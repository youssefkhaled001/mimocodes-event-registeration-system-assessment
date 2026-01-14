<x-public-layout>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-7">
        <div class="w-full max-w-7xl">
            <!-- Back Button -->
            <a href="{{ route('index') }}"
                class="inline-flex items-center gap-2 text-white/60 hover:text-cyan-400 transition-colors duration-300 mb-8 group animate-fadeInUp">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="text-sm font-medium tracking-wide">Back to Events</span>
            </a>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Event Details Card -->
                <div
                    class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-2xl p-8 lg:p-10 animate-fadeInUp delay-100">
                    <!-- Event Badge -->
                    <div
                        class="inline-flex items-center gap-2 text-xs font-medium text-white/50 uppercase tracking-[0.15em] mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></span>
                        <span>Event Details</span>
                    </div>

                    @if(isset($event))
                        <x-event-content :event="$event" />
                    @else
                        <!-- No Event Selected -->
                        <div class="text-center py-12">
                            <div class="text-5xl mb-4 opacity-30">⚠️</div>
                            <h2 class="font-serif text-3xl font-semibold text-white mb-3 tracking-tight">No Event Selected
                            </h2>
                            <p class="text-white/50 text-base">Please select an event from the events page.</p>
                            <a href="{{ route('index') }}"
                                class="inline-block mt-6 px-6 py-3 bg-cyan-500/10 border border-cyan-500/30 rounded-lg text-cyan-400 text-sm font-medium tracking-wide transition-all duration-300 hover:bg-cyan-500/20 hover:border-cyan-500/50">
                                Browse Events
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Registration Form Card -->
                <div
                    class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-2xl p-8 lg:p-10 animate-fadeInUp delay-200">
                    <!-- Form Badge -->
                    <div
                        class="inline-flex items-center gap-2 text-xs font-medium text-white/50 uppercase tracking-[0.15em] mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></span>
                        <span>Registration Form</span>
                    </div>

                    <h2 class="font-serif text-3xl font-bold text-white mb-2 leading-tight tracking-tight">
                        Secure Your Spot
                    </h2>
                    <p class="text-white/50 text-sm mb-8">
                        Choose your registration type below.
                    </p>

                    @if(isset($event))
                        <!-- Tab Navigation -->
                        <div class="flex gap-2 mb-8 p-1 bg-white/[0.02] border border-white/[0.08] rounded-lg">
                            <button type="button" onclick="switchTab('new')" id="newTab"
                                class="tab-button flex-1 px-6 py-3 rounded-md text-sm font-medium tracking-wide transition-all duration-300 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 text-white shadow-[0_0_20px_rgba(0,255,255,0.15)]">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    New User
                                </span>
                            </button>
                            <button type="button" onclick="switchTab('existing')" id="existingTab"
                                class="tab-button flex-1 px-6 py-3 rounded-md text-sm font-medium tracking-wide transition-all duration-300 text-white/60 hover:text-white/80 hover:bg-white/[0.03]">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Existing User
                                </span>
                            </button>
                        </div>

                        <!-- New User Form -->
                        <form id="newUserForm" method="POST" action="{{ route('register.store') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="registration_type" value="new">

                            <!-- Name Field -->
                            <div class="animate-fadeInUp delay-250">
                                <label for="new_name" class="block text-sm font-medium text-white/70 mb-2 tracking-wide">
                                    Full Name <span class="text-red-400">*</span>
                                </label>
                                <input type="text" id="new_name" name="name" required placeholder="John Doe"
                                    class="input-field" value="{{ old('name') }}">
                                <p class="text-xs text-white/40 mt-2">Enter your full legal name</p>
                                <p class="text-red-600 text-sm">
                                    @error("name")
                                        {{ $message }}
                                    @enderror
                                </p>
                            </div>

                            <!-- Email Field -->
                            <div class="animate-fadeInUp delay-300">
                                <label for="new_email" class="block text-sm font-medium text-white/70 mb-2 tracking-wide">
                                    Email Address <span class="text-red-400">*</span>
                                </label>
                                <input type="email" id="new_email" name="email" required placeholder="john@example.com"
                                    class="input-field" value="{{ old('email') }}">
                                <p class="text-xs text-white/40 mt-2">We'll send confirmation to this email</p>
                                <p class="text-red-600 text-sm">
                                    @error("email")
                                        {{ $message }}
                                    @enderror
                                </p>
                            </div>

                            <!-- Phone Field -->
                            <div class="animate-fadeInUp delay-350">
                                <label for="new_phone" class="block text-sm font-medium text-white/70 mb-2 tracking-wide">
                                    Phone Number
                                </label>
                                <input type="phone" id="new_phone" name="phone" placeholder="+20123456789"
                                    class="input-field" value="{{ old('phone') }}">
                                <p class="text-xs text-white/40 mt-2">Include country code</p>
                                <p class="text-red-600 text-sm">
                                    @error("phone")
                                        Please enter a valid phone number
                                    @enderror
                                </p>
                            </div>

                            <!-- Company Field (Optional) -->
                            <div class="animate-fadeInUp delay-400">
                                <label for="new_company" class="block text-sm font-medium text-white/70 mb-2 tracking-wide">
                                    Company / Organization
                                    <span class="text-white/40 text-xs font-normal">(Optional)</span>
                                </label>
                                <input type="text" id="new_company" name="company" placeholder="Acme Inc."
                                    class="input-field" value="{{ old('company') }}">
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="animate-fadeInUp delay-450">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" id="new_terms" name="terms" required
                                        class="mt-1 w-5 h-5 rounded border-white/20 bg-white/5 text-cyan-500 focus:ring-2 focus:ring-cyan-500/50 focus:ring-offset-0 transition-all duration-300">
                                    <span
                                        class="text-sm text-white/60 group-hover:text-white/80 transition-colors duration-300">
                                        I agree to the terms and conditions and understand the event policies. <span
                                            class="text-red-400">*</span>
                                    </span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4 animate-fadeInUp delay-500">
                                <button type="submit" id="newSubmitBtn"
                                    class="w-full px-8 py-4 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 rounded-lg text-white text-base font-semibold tracking-wide transition-all duration-300 hover:from-cyan-500/30 hover:to-blue-500/30 hover:border-cyan-500/50 hover:shadow-[0_0_30px_rgba(0,255,255,0.2)] hover:-translate-y-0.5 active:translate-y-0">
                                    <span id="newBtnText">Complete Registration</span>
                                </button>
                                <p class="text-xs text-white/40 text-center mt-3">
                                    <span class="text-red-400">*</span> Required fields
                                </p>
                            </div>
                        </form>

                        <!-- Existing User Form (Hidden by default) -->
                        <form id="existingUserForm" method="POST" action="{{ route('register.store') }}"
                            class="space-y-6 hidden">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="registration_type" value="existing">

                            <!-- Info Message -->
                            <div class="bg-cyan-500/10 border border-cyan-500/20 rounded-lg p-4 animate-fadeInUp">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-cyan-400 text-sm font-medium mb-1">Already have an account?</p>
                                        <p class="text-white/60 text-xs leading-relaxed">
                                            Simply enter your registered email address. We'll use your existing information
                                            to complete the registration.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="animate-fadeInUp delay-250">
                                <label for="existing_email"
                                    class="block text-sm font-medium text-white/70 mb-2 tracking-wide">
                                    Email Address <span class="text-red-400">*</span>
                                </label>
                                <input type="email" id="existing_email" name="email" required placeholder="john@example.com"
                                    class="input-field" value="{{ old('email') }}">
                                <p class="text-xs text-white/40 mt-2">Enter the email you previously registered with</p>
                                <p class="text-red-600 text-sm">
                                    @error("email")
                                        {{ $message }}
                                    @enderror
                                </p>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="animate-fadeInUp delay-300">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" id="existing_terms" name="terms" required
                                        class="mt-1 w-5 h-5 rounded border-white/20 bg-white/5 text-cyan-500 focus:ring-2 focus:ring-cyan-500/50 focus:ring-offset-0 transition-all duration-300">
                                    <span
                                        class="text-sm text-white/60 group-hover:text-white/80 transition-colors duration-300">
                                        I agree to the terms and conditions and understand the event policies. <span
                                            class="text-red-400">*</span>
                                    </span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4 animate-fadeInUp delay-350">
                                <button type="submit" id="existingSubmitBtn"
                                    class="w-full px-8 py-4 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 rounded-lg text-white text-base font-semibold tracking-wide transition-all duration-300 hover:from-cyan-500/30 hover:to-blue-500/30 hover:border-cyan-500/50 hover:shadow-[0_0_30px_rgba(0,255,255,0.2)] hover:-translate-y-0.5 active:translate-y-0">
                                    <span id="existingBtnText">Complete Registration</span>
                                </button>
                                <p class="text-xs text-white/40 text-center mt-3">
                                    <span class="text-red-400">*</span> Required fields
                                </p>
                            </div>
                        </form>
                    @else
                        <!-- Disabled Form State -->
                        <div class="space-y-6 opacity-50 pointer-events-none">
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-2">Full Name</label>
                                <input type="text" disabled class="input-field" placeholder="Select an event first">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-2">Email Address</label>
                                <input type="email" disabled class="input-field" placeholder="Select an event first">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white/70 mb-2">Phone Number</label>
                                <input type="tel" disabled class="input-field" placeholder="Select an event first">
                            </div>
                        </div>
                    @endif
                </div>
            </div>


        </div>
    </div>

    <script>
        // Tab Switching Function
        function switchTab(tab) {
            const newTab = document.getElementById('newTab');
            const existingTab = document.getElementById('existingTab');
            const newUserForm = document.getElementById('newUserForm');
            const existingUserForm = document.getElementById('existingUserForm');

            if (tab === 'new') {
                // Activate new tab
                newTab.classList.add('bg-gradient-to-r', 'from-cyan-500/20', 'to-blue-500/20', 'border', 'border-cyan-500/30', 'shadow-[0_0_20px_rgba(0,255,255,0.15)]');
                newTab.classList.remove('text-white/60', 'hover:text-white/80', 'hover:bg-white/[0.03]');
                newTab.classList.add('text-white');

                // Deactivate existing tab
                existingTab.classList.remove('bg-gradient-to-r', 'from-cyan-500/20', 'to-blue-500/20', 'border', 'border-cyan-500/30', 'shadow-[0_0_20px_rgba(0,255,255,0.15)]', 'text-white');
                existingTab.classList.add('text-white/60', 'hover:text-white/80', 'hover:bg-white/[0.03]');

                // Show/hide forms
                newUserForm.classList.remove('hidden');
                existingUserForm.classList.add('hidden');
            } else {
                // Activate existing tab
                existingTab.classList.add('bg-gradient-to-r', 'from-cyan-500/20', 'to-blue-500/20', 'border', 'border-cyan-500/30', 'shadow-[0_0_20px_rgba(0,255,255,0.15)]');
                existingTab.classList.remove('text-white/60', 'hover:text-white/80', 'hover:bg-white/[0.03]');
                existingTab.classList.add('text-white');

                // Deactivate new tab
                newTab.classList.remove('bg-gradient-to-r', 'from-cyan-500/20', 'to-blue-500/20', 'border', 'border-cyan-500/30', 'shadow-[0_0_20px_rgba(0,255,255,0.15)]', 'text-white');
                newTab.classList.add('text-white/60', 'hover:text-white/80', 'hover:bg-white/[0.03]');

                // Show/hide forms
                existingUserForm.classList.remove('hidden');
                newUserForm.classList.add('hidden');
            }
        }

        // Initialize: Restore tab state after validation errors
        document.addEventListener('DOMContentLoaded', function () {
            // Check if there are validation errors or old input
            const registrationType = '{{ old("registration_type") }}';

            // Determine which tab to show
            if (registrationType === 'existing') {
                switchTab('existing');
            } else if (registrationType === 'new') {
                switchTab('new');
            }
            // If no errors and no old input, default to 'new' tab (already set in HTML)
        });


        // Form submission handling for new user form
        document.getElementById('newUserForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById('newSubmitBtn');
            const btnText = document.getElementById('newBtnText');
            const form = this;

            // Add loading state
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
            btnText.textContent = 'Processing...';

            // Simulate API call (replace with actual form submission)
            setTimeout(() => {
                // Remove loading state
                submitBtn.classList.remove('btn-loading');
                submitBtn.disabled = false;
                btnText.textContent = 'Complete Registration';

                // Submit the form
                form.submit();
            }, 1000);
        });

        // Form submission handling for existing user form
        document.getElementById('existingUserForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById('existingSubmitBtn');
            const btnText = document.getElementById('existingBtnText');
            const form = this;

            // Add loading state
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
            btnText.textContent = 'Processing...';

            // Simulate API call (replace with actual form submission)
            setTimeout(() => {
                // Remove loading state
                submitBtn.classList.remove('btn-loading');
                submitBtn.disabled = false;
                btnText.textContent = 'Complete Registration';

                // Submit the form
                form.submit();
            }, 1000);
        });

        // Real-time form validation
        const inputs = document.querySelectorAll('.input-field');
        inputs.forEach(input => {
            input.addEventListener('blur', function () {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('border-red-500/50');
                } else {
                    this.classList.remove('border-red-500/50');
                }
            });

            input.addEventListener('input', function () {
                this.classList.remove('border-red-500/50');
            });
        });

        // Email validation
        const emailInputs = document.querySelectorAll('input[type="email"]');
        emailInputs.forEach(emailInput => {
            emailInput?.addEventListener('blur', function () {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.classList.add('border-red-500/50');
                }
            });
        });


    </script>
</x-public-layout>