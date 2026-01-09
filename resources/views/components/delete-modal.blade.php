<!-- Delete Confirmation Modal -->
<div id="{{ $modalId }}" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50" style="backdrop-filter: blur(8px);">
    <div class="bg-white/[0.02] backdrop-blur-xl border border-white/[0.08] rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
        <div class="p-8">
            <!-- Warning Icon -->
            <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-500/10 border border-red-500/20 rounded-full mb-6">
                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 class="font-serif text-2xl font-semibold text-white text-center mb-3 tracking-tight">
                {{ $title ?? 'Confirm Deletion' }}
            </h3>
            
            <!-- Message -->
            <p class="text-sm text-white/60 text-center mb-8 leading-relaxed">
                {{ $message ?? 'Are you sure you want to delete this item? This action cannot be undone.' }}
            </p>
            
            <!-- Form -->
            <form id="{{ $formId }}" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="{{ $methodInputId }}" value="DELETE">
                
                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="closeDeleteModal()" 
                            class="flex-1 px-6 py-3 bg-white/[0.05] border border-white/10 rounded-lg text-white/80 font-medium hover:bg-white/[0.08] hover:border-white/20 transition-all duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-red-500/20 border border-red-500/30 rounded-lg text-red-400 font-medium hover:bg-red-500/30 hover:border-red-500/50 hover:shadow-[0_0_20px_rgba(239,68,68,0.2)] transition-all duration-200">
                        {{ $confirmText ?? 'Delete' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(url, method = 'DELETE') {
        const modal = document.getElementById('{{ $modalId }}');
        const form = document.getElementById('{{ $formId }}');
        const methodInput = document.getElementById('{{ $methodInputId }}');

        form.action = url;
        methodInput.value = method.toUpperCase();
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('{{ $modalId }}');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close modal when clicking outside
    document.getElementById('{{ $modalId }}')?.addEventListener('click', function (e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('{{ $modalId }}');
            if (modal && !modal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        }
    });
</script>