@props(['active', 'request'])

@php
    $classes = ($active ?? false)
        ? 'animate-border-animation inline-flex items-center px-1 pt-1 border-b-2 border-cyan-400 text-base font-medium leading-5 text-white focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-base font-medium leading-5 text-white/70 hover:text-white/90 hover:border-white/90 focus:outline-none focus:text-white/90 focus:border-white/90 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>