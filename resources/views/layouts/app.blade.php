<?php 
use Illuminate\Support\Facades\Storage;
$calendarStyle = Storage::url('css/calendar.css'); ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MiLorito') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    
   
    <!-- <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">  -->
    @stack('styles')
    <link rel="stylesheet" href="<?php //echo $calendarStyle; ?>">
    <!-- Scripts  ,'resources/js/scripts/of-lista.js' -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Page Heading - resources/views/components/header.blade.php -->
        <header>
            <x-header />
        </header>

        @auth
            
                @include('layouts.navigation')
            
        @endauth

        <!-- Page Content -->
        <main>
            @if (isset($slot))
            {{ $slot }}
            @endif

        </main>
    </div>
</body>

</html>