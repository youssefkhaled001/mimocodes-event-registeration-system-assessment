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

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>