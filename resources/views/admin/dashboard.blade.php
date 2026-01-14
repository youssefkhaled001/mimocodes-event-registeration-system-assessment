<x-app-layout>
    <div class="py-7 px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-12">
                <div
                    class="inline-flex items-center gap-2 text-xs font-medium text-white/50 uppercase tracking-[0.15em] mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></span>
                    <span>Analytics Dashboard</span>
                </div>
                <h1 class="font-serif text-5xl font-bold text-white mb-4 leading-tight tracking-tight">
                    Dashboard Overview
                </h1>
                <p class="text-lg font-light text-white/60 max-w-2xl leading-relaxed">
                    Monitor your events, track registrations, and analyze revenue metrics.
                </p>
            </div>

            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Events -->
                <div
                    class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-6 hover:border-cyan-400/30 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-cyan-500/10 rounded-lg">
                            <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $totalEvents }}</h3>
                    <p class="text-sm text-white/60">Total Events</p>
                </div>

                <!-- Total Registrations -->
                <div
                    class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-6 hover:border-cyan-400/30 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-500/10 rounded-lg">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">{{ $totalRegistrations }}</h3>
                    <p class="text-sm text-white/60">Total Registrations</p>
                </div>

                <!-- Total Revenue -->
                <div
                    class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-6 hover:border-cyan-400/30 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-500/10 rounded-lg">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">${{ number_format($totalRevenue, 2) }}</h3>
                    <p class="text-sm text-white/60">Total Revenue</p>
                </div>

                <!-- Pending Revenue -->
                <div
                    class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-6 hover:border-cyan-400/30 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-yellow-500/10 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-1">${{ number_format($pendingRevenue, 2) }}</h3>
                    <p class="text-sm text-white/60">Pending Revenue</p>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Event Status Distribution -->
                <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-8">
                    <h2 class="font-serif text-2xl font-bold text-white mb-6">Event Status Distribution</h2>

                    <div class="flex items-center justify-center gap-8">
                        <!-- Donut Chart -->
                        <div class="relative w-48 h-48">
                            @php
                                $eventTotal = $totalEvents > 0 ? $totalEvents : 1;
                                $cumulativePercent = 0;
                            @endphp

                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                @foreach($eventStatusData as $index => $item)
                                    @php
                                        $percent = ($item['value'] / $eventTotal) * 100;
                                        $offset = $cumulativePercent * 2.51; // 251 is circumference (2 * π * 40)
                                        $dashArray = ($percent * 2.51) . ' 251';
                                        $cumulativePercent += $percent;
                                    @endphp
                                    <circle cx="50" cy="50" r="40" fill="none" stroke="{{ $item['color'] }}"
                                        stroke-width="20" stroke-dasharray="{{ $dashArray }}"
                                        stroke-dashoffset="-{{ $offset }}" class="transition-all duration-500" />
                                @endforeach
                                <!-- Inner circle for donut effect -->
                                <circle cx="50" cy="50" r="30" fill="#0a0a0a" />
                            </svg>

                            <!-- Center text -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-white">{{ $totalEvents }}</span>
                                <span class="text-xs text-white/60">Events</span>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="space-y-3">
                            @foreach($eventStatusData as $item)
                                <div class="flex items-center gap-3">
                                    <div class="w-4 h-4 rounded-full" style="background-color: {{ $item['color'] }}"></div>
                                    <div class="flex-1">
                                        <div class="text-sm text-white/70">{{ $item['label'] }}</div>
                                        <div class="text-lg font-semibold text-white">{{ $item['value'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Registration Status Distribution -->
                <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-8">
                    <h2 class="font-serif text-2xl font-bold text-white mb-6">Registration Status</h2>

                    <div class="flex items-center justify-center gap-8">
                        <!-- Donut Chart -->
                        <div class="relative w-48 h-48">
                            @php
                                $regTotal = $totalRegistrations > 0 ? $totalRegistrations : 1;
                                $cumulativePercent = 0;
                            @endphp

                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                                @foreach($registrationStatusData as $index => $item)
                                    @php
                                        $percent = ($item['value'] / $regTotal) * 100;
                                        $offset = $cumulativePercent * 2.51;
                                        $dashArray = ($percent * 2.51) . ' 251';
                                        $cumulativePercent += $percent;
                                    @endphp
                                    <circle cx="50" cy="50" r="40" fill="none" stroke="{{ $item['color'] }}"
                                        stroke-width="20" stroke-dasharray="{{ $dashArray }}"
                                        stroke-dashoffset="-{{ $offset }}" class="transition-all duration-500" />
                                @endforeach
                                <!-- Inner circle for donut effect -->
                                <circle cx="50" cy="50" r="30" fill="#0a0a0a" />
                            </svg>

                            <!-- Center text -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-3xl font-bold text-white">{{ $totalRegistrations }}</span>
                                <span class="text-xs text-white/60">Registrations</span>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="space-y-3">
                            @foreach($registrationStatusData as $item)
                                <div class="flex items-center gap-3">
                                    <div class="w-4 h-4 rounded-full" style="background-color: {{ $item['color'] }}"></div>
                                    <div class="flex-1">
                                        <div class="text-sm text-white/70">{{ $item['label'] }}</div>
                                        <div class="text-lg font-semibold text-white">{{ $item['value'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Trend Chart -->
            <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-8 mb-8">
                <h2 class="font-serif text-2xl font-bold text-white mb-6">Revenue Trend (Last 30 Days)</h2>

                @php
                    $maxRevenue = max(array_column($revenueTrend, 'revenue'));
                    $maxRevenue = $maxRevenue > 0 ? $maxRevenue : 1;
                    $chartHeight = 200;
                    $chartWidth = 600;
                @endphp

                <div class="relative" style="height: 280px;">
                    <!-- Y-axis labels -->
                    <div class="absolute left-0 top-0 bottom-12 flex flex-col justify-between text-xs text-white/40 pr-3 w-16 text-right">
                        <span>${{ number_format($maxRevenue, 0) }}</span>
                        <span>${{ number_format($maxRevenue * 0.75, 0) }}</span>
                        <span>${{ number_format($maxRevenue * 0.5, 0) }}</span>
                        <span>${{ number_format($maxRevenue * 0.25, 0) }}</span>
                        <span>$0</span>
                    </div>

                    <!-- SVG Chart -->
                    <div class="ml-20 h-full">
                        <svg class="w-full" style="height: {{ $chartHeight }}px;" viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" preserveAspectRatio="none">
                            <defs>
                                <!-- Gradient for area fill -->
                                <linearGradient id="areaGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#06b6d4;stop-opacity:0.3" />
                                    <stop offset="100%" style="stop-color:#06b6d4;stop-opacity:0" />
                                </linearGradient>
                            </defs>

                            <!-- Grid lines -->
                            @for ($i = 0; $i <= 4; $i++)
                                <line x1="0" y1="{{ ($chartHeight / 4) * $i }}" 
                                      x2="{{ $chartWidth }}" y2="{{ ($chartHeight / 4) * $i }}" 
                                      stroke="rgba(255,255,255,0.05)" stroke-width="1" />
                            @endfor

                            @php
                                $points = [];
                                $areaPoints = "0,{$chartHeight} ";
                                $segmentWidth = $chartWidth / (count($revenueTrend) - 1);
                                
                                foreach ($revenueTrend as $index => $day) {
                                    $x = $index * $segmentWidth;
                                    $y = $chartHeight - (($day['revenue'] / $maxRevenue) * $chartHeight);
                                    $points[] = "{$x},{$y}";
                                    $areaPoints .= "{$x},{$y} ";
                                }
                                $areaPoints .= "{$chartWidth},{$chartHeight}";
                                $linePoints = implode(' ', $points);
                            @endphp

                            <!-- Area fill -->
                            <polygon points="{{ $areaPoints }}" fill="url(#areaGradient)" />

                            <!-- Line -->
                            <polyline points="{{ $linePoints }}" 
                                      fill="none" 
                                      stroke="#06b6d4" 
                                      stroke-width="3" 
                                      stroke-linecap="round"
                                      stroke-linejoin="round" />

                            <!-- Data points -->
                            @foreach ($revenueTrend as $index => $day)
                                @php
                                    $x = $index * $segmentWidth;
                                    $y = $chartHeight - (($day['revenue'] / $maxRevenue) * $chartHeight);
                                @endphp
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="5" 
                                        fill="#06b6d4" 
                                        stroke="#0a0a0a" 
                                        stroke-width="2"
                                        class="hover:r-7 transition-all cursor-pointer" />
                                
                                <!-- Hover tooltip area -->
                                <g class="opacity-0 hover:opacity-100 transition-opacity pointer-events-none">
                                    <rect x="{{ $x - 40 }}" y="{{ max(0, $y - 50) }}" width="80" height="40" 
                                          rx="6" fill="#1a1a1a" stroke="#06b6d4" stroke-width="1" />
                                    <text x="{{ $x }}" y="{{ max(15, $y - 30) }}" 
                                          text-anchor="middle" fill="#ffffff" font-size="12" font-weight="600">
                                        ${{ number_format($day['revenue'], 0) }}
                                    </text>
                                    <text x="{{ $x }}" y="{{ max(30, $y - 15) }}" 
                                          text-anchor="middle" fill="#9ca3af" font-size="10">
                                        {{ $day['date'] }}
                                    </text>
                                </g>
                            @endforeach
                        </svg>

                        <!-- X-axis labels -->
                        <div class="flex justify-between text-xs text-white/40 mt-2">
                            @foreach ($revenueTrend as $day)
                                <span class="flex-1 text-center">{{ $day['date'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="mt-6 pt-6 border-t border-white/[0.08] flex justify-between items-center">
                    <div>
                        <p class="text-sm text-white/60">Average Daily Revenue</p>
                        <p class="text-2xl font-bold text-white">
                            ${{ number_format(array_sum(array_column($revenueTrend, 'revenue')) / count($revenueTrend), 2) }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-white/60">Peak Day</p>
                        @php
                            $peakDay = collect($revenueTrend)->sortByDesc('revenue')->first();
                        @endphp
                        <p class="text-2xl font-bold text-cyan-400">
                            ${{ number_format($peakDay['revenue'], 2) }}
                        </p>
                        <p class="text-xs text-white/40">{{ $peakDay['date'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Table -->
            <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-8">
                <h2 class="font-serif text-2xl font-bold text-white mb-6">Upcoming Events</h2>

                @if ($upcomingEvents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-white/[0.08]">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-white/70">Event</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-white/70">Date</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-white/70">Location</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-white/70">Registrations</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-white/70">Capacity</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-white/70">Fill Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($upcomingEvents as $event)
                                    <tr class="border-b border-white/[0.05] hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 px-4">
                                            <a href="{{ route('event.edit', $event->id) }}"
                                                class="text-cyan-400 hover:text-cyan-300 font-medium">
                                                {{ $event->title }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-4 text-white/60 text-sm">
                                            {{ $event->date_time->format('M d, Y') }}
                                        </td>
                                        <td class="py-4 px-4 text-white/60 text-sm">{{ $event->location }}</td>
                                        <td class="py-4 px-4 text-white font-semibold">{{ $event->confirmed_count }}</td>
                                        <td class="py-4 px-4 text-white/60">{{ $event->capacity }}</td>
                                        <td class="py-4 px-4">
                                            @php
                                                $fillRate = $event->capacity > 0 ? ($event->confirmed_count / $event->capacity) * 100 : 0;
                                            @endphp
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-white/[0.05] rounded-full h-2 overflow-hidden">
                                                    <div class="h-full rounded-full {{ $fillRate >= 80 ? 'bg-green-500' : ($fillRate >= 50 ? 'bg-yellow-500' : 'bg-cyan-500') }}"
                                                        style="width: {{ $fillRate }}%"></div>
                                                </div>
                                                <span
                                                    class="text-xs text-white/60 w-12">{{ number_format($fillRate, 0) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4 opacity-20">📅</div>
                        <p class="text-white/50">No upcoming events scheduled</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>