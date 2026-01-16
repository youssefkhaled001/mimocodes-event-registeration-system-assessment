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

                    @php
                        $eventLabels = array_column($eventStatusData, 'label');
                        $eventValues = array_column($eventStatusData, 'value');
                        $eventColors = array_column($eventStatusData, 'color');
                    @endphp

                    <div class="flex justify-center items-center" style="max-height: 300px;">
                        <x-bladewind::chart type="doughnut" :labels="$eventLabels" :data="$eventValues"
                            :colors="$eventColors" />
                    </div>
                </div>

                <!-- Registration Status Distribution -->
                <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-8">
                    <h2 class="font-serif text-2xl font-bold text-white mb-6">Registration Status</h2>

                    @php
                        $regLabels = array_column($registrationStatusData, 'label');
                        $regValues = array_column($registrationStatusData, 'value');
                        $regColors = array_column($registrationStatusData, 'color');
                    @endphp

                    <div class="flex justify-center items-center" style="max-height: 300px;">
                        <x-bladewind::chart type="doughnut" :labels="$regLabels" :data="$regValues"
                            :colors="$regColors" />
                    </div>
                </div>
            </div>

            <!-- Revenue Trend Chart -->
            <div class="bg-white/[0.02] backdrop-blur-sm border border-white/[0.08] rounded-xl p-8 mb-8">
                <h2 class="font-serif text-2xl font-bold text-white mb-6">Revenue Trend (Last 30 Days)</h2>

                @php
                    $revenueLabels = array_column($revenueTrend, 'date');
                    $revenueValues = array_column($revenueTrend, 'revenue');
                @endphp

                <div class="w-full flex justify-center" style="height: 300px;">
                    <x-bladewind::chart type="line" :labels="$revenueLabels" :data="$revenueValues" color="#06b6d4" />
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