<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Edit Event</h2>

                        <!-- Delete Event Button -->
                        <button type="button"
                            onclick="openModaldeleteEventModal('{{ route('delete.event', $event->id) }}', 'DELETE')"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Delete Event
                        </button>
                    </div>

                    <!-- Edit Form -->
                    <form method="POST" action="{{ route('event.update', $event->id) }}">
                        @csrf
                        @method('POST')

                        <!-- Form fields would go here -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Title</label>
                            <input type="text" name="title" value="{{ $event->title }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- More form fields... -->

                        <div class="flex gap-3">
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the reusable delete modal with custom ID and messages -->
    <x-delete-modal modal-id="deleteEventModal" title="Delete Event"
        message="Are you sure you want to delete this event? All registrations will be lost. This action cannot be undone."
        confirm-text="Delete Event" />
</x-app-layout>