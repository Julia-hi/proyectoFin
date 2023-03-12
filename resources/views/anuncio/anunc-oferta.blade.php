<!-- 
# autor: Yulia Tropin Tropina 3DAW Distancia IES "Trassierra"
# Proyecto fin del curso "MiLorito" 
# Vista para uno anuncio oferta 
-->

<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
?>
@auth
<?php
try {
    $user = Auth::user();
} catch (Exception $ex) {
    $user = null;
    $status = "error";
}

if ($user != null) {
    $user_name = $user->name;
    $user_id = $user->id;
}
?>
@endauth

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    <title>MiLorito</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('storage/css/mi_estilo.css')}}">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">

    <div class="hojas relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 py-4 sm:pt-0 ">
        @if (Route::has('login'))
        <div class="fixed top-0 right-0 px-6 py-4 sm:block">
            @guest
            <a type="button" class="red-brillante-boton mr-1 p-2 text-center" href="{{ Auth::check() ? '/user/' . $user_id . '/anuncios-oferta/create' : '/login?redirect_to=' . Request::path() }}" tabindex="0"><span>Publicar anuncio</span></a>
            @endguest
            @auth
            <div class="row">
                <div class="col m-0">
                    <a type="button" class="nav-botton h-100 red-brillante-boton p-2 text-center" href="/user/<?php echo $user_id; ?>/anuncios-oferta/create" tabindex="0"><span>Publicar anuncio</span></a>
                </div>
                <div class="col m-0">
                    @if($user!=null)
                    @include('layouts.navigation-welcome')
                    @endif
                </div>
            </div>
            @else
            <a href="{{ route('login') }}" class="bg-light rounded p-2 text-sm text-gray-700 dark:text-gray-500 underline">Iniciar sesión</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="bg-light rounded p-2 ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Crear cuenta</a>
            @endif
            @endauth
        </div>
        @endif
        <div class="container">
            <div id="draggable" class="w-25 rounded border shadow hidden">
                <h3 class="p-2">Vas a enviar mensaje a {{ $autor->name }}</h3>
                @auth
                <form method="POST" action="{{ route('user.mensajes.store',$autor->id) }}">
                    @csrf
                    <textarea class="form-control" id="mensaje" rows="10" name="texto" placeholder="Escribe mensaje aquí..."></textarea>
                    <x-input-error :messages="$errors->get('texto')" class="mt-2" />
                    <input hidden name="anuncio_id" type="text" value="{{ $oferta->id }}" />
                    <input hidden name="remitente_id" type="text" value="{{ Auth::user()->id }}" />
                    <div class="d-flex items-center justify-content-between my-4">
                        <x-primary-button class="ml-3">
                            {{ __('Enviar') }}
                        </x-primary-button>
                        <button id="cerrar_dragable" type="button" class="cerrar_dragable btn">Cerrar</button>
                    </div>
                </form>
                @endauth
            </div>

            <div class="justify-center sm:px-6 lg:px-8 h-auto">
                <div class="d-flex flex-row justify-content-center align-items-end" style="height:20vh; max-height: 150px;">
                    <img src="{{asset('storage/images/logo.svg')}}" alt="Logo MiLorito" class="h-75 mt-3 mb-1" onclick="location.href='/'" style="cursor: pointer;">
                </div>
                <div class="m-2 h-auto">
                    <!-- Anuncio oferta -->
                    <div id="" class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg  p-3">
                        <div class="row d-flex justify-content-center align-content-center m-3">
                            <a type="button" class="btn btn-sm btn-outline-secondary w-50" href="{{ url()->previous() }}">VOLVER</a>
                        </div>
                        <div class="row h-auto">
                            @if($oferta!=null)
                            <div class="border rounded" style="min-height: 500px;">
                                <div class="card-body">
                                    <div class="row">
                                        @if($fotos->count()<=1) <div style="height: auto;">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="h-100 p-2">
                                                    <img src="<?php echo $fotos->first()->enlace; ?>" alt="" style="max-height:450px; min-width:400px; object-fit: cover;" data-holder-rendered="true">
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-md-6 col-sm-12 md:px-5 sm:px-1">
                                                <?php $fotos = $oferta->fotos; ?>
                                                <div id="carouselControl" class="carousel slide position-relative" data-ride="carousel">
                                                    <div class="carousel-inner carousel-inner0">
                                                        @foreach($fotos as $foto)
                                                        <div class="carousel-item active p-3 ">
                                                            <img class="d-block w-100" style="height: 450px; width: auto; display: block; object-fit: cover" src="<?php echo ($foto->enlace); ?>" alt="First slide">
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <a id="prev" class="carousel-control-prev" href="#carouselControl" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previo</span>
                                                    </a>
                                                    <a id="next" class="carousel-control-next" href="#carouselControl" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Siguiente</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- FIN SLIDER -->
                                            @endif
                                            <div class="col-md-6 col-sm-12 p-2 min-h-100">
                                                <div class="d-flex flex-column w-100 justify-content-between h-100">
                                                    <div>
                                                        <div class="d-flex flex-row justify-content-between">
                                                            <h1 class="text-uppercase pb-2">{{ $oferta->titulo }}</h1>
                                                            @auth
                                                            @if($user->id != $autor->id)
                                                            <div class="position-relative">
                                                                @if(!$oferta->anuncio->esFavorito(Auth::user(), $oferta->anuncio))
                                                                <!-- formulario para Eñadir a favoritos -->
                                                                <form method="POST" action="{{ route('user.favoritos.store',['user' => $user_id]) }}">
                                                                    @csrf
                                                                    <input type="hidden" name="anuncio_id" value="{{ $oferta->id }}">
                                                                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                                                                    <button type="submit" title="Añadir a favoritos"><img src="<?php echo Storage::url('images/icons/heart-regular.svg'); ?>" style="width:1.5em;" class="mx-2"></button>
                                                                </form>
                                                                @else
                                                                <?php $favorito = $oferta->favoritos->first(); ?>
                                                                <!-- formulario para Eliminar favorito de la lista -->
                                                                <form method="POST" action="{{ route('user.favoritos.destroy', [$user, $favorito]) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" title="Eliminar de favoritos"><img src="<?php echo Storage::url('images/icons/heart-solid.svg'); ?>" style="width:1.5em;" class="mx-2"></button>
                                                                </form>
                                                                @endif
                                                            </div>
                                                            @endif
                                                            @endauth
                                                        </div>
                                                        <h2>Raza: <span class="text-capitalize">{{ $oferta->raza }}</span></h2>
                                                        <h2>Genero: <span class="text-capitalize">{{ $oferta->genero }}</span></h2>
                                                        <h2>Nacido: <span class="text-capitalize">{{ $oferta->fecha_nac }}</span></h2>
                                                        <h2>Localidad: <span class="text-capitalize">{{$oferta->poblacion}}, {{$oferta->provincia}}({{ $oferta->comunidad }})</span></h2>
                                                    </div>
                                                    <div class="mt-3 max-h-50">
                                                        <h2 class="mb-1">Descripción: </h2>
                                                        <p class="card-text my-1">{{ $oferta->descripcion }}</p>
                                                    </div>
                                                    <div>
                                                        <div class="w-100 d-flex flex-row justify-content-between align-items-center">
                                                            @guest
                                                            <p class="text-left py-2">No estas logueado, por favor, <a href="/login"><b>inicia seccion</b></a> para enviar mensaje y ver telefono del anunciante. Nosotros respetamos privacidad de los
                                                                usuarios, por este motivo uso de mansajeria disponibile solo para usuarios registrados.</p>

                                                            @endguest
                                                            @auth
                                                            @if($autor->id!= Auth::user()->id)
                                                            <button id="crearMensaje" type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje a {{ $autor->name }}</button>
                                                            @endif
                                                            <div class="d-flex flex-row"><img src="{{asset('storage/images/icons/square-phone-flip-solid.svg')}}" style="width:1.2em;" class="mr-2">
                                                                <span>{{$autor->telefono}}</span>
                                                            </div>
                                                            @endauth
                                                        </div>
                                                        <div class="align-self-baseline ">
                                                            <small class="text-muted">Publicato: {{ $oferta->created_at->format('M j, Y') }}</small>
                                                            <p>Anunciante: {{ $autor->name }}</p>
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
        </div>
        <!-- FIN del bloque de uno Anuncio demanda -->
        @elseif($status=='error')
        <div class="text-center">Disculpa, la conexion fallida, intenta más tarde...</div>
        @else
        <div class="text-center">Disculpa, este anuncio ya no está disponible.</div>
        @endif
    </div>

    <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('storage/js/anuncio-oferta.js')}}"></script>
    <script src="{{asset('storage/js/slider.js')}}"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</body>

</html>