@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center text-center px-1 pt-1 border-bottom border-5 border-warning text-sm font-medium leading-5 text-success text-uppercase focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-bottom border-5 border-transparent text-uppercase text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
