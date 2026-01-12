<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Event Registration - Mimocodes</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Register for our exclusive event. Fill out the form to secure your spot and join us for an unforgettable experience.">

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

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .animate-subtleFloat {
            animation: subtleFloat 20s ease-in-out infinite;
        }

        /* Staggered animation delays */
        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-150 {
            animation-delay: 0.15s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-250 {
            animation-delay: 0.25s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-350 {
            animation-delay: 0.35s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-450 {
            animation-delay: 0.45s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        /* Loading animation */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
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
    <main>
        {{ $slot }}
    </main>
</body>

</html>