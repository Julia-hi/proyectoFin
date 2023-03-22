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
                    <div class=" mt-4 p-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div id="anuncios" class="my-3 p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Anuncios</h2>
                            <div class="row bg-success">
                                <div class="col"></div>
                                <div class="col border text-white font-weight-bold">Total</div>
                                <div class="col border text-white font-weight-bold">Anuncios Oferta</div>
                                <div class="col border text-white font-weight-bold">Anuncios Demanda</div>
                            </div>
                            <div class="row">
                                <div class="col border">Total</div>
                                <div class="col border">{{$anunciosData['ofTotal']+$anunciosData['demTotal']}}</div>
                                <div class="col border">{{$anunciosData['ofTotal']}}</div>
                                <div class="col border">{{$anunciosData['demTotal']}}</div>
                            </div>
                            <div class="row">
                                <div class="col border">Ultimo mes</div>
                                <div class="col border">{{$anunciosData['of30dias']+$anunciosData['dem30dias']}}</div>
                                <div class="col border">{{$anunciosData['of30dias']}}</div>
                                <div class="col border">{{$anunciosData['dem30dias']}}</div>
                            </div>
                            <div class="row">
                                <div class="col border">Ultimo año</div>
                                <div class="col border">{{$anunciosData['of365dias']+$anunciosData['dem365dias']}}</div>
                                <div class="col border">{{$anunciosData['of365dias']}}</div>
                                <div class="col border">{{$anunciosData['dem365dias']}}</div>
                            </div>
                        </div>
                        <div id="usuarios" class="my-3 p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Usuarios</h2>
                            <div class="row bg-success">
                                <div class="col"></div>
                                <div class="col border text-white font-weight-bold">Total</div>
                                <div class="col border text-white font-weight-bold">Usuarios activos</div>
                                <div class="col border text-white font-weight-bold">Usuarios bloqueados</div>
                            </div>
                            <div class="row">
                                <div class="col border">Total</div>
                                <div class="col border">{{$usuariosData['activeTotal'] + $usuariosData['bloqueadosTotal']}}</div>
                                <div class="col border">{{$usuariosData['activeTotal']}}</div>
                                <div class="col border">{{$usuariosData['bloqueadosTotal']}}</div>
                            </div>
                            <div class="row">
                                <div class="col border">Ultimo mes</div>
                                <div class="col border">{{$usuariosData['active30dias']+$usuariosData['bloqueados30dias']}}</div>
                                <div class="col border">{{$usuariosData['active30dias']}}</div>
                                <div class="col border">{{$usuariosData['bloqueados30dias']}}</div>
                            </div>
                            <div class="row">
                                <div class="col border">Ultimo año</div>
                                <div class="col border">{{$usuariosData['active365dias'] +$usuariosData['bloquados365dias']}}</div>
                                <div class="col border">{{$usuariosData['active365dias']}}</div>
                                <div class="col border">{{$usuariosData['bloquados365dias']}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <x-footer />
        </footer>
    </div>
    @else
    <div>
        <h2>AREA DE ADMINISTRADOR</h2>
        <p>Accesso denegado.</p>
    </div>
    @endif
</body>