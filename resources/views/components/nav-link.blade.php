@props(['active'])

@php
$classes = ($active ?? false)
? 'nav-link active inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-white focus:outline-none transition duration-300 ease-in-out relative'
: 'nav-link inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-300 hover:text-white focus:outline-none focus:text-white transition duration-300 ease-in-out relative';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>