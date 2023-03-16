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
    @if($status=='error')
    <div class="hojas relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 py-4 sm:pt-0 ">
        <div class="container">
            <div class="justify-center sm:px-6 lg:px-8 ">
                <div class="d-flex flex-row justify-content-center align-items-end" style="height: 150px;">
                    <img src="{{asset('storage/images/logo.svg')}}" alt="Logo MiLorito" class="h-75 mt-3 mb-1">
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
                    @if($user!=null && $user->rol=='user')
                    @include('layouts.navigation-welcome')
                    @elseif($user!=null && $user->rol=='admin')
                    @include('layouts.navigation-welcome-admin')
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
                <!-- Anuncios oferta -->
                <div id="ofertas-block" class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg  p-3">
                    <div class="row d-flex justify-content-center align-content-center m-3">
                        <form action="{{ route('filter.index') }}">
                            <input hidden type="text" name="comunidad" id="comunidad" value="todo">
                            <input hidden type="text" name="provincia" id="provincia" value="todo">
                            <input hidden type="text" name="poblacion" id="poblacion" value="todo">
                            <input hidden type="text" name="raza" id="raza" value="todo">
                            <input hidden type="text" name="genero" id="genero" value="todo">
                            <div class="w-100 row d-flex justify-content-center align-content-center">
                                <button type="submit" class="btn btn-sm btn-outline-secondary w-auto mw-75">VER TODAS OFERTAS</button>
                            </div>
                        </form>
                    </div>
                    <!-- anuncio oferta -->
                    @if( $ofertas!=null && $ofertas->count()>0)
                    <div class="row">
                        @foreach ($ofertas as $oferta)
                        <?php $url = '/ofertas/' . $oferta->id;
                        $fotos = $oferta->fotos; ?>
                        <div class="col-4 position-relative " style="width: 400px; height: 400px; cursor: pointer;" onclick="window.location='{{ $url }}';">
                            <div class="p-1 w-100 h-100">
                                <img class="border border-1 border-success rounded w-100 h-100 m-1" src="<?php echo $fotos[0]->enlace; ?>" alt="" style="display: block; object-fit: cover" data-holder-rendered="true">
                                <div class="position-absolute bottom-0 row text-white w-100 p-2">
                                    <div class="col-6 text-left">
                                        <h3 class="text-uppercase align-items-center p-0 m-0">{{ $oferta->titulo}}</h3>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <small class="">Publicado: {{ $oferta->created_at->format('M j, Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- FIN del bloque de uno Anuncio oferta -->
                    @elseif($status=='error')
                    <!-- Este mensaje muestra cuando conexion con la base de datos falla -->
                    <h4 class="text-center">Disculpa, la conexion fallida, intenta más tarde...</h4>
                    @else
                    <!-- Este mensaje muestra cuando conexion con hay anuncios de oferta en la base de datos -->
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
                                <div class="descripcion d-flex align-items-stretch" style="line-height:1.2em; max-height: 3.6em; overflow: hidden; ">
                                    {{ $demanda->descripcion }}
                                </div>
                                <div class="position-absolute bottom-0 left-0 w-100 mb-2 p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <?php $url = '/demandas/' . $demanda->id; ?>
                                            <a href="<?php echo $url; ?>" class="btn btn-sm btn-outline-secondary">
                                                <span class="text-center align-middle">Ver</span>
                                            </a>
                                            @auth
                                            <?php $user_id = Auth::user()->id;
                                            $user = Auth::user();
                                            ?>
                                            <!-- Muestra boton de favoritos solo si usuario no es autor del anuncio -->
                                            @if($oferta->autor->id!=$user->id)
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
                    <!-- Este mensaje muestra cuando conexion con la base de datos falla -->
                    <div class="text-center">Disculpa, la conexion fallida, intenta más tarde...</div>
                    @else
                    <!-- Este mensaje muestra cuando conexion con hay anuncios de demanda en la base de datos -->
                    <div class="text-center">Disculpa, no hemos encontrado anuncios...</div>
                    @endif
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