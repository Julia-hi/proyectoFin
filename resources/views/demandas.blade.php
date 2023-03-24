<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MiLorito</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo Storage::url('css/mi_estilo.css') ?>">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<?php $backgrounImg = Storage::url('images/hojas-fondo1.svg'); ?>

<body class="antialiased mt-0">
    <!-- Page Heading - resources/views/components/header.blade.php -->
    <header>
        <x-header />
    </header>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <div class="align-self-center">
                @guest
                <a type="button" class="nav-botton red-brillante-boton mr-2 text-center" href="{{ url('/login')}}" tabindex="0"><span>Publicar anuncio</span></a>
                @endguest
                @auth

                <?php $user_name = Auth::user()->name;
                $user_id = Auth::user()->id; ?><div class="row">
                    <div class="col m-0">
                        <a type="button" class="nav-botton h-100 red-brillante-boton mr-2 p-2 text-center" href="/user/<?php echo $user_id; ?>/anuncios-demanda/create" tabindex="0"><span>Publicar anuncio</span></a>
                    </div><!-- <a href="{{ url('/dashboard') }}" class="bg-light rounded p-2 text-sm text-gray-700 dark:text-gray-500 underline"><?php echo $user_name; ?></a> -->
                    <div class="col m-0">
                        @if(Auth::user()->rol =="user")
                        @include('layouts.navigation-welcome')
                        @elseif(Auth::user()->rol =="admin")
                        @include('layouts.navigation-welcome-admin')
                        @endif
                    </div>
                </div>
                @endauth
                @guest
                <a href="{{ route('login') }}" class="bg-light rounded p-2 text-sm text-gray-700 dark:text-gray-500 underline">Iniciar sesión</a>

                <a href="{{ route('register') }}" class="bg-light rounded p-2 ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Crear cuenta</a>
                @endguest

            </div>
        </div>

        <div class="container">
            <div class="justify-center sm:px-6 lg:px-8">
                <div class="m-2">
                    <div class=" mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">

                    </div>
                    <!--   Block para anuncios de demanda   -->
                    <div class="mt-8 p-2 bg-yellow dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <?php
                        if ($demandas == null) { ?>
                            <div class="text-center">
                                <div class="row d-flex justify-content-center align-content-center m-3">
                                    <a type="button" class="green-brillante-boton w-50" href="{{ url()->previous() }}"><strong>VOLVER</strong></a>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    @if( $demandas!=null && $demandas->count()>0)
                                    @foreach ($demandas as $demanda)
                                    <div class="col-md-4">
                                        <div class="card mb-4" style="height: 500px;">
                                            <div class="card-body">
                                                <div class="" style="height: 30%;">
                                                    <h3 class="text-uppercase pb-2">{{ $demanda->titulo}}</h3>
                                                    <div class="d-flex align-items-stretch" style="overflow: hidden; text-overflow: ellipsis;">
                                                        <p class="card-text text-capitalise">{{ $demanda->descripcion }}</p>
                                                    </div>
                                                </div>
                                                <div class="position-absolute bottom-0 left-0 w-100 mb-2 p-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje</button>

                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Publicato: {{ $demanda->created_at->format('M j, Y') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @elseif($stat=='error')
                                    <h4 class="text-center">Disculpa, la conexion fallida, intenta más tarde...</h4>
                                    @else
                                    <h4 class="text-center">Disculpa, no hemos encontrado anuncios...</h4>
                                    @endif
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('storage/js/of-lista.js')}}"></script>
</body>

</html>