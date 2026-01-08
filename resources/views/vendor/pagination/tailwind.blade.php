@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="w-full mt-16 animate-fadeInUp">

        {{-- Mobile Pagination --}}
        <div class="flex gap-3 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white/40 bg-white/[0.02] border border-white/[0.08] cursor-not-allowed rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-white/[0.02] border border-white/[0.08] rounded-lg transition-all duration-300 hover:bg-cyan-500/10 hover:border-cyan-500/30 hover:text-cyan-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-white/[0.02] border border-white/[0.08] rounded-lg transition-all duration-300 hover:bg-cyan-500/10 hover:border-cyan-500/30 hover:text-cyan-400">
                    Next
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span
                    class="inline-flex items-center px-6 py-3 text-sm font-medium text-white/40 bg-white/[0.02] border border-white/[0.08] cursor-not-allowed rounded-lg">
                    Next
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </div>

        {{-- Desktop Pagination --}}
        <div class="hidden sm:flex sm:flex-col sm:items-center sm:gap-6">

            {{-- Results Info --}}
            <div class="text-center">
                <p class="text-sm text-white/50 font-light">
                    Showing
                    @if ($paginator->firstItem())
                        <span class="font-medium text-cyan-400">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium text-cyan-400">{{ $paginator->lastItem() }}</span>
                    @else
                        <span class="font-medium text-cyan-400">{{ $paginator->count() }}</span>
                    @endif
                    of
                    <span class="font-medium text-white">{{ $paginator->total() }}</span>
                    events
                </p>
            </div>

            {{-- Page Numbers --}}
            <div class="flex items-center gap-2">

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}"
                        class="inline-flex items-center justify-center w-10 h-10 text-white/40 bg-white/[0.02] border border-white/[0.08] cursor-not-allowed rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="inline-flex items-center justify-center w-10 h-10 text-white bg-white/[0.02] border border-white/[0.08] rounded-lg transition-all duration-300 hover:bg-cyan-500/10 hover:border-cyan-500/30 hover:text-cyan-400 hover:shadow-[0_0_20px_rgba(0,255,255,0.1)]"
                        aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true"
                            class="inline-flex items-center justify-center w-10 h-10 text-white/50 bg-white/[0.02] border border-white/[0.08] cursor-default rounded-lg">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-cyan-400 bg-cyan-500/10 border border-cyan-500/30 cursor-default rounded-lg shadow-[0_0_20px_rgba(0,255,255,0.15)]">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-white/80 bg-white/[0.02] border border-white/[0.08] rounded-lg transition-all duration-300 hover:bg-cyan-500/10 hover:border-cyan-500/30 hover:text-cyan-400 hover:shadow-[0_0_20px_rgba(0,255,255,0.1)]"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="inline-flex items-center justify-center w-10 h-10 text-white bg-white/[0.02] border border-white/[0.08] rounded-lg transition-all duration-300 hover:bg-cyan-500/10 hover:border-cyan-500/30 hover:text-cyan-400 hover:shadow-[0_0_20px_rgba(0,255,255,0.1)]"
                        aria-label="{{ __('pagination.next') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}"
                        class="inline-flex items-center justify-center w-10 h-10 text-white/40 bg-white/[0.02] border border-white/[0.08] cursor-not-allowed rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif