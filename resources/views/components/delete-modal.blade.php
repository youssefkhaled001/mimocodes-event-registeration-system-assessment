<!-- Delete Confirmation Modal -->
<div id="{{ $modalId }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
    style="backdrop-filter: blur(4px);">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">{{ $title ?? 'Confirm Deletion' }}</h3>
            <p class="text-sm text-gray-600 text-center mb-6">
                {{ $message ?? 'Are you sure you want to delete this item? This action cannot be undone.' }}</p>

            <form id="{{ $formId }}" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="{{ $methodInputId }}" value="DELETE">

                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
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