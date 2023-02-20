<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

$logoUrl = Storage::url('logo.png');
$scriptUrl = Storage::url('welcome.js'); ?>
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
    <link rel="stylesheet" href="<?php echo Storage::url('css/mi_estilo.css') ?>">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<?php $backgrounImg = Storage::url('images/hojas-fondo1.svg'); ?>

<body class="antialiased">
    
    @if($status=='error')
    <div class="hojas relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 py-4 sm:pt-0 ">
        <div class="container">
            <div class="justify-center sm:px-6 lg:px-8 ">
                <div class="d-flex flex-row justify-content-center align-items-end" style="height: 150px;">
                    <img src="<?php echo Storage::url('images/logo.svg'); ?>" alt="Logo MiLorito" class="h-75 mt-3 mb-1">
                </div>
                <div class="my-0">
                    <div class="mt-6 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <h2 class="p-2 my-4 text-center">Espacio para amantes de loros</h2>
                        <div class="text-center my-3">Disculpa, la conexión fallida, intenta más tarde por favor...</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @else
    <!-- Page Heading - resources/views/components/header.blade.php -->

    <div class="hojas relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 py-4 sm:pt-0 ">

        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @guest
            <a type="button" class="red-brillante-boton mr-2 p-2 text-center" href="{{ url('/login')}}" tabindex="0"><span>Publicar anuncio</span></a>
            @endguest
            @auth
            <div class="row">
                <div class="col m-0">
                    <a type="button" class="nav-botton h-100 red-brillante-boton mr-2 p-2 text-center" href="/user/<?php echo $user_id; ?>/anuncios-oferta/create" tabindex="0"><span>Publicar anuncio</span></a>
                </div><!-- <a href="{{ url('/dashboard') }}" class="bg-light rounded p-2 text-sm text-gray-700 dark:text-gray-500 underline"><?php echo $user_name; ?></a> -->
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
            <div class="justify-center sm:px-6 lg:px-8 ">
                <div class="d-flex flex-row justify-content-center align-items-end" style="height: 150px;">
                    <img src="<?php echo Storage::url('images/logo.svg'); ?>" alt="Logo MiLorito" class="h-75 mt-3 mb-1">
                </div>
                <div class="my-0">
                    <div class="mt-6 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <h2 class="p-2 my-4 text-center">Espacio para amantes de loros</h2>
                        <p class="text-center">Aquí puedes encontrar crías de loros venditos en toda España!
                            Click "ofertas" para encontrar tu amigo! Si eres criador, click "demandas" para encontrar nueva familia para tus crias.</p>
                        <div class="justify-center ">
                            <div class="align-items-center d-flex justify-content-center p-3">
                                <div class="btn-group border d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-outline-secondary active" id="ofertas">OFERTAS</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="demandas">DEMANDAS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-2">
                    <!-- Anuncios oferta -->
                    <div id="ofertas-block" class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg  p-3">
                        <div class="row d-flex justify-content-center align-content-center m-3">
                            <a type="button" class="btn btn-sm btn-outline-secondary w-50" href="{{ url('/ofertas')}}">VER TODAS OFERTAS</a>
                        </div>
                        <div class="row">
                            <!-- anuncio oferta -->
                            @if( $ofertas!=null && $ofertas->count()>0)
                            @foreach ($ofertas as $oferta)
                            <div class="col-md-4">
                                <div class="card mb-4" style="height: 500px;">
                                    <div class="card-body">
                                        <?php $fotos = $oferta->fotos; ?>
                                        @foreach($fotos as $foto)
                                        <div style="height: 70%;">
                                            <img class="card-img-top rounded" src="<?php echo $foto->enlace; ?>" alt="" style="height: 300px; display: block; object-fit: cover" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1859bebb3c0%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1859bebb3c0%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.71249771118164%22%20y%3D%22120.18000011444092%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                                        </div>
                                        @endforeach
                                        <div class="" style="height: 30%;">
                                            <h3 class="text-uppercase pb-2">{{ $oferta->titulo}}</h3>
                                            <div class="d-flex align-items-stretch" style="overflow: hidden; text-overflow: ellipsis;">
                                                <p class="card-text text-capitalise">{{ $oferta->descripcion }}</p>
                                            </div>
                                        </div>
                                        <div class="position-absolute bottom-0 left-0 w-100 mb-2 p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <?php $url = '/ofertas/' . $oferta->id; ?>
                                                    <a href="<?php echo $url; ?>" class="btn btn-sm btn-outline-secondary">
                                                        <span class="text-center align-middle">Ver</span>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                                        <span class="text-center">Enviar mensaje</span>
                                                    </button>
                                                    @auth
                                                    <?php $user_id = Auth::user()->id;
                                                    $user = Auth::user();
                                                    ?>
                                                    <!-- si anuncio ya añadido a favoritos mostra botón para eliminar de favoritos, 
                                                        si no es favorito - mostra borón para añadir a favoritos -->
                                                    @if(!$oferta->anuncio->esFavorito($user, $oferta->anuncio))
                                                    <form method="POST" action="{{ route('user.favoritos.store',['user' => $user_id]) }}">
                                                        @csrf
                                                        <input type="hidden" name="anuncio_id" value="{{ $oferta->id }}">
                                                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                                                        <button type="submit" data-title="Guardar a favoritos">
                                                            <img src="<?php echo Storage::url('images/icons/heart-regular.svg'); ?>" style="width:1.5em;" class="h-auto mx-2 py-1">
                                                        </button>
                                                    </form>
                                                    @else
                                                    <?php $favorito = $oferta->anuncio->favoritos->first(); ?>
                                                    <!-- formulario para Eeiminar favorito de la lista -->
                                                    <form method="POST" action="{{ route('user.favoritos.destroy', [$user, $favorito]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" data-title="Eliminar de favoritos">
                                                            <img src="<?php echo Storage::url('images/icons/heart-solid.svg'); ?>" style="width:1.5em;" class="h-auto mx-2 py-1">
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @endauth
                                                    @guest
                                                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary"><img title="Guardar como favorito" src="<?php echo Storage::url('images/icons/heart-regular.svg'); ?>" style="width:1.5em;" class="mx-2"></a>
                                                    @endguest
                                                </div>
                                                <div>
                                                    <small class="text-muted">Publicato: {{ $oferta->created_at->format('M j, Y') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- FIN del bloque de uno Anuncio oferta -->
                            @elseif($status=='error')
                            <h4 class="text-center">Disculpa, la conexion fallida, intenta más tarde...</h4>
                            @else
                            <h4 class="text-center">Disculpa, no hemos encontrado anuncios...</h4>
                            @endif
                        </div>
                    </div>

                    <!-- ANUNCIOS DEMANDA -->
                    <div id="demandas-block" class="mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg d-none">

                        <div class="row">
                            <!-- bloque de uno Anuncio demanda -->
                            @if( $demandas!=null && $demandas->count()>0)

                            @foreach ($demandas as $demanda)
                            <div class="col-md-4">
                                <div class="card mb-4" style="height: 200px;">
                                    <div class="card-body ">
                                        <h3 class="text-uppercase pb-2">{{ $demanda->titulo }}</h3>
                                        <p class="card-text py-2">{{ $demanda->descripcion }}</p>
                                        <div class="position-absolute bottom-0 left-0 w-100 mb-2 p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <?php $url = '/demandas/' . $demanda->id; ?>
                                                    <a href="<?php echo $url; ?>" class="btn btn-sm btn-outline-secondary">
                                                        <span class="text-center align-middle">Ver</span>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje</button>
                                                    @auth
                                                    <?php $user_id = Auth::user()->id;
                                                    $user = Auth::user();
                                                    ?>
                                                    <!-- si anuncio ya añadido a favoritos mostra botón para eliminar de favoritos, 
                                                        si no es favorito - mostra borón para añadir a favoritos -->
                                                    @if(!$demanda->anuncio->esFavorito($user, $demanda->anuncio))
                                                    <form method="POST" action="{{ route('user.favoritos.store',['user' => $user_id]) }}">
                                                        @csrf
                                                        <input type="hidden" name="anuncio_id" value="{{ $demanda->id }}">
                                                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                                                        <!-- botton para añadir a favoritos -->
                                                        <button type="submit" data-title="Guardar a favoritos">
                                                            <img src="<?php echo Storage::url('images/icons/heart-regular.svg'); ?>" style="width:1.5em;" class="h-auto mx-2 py-1">
                                                        </button>
                                                    </form>
                                                    @else
                                                    <?php $favorito = $demanda->anuncio->favoritos->first(); ?>
                                                    <!-- formulario para Eeiminar favorito de la lista -->
                                                    <form method="POST" action="{{ route('user.favoritos.destroy', [$user, $favorito]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <!-- botton para elliminar de favoritos -->
                                                        <button type="submit" data-title="Eliminar de favoritos">
                                                            <img src="<?php echo Storage::url('images/icons/heart-solid.svg'); ?>" style="width:1.5em;" class="h-auto mx-2 py-1">
                                                        </button>
                                                    </form>
                                                    @endif
                                                    @endauth
                                                    @guest
                                                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary"><img title="Guardar como favorito" src="<?php echo Storage::url('images/icons/heart-regular.svg'); ?>" style="width:1.5em;" class="mx-2"></a>
                                                    @endguest
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

                            <!-- FIN del bloque de uno Anuncio demanda -->

                            @elseif($status=='error')
                            <div class="text-center">Disculpa, la conexion fallida, intenta más tarde...</div>
                            @else
                            <div class="text-center">Disculpa, no hemos encontrado anuncios...</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    <script src="{{asset('storage/js/welcome.js')}}"></script>
    @endif
</body>

</html>