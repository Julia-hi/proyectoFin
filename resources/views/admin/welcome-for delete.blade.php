<?php

use Illuminate\Support\Facades\Storage;

$logoUrl = Storage::url('logo.png');
$scriptUrl = Storage::url('welcome.js') ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MiLorito</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <button type="button" class="mr-2 p-2" onclick="window.location.href='{{ url('/anuncio/crear')}}'">Publicar anuncio</button>
            @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
            @endauth
        </div>
        @endif
        <div class="container">
            <div class="justify-center sm:px-6 lg:px-8">
                <div class="text-center pt-8 sm:justify-start sm:pt-0">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>
                <div class="m-2">
                    <div class=" mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <h2 class="p-2 my-4 text-center">Espacio para amantes de loros</h2>
                        <p class="text-center">Aquí puedes encontrar crías de loros venditos en toda España!
                            Click "ofertas" para encontrar tu amigo! Si eres criador, click "demandas" para encontrar nueva familia para tus crias.</p>
                        <div class="justify-center ">
                            <div class="align-items-center d-flex justify-content-center p-3">
                                <div class="btn-group border d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="ofertas">OFERTAS</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="demandas">DEMANDAS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-2">
                    <!-- Anuncios oferta -->
                    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg" id="ofertas-block">
                        <!-- <h3 class="text-center">Ofertas</h3> -->
                        <div class="row d-flex justify-content-center align-content-center m-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary w-50" onclick="window.location.href='{{ url('/ofertas/lista/todo')}}'" >FILTRAR OFERTAS</button>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4 box-shadow">
                                    <img class="card-img-top" src="" alt="" style="height: 225px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1859bebb3c0%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1859bebb3c0%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.71249771118164%22%20y%3D%22120.18000011444092%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                                    <div class="card-body">
                                        <h3>Cariñoso pollito</h3>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Favoritos</button>
                                            </div>
                                            <small class="text-muted">Publicato hace </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4 box-shadow">
                                    <img class="card-img-top" data-holder-rendered="true" style="height: 225px; width: 100%; display: block;">
                                    <div class="card-body">
                                        <h3>Cariñoso pollito</h3>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Favoritos</button>
                                            </div>
                                            <small class="text-muted">Publicado hace </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Anuncios demanda -->
                    <div class=" mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg" id="demandas-block">
                        <h3 class="text-center">Demandas</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4 box-shadow">
                                    <div class="card-body">
                                        <h3>Cariñoso pollito</h3>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje</button>
                                            </div>
                                            <small class="text-muted">Publicato hace </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4 box-shadow">
                                    <div class="card-body">
                                        <h3>Cariñoso pollito</h3>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje</button>
                                            </div>
                                            <small class="text-muted">Publicato hace </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    <script src="<?php echo $scriptUrl ?>"></script>
</body>

</html>