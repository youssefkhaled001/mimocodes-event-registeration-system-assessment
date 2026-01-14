<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bladewind UI -->
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom font families */
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .font-sans {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        /* Subtle floating animation for background */
        @keyframes subtleFloat {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(2%, -2%) rotate(1deg);
            }

            66% {
                transform: translate(-2%, 2%) rotate(-1deg);
            }
        }

        .animate-subtleFloat {
            animation: subtleFloat 20s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-black text-white min-h-screen overflow-x-hidden antialiased font-sans">
    <!-- Subtle Cyan Glow Background -->
    <div class="fixed top-[-50%] left-[-50%] w-[200%] h-[200%] pointer-events-none z-0 animate-subtleFloat">
        <div class="absolute top-[30%] left-[20%] w-[800px] h-[800px] bg-cyan-500/[0.08] rounded-full blur-[120px]">
        </div>
        <div class="absolute top-[60%] left-[70%] w-[600px] h-[600px] bg-blue-500/[0.06] rounded-full blur-[100px]">
        </div>
        <div class="absolute top-[80%] left-[50%] w-[700px] h-[700px] bg-sky-500/[0.05] rounded-full blur-[110px]">
        </div>
    </div>

    <div class="relative z-10 min-h-screen">
        @include('layouts.navigation')
        <div class="flex justify-center mt-5">
            <!-- Success Message -->
            @if(session('success'))
                <div
                    class="w-full max-w-7xl p-4 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 rounded-lg backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_10px_rgba(0,255,255,0.5)]"></div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <!-- Error Message -->
            @if(session('error'))
                <div
                    class="w-full max-w-7xl p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-red-400 shadow-[0_0_10px_rgba(239,68,68,0.5)]"></div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
        </div>
        <!-- Page Content -->
        <main class="animate-fade-in-up">
            {{ $slot }}
        </main>
    </div>
</body>

</html>