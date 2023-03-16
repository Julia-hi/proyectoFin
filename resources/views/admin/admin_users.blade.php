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
    <link rel="stylesheet" href="{{asset('storage/css/mi_estilo.css')}}">
    <!-- Scripts  ,'resources/js/scripts/of-lista.js' -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Page Heading - resources/views/components/header.blade.php -->
    @if($status == 'ok')
    <head>
        <x-header />
    </head>
    <div class="min-h-screen bg-gray-100">
        @auth
        @include('layouts.navigation-admin')
        @endauth
        <!-- Page Content -->
        <main>
            <div class="container">
                <div class="justify-center px-6">
                    <div class="mt-4 p-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg" style="min-height:400px;">
                     <!-- Usuarios activos -->
                     <div id="usuar_act" class="p-3">
                            <h2 class="text-center py-2">Usuarios activados</h2>
                            @if($usAct ==null || $usAct->count()==0 )
                            <p class="text-center">No encontrado usuarios activados.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border">ID usuario</div>
                                <div class="col border">Nombre</div>
                                <div class="col border">Email</div>
                                <div class="col border">Telefono</div>
                                <div class="col border">Registrado</div>
                                <div class="col border">Ultima modificación</div>
                                <div class="col border">Detalles</div>
                            </div>
                            @foreach($usAct as $user)
                            <div class="row">
                                <div class="col border">{{$user->id}}</div>
                                <div class="col border">{{$user->name}}</div>
                                <div class="col border">{{$user->email}}</div>
                                <div class="col border">{{$user->telefono}}</div>
                                <div class="col border">{{$user->created_at}}</div>
                                <div class="col border">{{$user->updated_at}}</div>
                                <div class="col border"><button>desactivar</button></div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @else
    <div>
        <h2>AREA DE ADMINISTRADOR</h2>
        <p>Accesso denegado.</p>
    </div>
    @endif
</body>