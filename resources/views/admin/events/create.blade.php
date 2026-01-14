<x-app-layout>
    <div class="py-7">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8 animate-fade-in-up">
                <h1 class="font-serif text-4xl font-bold text-white mb-2">Create New Event</h1>
                <p class="text-white/60 text-lg">Fill in the details below to create a new event</p>
            </div>

            <!-- Form Card -->
            <div
                class="animate-fade-in-up bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-2xl p-8 shadow-xl">
                <form action="{{ route('event.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div class="group">
                        <label for="title" class="block text-sm font-medium text-white/80 mb-2">
                            Event Title <span class="text-cyan-400">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.08] rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 transition-all duration-200 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="group">
                        <label for="description" class="block text-sm font-medium text-white/80 mb-2">
                            Description <span class="text-cyan-400">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.08] rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 transition-all duration-200 resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date & Time and Location Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date & Time -->
                        <div class="group">
                            <label for="date_time" class="block text-sm font-medium text-white/80 mb-2">
                                Date & Time <span class="text-cyan-400">*</span>
                            </label>
                            <input type="datetime-local" name="date_time" id="date_time" value="{{ old('date_time') }}"
                                required
                                class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.08] rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 transition-all duration-200 @error('date_time') border-red-500 @enderror">
                            @error('date_time')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="group">
                            <label for="location" class="block text-sm font-medium text-white/80 mb-2">
                                Location <span class="text-cyan-400">*</span>
                            </label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" required
                                class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.08] rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 transition-all duration-200 @error('location') border-red-500 @enderror">
                            @error('location')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Capacity and Price Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Capacity -->
                        <div class="group">
                            <label for="capacity" class="block text-sm font-medium text-white/80 mb-2">
                                Capacity <span class="text-cyan-400">*</span>
                            </label>
                            <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="1"
                                required
                                class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.08] rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 transition-all duration-200 @error('capacity') border-red-500 @enderror">
                            @error('capacity')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="group">
                            <label for="price" class="block text-sm font-medium text-white/80 mb-2">
                                Price (Optional)
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-white/60 font-medium">$</span>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" min="0"
                                    step="0.01" placeholder="0.00"
                                    class="w-full pl-8 pr-4 py-3 bg-white/[0.03] border border-white/[0.08] rounded-lg text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 transition-all duration-200 @error('price') border-red-500 @enderror">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="group">
                        <label for="status" class="block text-sm font-medium text-white/80 mb-2">
                            Status <span class="text-cyan-400">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-3 bg-white/[0.03] border border-white/[0.08] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-400 transition-all duration-200 @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}
                                class="bg-gray-900 text-white">Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}
                                class="bg-gray-900 text-white">Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-white/[0.08]">
                        <a href="{{ route('event.index') }}"
                            class="px-6 py-3 text-white/70 hover:text-white font-medium transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                            class="group relative px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg overflow-hidden transition-all duration-300 hover:shadow-[0_0_30px_rgba(6,182,212,0.4)] hover:scale-105">
                            <span class="relative z-10">Create Event</span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-blue-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>