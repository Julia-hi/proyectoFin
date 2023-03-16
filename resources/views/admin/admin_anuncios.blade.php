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
                        <div id="ofertas_activas" class="p-3">
                            <h2 class="text-center py-2">Ofertas activas</h2>
                            <div class="row bg-success text-white">
                                <div class="col border">ID anuncio</div>
                                <div class="col border">ID autor</div>
                                <div class="col border">Estado</div>
                                <div class="col border">Titulo</div>
                                <div class="col border">Publicado</div>
                                <div class="col border">Ultima modificación</div>
                                <div class="col border"></div>
                            </div>
                            @foreach($ofertasAct as $oferta)
                            <div class="row">
                                <div class="col border">{{$oferta->id}}</div>
                                <div class="col border">{{$oferta->user_id}}</div>
                                <div class="col border">{{$oferta->estado}}</div>
                                <div class="col border">{{$oferta->anuncioOferta->titulo}}</div>
                                <div class="col border">{{$oferta->created_at}}</div>
                                <div class="col border">{{$oferta->updated_at}}</div>
                                <div class="col border"><button>desactivar</button></div>
                            </div>
                            @endforeach
                        </div>

                        <!--Demandas activadas -->
                        <div id="ofertas_noactivas" class="p-3">
                            <h2 class="text-center py-2">Demandas activadas</h2>
                            @if($demandasAct == null || $demandasAct->count()==0 )
                            <p class="text-center">No encontrado demandas activas.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border">ID anuncio</div>
                                <div class="col border">ID autor</div>
                                <div class="col border">Estado</div>
                                <div class="col border">Titulo</div>
                                <div class="col border">Publicado</div>
                                <div class="col border">Ultima modificación</div>
                                <div class="col border">Detalles</div>
                            </div>
                            @foreach($demandasAct as $demanda)
                            <div class="row">
                                <div class="col border">{{$demanda->id}}</div>
                                <div class="col border">{{$demanda->user_id}}</div>
                                <div class="col border">{{$demanda->estado}}</div>
                                <div class="col border">{{$demanda->anuncioDemanda->titulo}}</div>
                                <div class="col border">{{$demanda->created_at}}</div>
                                <div class="col border">{{$demanda->updated_at}}</div>
                                <div class="col border"><button>desactivar</button></div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <!-- Ofertas desactivadas -->
                        <div id="ofertas_noactivas" class="p-3">
                            <h2 class="text-center py-2">Ofertas desactivadas</h2>
                            @if($ofertasDesact ==null || $ofertasDesact->count()==0 )
                            <p class="text-center">No encontrado ofertas desactivadas.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border">ID anuncio</div>
                                <div class="col border">ID autor</div>
                                <div class="col border">Estado</div>
                                <div class="col border">Titulo</div>
                                <div class="col border">Publicado</div>
                                <div class="col border">Ultima modificación</div>
                                <div class="col border">Detalles</div>
                            </div>
                            @foreach($ofertasDesact as $oferta)
                            <div class="row">
                                <div class="col border">{{$oferta->id}}</div>
                                <div class="col border">{{$oferta->user_id}}</div>
                                <div class="col border">{{$oferta->estado}}</div>
                                <div class="col border">{{$oferta->anuncioOferta->titulo}}</div>
                                <div class="col border">{{$oferta->created_at}}</div>
                                <div class="col border">{{$oferta->updated_at}}</div>
                                <div class="col border"><button>activar</button></div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <!-- Demandas desactivadas -->
                        <div id="ofertas_noactivas" class="p-3">
                            <h2 class="text-center py-2">Demandas desactivadas</h2>
                            @if($demandasDesact ==null || $demandasDesact->count()==0 )
                            <p class="text-center">No encontrado ofertas desactivadas.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border">ID anuncio</div>
                                <div class="col border">ID autor</div>
                                <div class="col border">Estado</div>
                                <div class="col border">Titulo</div>
                                <div class="col border">Publicado</div>
                                <div class="col border">Ultima modificación</div>
                                <div class="col border">Detalles</div>
                            </div>
                            @foreach($demandasDesact as $demanda)
                            <div class="row">
                                <div class="col border">{{$demanda->id}}</div>
                                <div class="col border">{{$demanda->user_id}}</div>
                                <div class="col border">{{$demanda->estado}}</div>
                                <div class="col border">{{$demanda->anuncioOferta->titulo}}</div>
                                <div class="col border">{{$demanda->created_at}}</div>
                                <div class="col border">{{$demanda->updated_at}}</div>
                                <div class="col border"><button>activar</button></div>
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