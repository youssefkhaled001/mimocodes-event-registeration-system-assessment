<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Events - Mimocodes</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Discover and register for exciting upcoming events. Browse through our curated collection of events and secure your spot today.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom font families */
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }
        
        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes subtleFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, -2%) rotate(1deg); }
            66% { transform: translate(-2%, 2%) rotate(-1deg); }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out backwards;
        }
        
        .animate-subtleFloat {
            animation: subtleFloat 20s ease-in-out infinite;
        }
        
        /* Staggered animation delays */
        .delay-100 { animation-delay: 0.1s; }
        .delay-150 { animation-delay: 0.15s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-250 { animation-delay: 0.25s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-350 { animation-delay: 0.35s; }
    </style>
</head>
<body class="bg-black text-white min-h-screen overflow-x-hidden antialiased font-sans">
    <!-- Subtle Cyan Glow Background -->
    <div class="fixed top-[-50%] left-[-50%] w-[200%] h-[200%] pointer-events-none z-0 animate-subtleFloat">
        <div class="absolute top-[30%] left-[20%] w-[800px] h-[800px] bg-cyan-500/[0.08] rounded-full blur-[120px]"></div>
        <div class="absolute top-[60%] left-[70%] w-[600px] h-[600px] bg-blue-500/[0.06] rounded-full blur-[100px]"></div>
        <div class="absolute top-[80%] left-[50%] w-[700px] h-[700px] bg-sky-500/[0.05] rounded-full blur-[110px]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-8 py-16 pt-32">
        <!-- Header -->
        <header class="mb-20 animate-fadeInUp">
            <div class="inline-flex items-center gap-2 text-xs font-medium text-white/50 uppercase tracking-[0.15em] mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></span>
                <span>Upcoming Events</span>
            </div>
            <h1 class="font-serif text-7xl font-bold text-white mb-6 leading-tight tracking-tight">
                Elevating experiences through<br>Digital Innovation.
            </h1>
            <p class="text-lg font-light text-white/60 max-w-2xl leading-relaxed">
                Discover and register for our curated collection of events. From workshops to conferences, find your next opportunity to learn and connect.
            </p>
        </header>

        <!-- Events Grid -->
        @if($events->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-16">
                @forelse($events as $index => $event)
                    <article class="group relative bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl overflow-hidden transition-all duration-500 hover:bg-white/[0.04] hover:border-cyan-500/20 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,255,255,0.05)] animate-fadeInUp delay-{{ min(($index + 1) * 50 + 50, 350) }}">
                        <!-- Top gradient line on hover -->
                        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-400"></div>
                        
                        <div class="p-10">
                            <!-- Meta -->
                            <div class="flex items-center gap-4 mb-6">
                                <span class="inline-flex items-center gap-2 text-xs font-medium text-white/50 uppercase tracking-widest">
                                    <span class="w-1 h-1 rounded-full bg-cyan-400/60"></span>
                                    {{ $event->date_time->format('M d, Y • g:i A') }}
                                </span>
                                <span class="px-3 py-1 bg-cyan-500/10 border border-cyan-500/20 rounded text-[0.625rem] font-semibold text-cyan-400 uppercase tracking-widest">
                                    {{ $event->status }}
                                </span>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="font-serif text-3xl font-semibold text-white mb-4 leading-snug tracking-tight">
                                {{ $event->title }}
                            </h2>
                            
                            <!-- Description -->
                            @if($event->description)
                                <p class="text-white/50 leading-relaxed mb-8 text-[0.9375rem] font-light">
                                    {{ Str::limit($event->description, 100) }}
                                </p>
                            @endif
                            
                            <!-- Details -->
                            <div class="flex flex-col gap-4 mb-8 pt-8 border-t border-white/5">
                                <div class="flex items-start gap-4">
                                    <div class="w-9 h-9 rounded-lg bg-cyan-500/5 border border-cyan-500/10 flex items-center justify-center text-cyan-400 flex-shrink-0">
                                        📍
                                    </div>
                                    <div class="pt-1">
                                        <div class="text-[0.6875rem] text-white/40 uppercase tracking-widest font-medium mb-1">Location</div>
                                        <div class="text-white/80 text-[0.9375rem]">{{ $event->location }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-4">
                                    <div class="w-9 h-9 rounded-lg bg-cyan-500/5 border border-cyan-500/10 flex items-center justify-center text-cyan-400 flex-shrink-0">
                                        👥
                                    </div>
                                    <div class="pt-1">
                                        <div class="text-[0.6875rem] text-white/40 uppercase tracking-widest font-medium mb-1">Capacity</div>
                                        <div class="text-white/80 text-[0.9375rem]">{{ $event->capacity }} attendees</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Footer -->

                                <div class="mb-8">
                                    <div class="text-[0.6875rem] text-white/40 uppercase tracking-widest font-medium mb-2">Price</div>
                                    <div class="font-serif text-4xl font-bold {{ $event->price == 0 ? 'text-emerald-400' : 'text-cyan-400' }} leading-none">
                                        @if($event->price > 0)
                                            ${{ number_format($event->price, 2) }}
                                        @else
                                            FREE
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col items-center gap-4">
                                    <button 
                                        onclick="openEventModal({{ $event->id }})"
                                        data-event-id="{{ $event->id }}"
                                        data-event-title="{{ $event->title }}"
                                        data-event-description="{{ $event->description }}"
                                        data-event-date="{{ $event->date_time->format('M d, Y • g:i A') }}"
                                        data-event-location="{{ $event->location }}"
                                        data-event-capacity="{{ $event->capacity }}"
                                        data-event-price="{{ $event->price }}"
                                        data-event-status="{{ $event->status }}"
                                        data-event-registerations="{{ $event->registrations->where('status', 'confirmed')->count() }}"
                                        class="w-full text-center px-8 py-3.5 bg-transparent border border-white/20 rounded-md text-white text-sm font-medium tracking-wide transition-all duration-300 hover:bg-cyan-500/10 hover:border-cyan-500/50 hover:text-cyan-400 hover:shadow-[0_0_30px_rgba(0,255,255,0.2)]">
                                        View Details
                                    </button>
                                    <a href="/register?id={{ $event->id }}" class="w-full text-center px-8 py-3.5 bg-transparent border border-white/20 rounded-md text-white text-sm font-medium tracking-wide transition-all duration-300 hover:bg-cyan-500/10 hover:border-cyan-500/50 hover:text-cyan-400 hover:shadow-[0_0_30px_rgba(0,255,255,0.2)]">
                                        Register Now
                                    </a>
                                </div>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-24 bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl animate-fadeInUp">
                        <div class="text-6xl mb-8 opacity-30">○</div>
                        <h2 class="font-serif text-4xl font-semibold text-white mb-4 tracking-tight">No Events Available</h2>
                        <p class="text-white/50 text-lg font-light">Check back soon for exciting upcoming events.</p>
                    </div>
                @endforelse
            </div>
            {{ $events->links() }}
        @else
            <!-- Empty State -->
            <div class="text-center py-24 bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl animate-fadeInUp">
                <div class="text-6xl mb-8 opacity-30">○</div>
                <h2 class="font-serif text-4xl font-semibold text-white mb-4 tracking-tight">No Events Available</h2>
                <p class="text-white/50 text-lg font-light">Check back soon for exciting upcoming events.</p>
            </div>
        @endif
    </div>

    <!-- Event Modal Component -->
    <x-event-modal />
</body>
</html>