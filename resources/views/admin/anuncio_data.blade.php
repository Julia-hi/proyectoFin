<?php
if(Auth::user()->rol =='admin'){
    $stat='ok';
}else{
    $stat = 'error';
} ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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
    @if($stat == 'ok')
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
                        <!-- data del usuario -->
                        <div id="usuar_act" class="p-3">
                            <h2 class="text-center text-success text-uppercase my-2">Anuncio ID: {{$anuncio->id}}</h2>
                            <div class="row">
                                <!-- Información del registro -->
                                <div class="col-lg-4 col-md-6">
                                    <ul>
                                        <li>Tipo: {{$anuncio->tipo}}</li>
                                        <li>Estado: {{$anuncio->estado}}</li>
                                        <li>Autor: <a href="/admin/{{Auth::user()->id}}/users/{{$anuncio->user_id}}">{{$anuncio->user_id}}</a></li>
                                        <li>Publicado: {{$anuncio->created_at}}</li>
                                        @if($anuncio->created_at != $anuncio->updated_at)
                                        <li>Modificado: {{$anuncio->updated_at}} </li>
                                        @else
                                        <li>Anuncio sin cambios</li>
                                        @endif
                                    </ul>
                                </div>
                                <!-- Información sobre anuncios -->
                                <div class="col">
                                    <div>
                                        @if($anuncio->tipo=='oferta')
                                        
                                            <p><b>Titulo</b>: Anuncio {{$anuncio->anuncioOferta->titulo}}</p>
                                            <p><b>Descripción</b>: {{$anuncio->anuncioOferta->descripcion}}</p>
                                            <p><b>Localidad</b>: {{$anuncio->anuncioOferta->poblacion}}({{$anuncio->anuncioOferta->provincia}}, <span class="text-capitalize">{{$anuncio->anuncioOferta->comunidad}})</span></p>
                                            <p><b>Latitud: </b>{{$anuncio->anuncioOferta->lat}}, <b>longitud: </b>{{$anuncio->anuncioOferta->lon}}</p>
                                            <p> contiene {{$anuncio->anuncioOferta->fotos->count()}} fotos:</p>
                                            <ul>
                                                @foreach($anuncio->anuncioOferta->fotos as $ind=>$foto)
                                                <li>foto {{$ind+1}}: <a href="{{$foto->enlace}}">{{$foto->enlace}}</a></li>
                                                @endforeach
                                            </ul>

                                        
                                        @elseif($anuncio->tipo=='demanda')
                                        <ul>
                                            <li><b>Titulo</b>: $anuncio->anuncioDemanda->titulo</li>
                                        </ul>

                                        @endif
                                    </div>
                                    
                                </div>
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

</html>