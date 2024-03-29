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
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="author" content="yuju.web@gmail.com">
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
    @include('cookie-consent::index')
    @if($status=='error')
    <div class="hojas relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 py-4 sm:pt-0 " style="z-index:10;">
        <div class="container">
            <div class="justify-center sm:px-6 lg:px-8 ">
                <div class="d-flex flex-row justify-content-center align-items-end " style="height: 150px; ">
                    <img src="{{asset('storage/images/logo.svg')}}" alt="Logo MiLorito" class="h-75 mt-3 mb-1">
                </div>
                <div class="my-0">
                    <div class="mt-6 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg bg-success">
                        <h2 class="p-2 my-4 text-center">Espacio para amantes de loros</h2>
                        <div class="text-center my-3">Disculpa, la conexión fallida, intenta más tarde por favor...</div>
                        <div class="w-100 d-flex justify-content-center mt-4">
                            <img class="md:w-25 xs:w-50" src="{{asset('storage/images/periquitos.png')}}" alt="">
                        </div>
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
            <div class="row ">
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
            <div class="justify-center sm:px-2 lg:px-4">
                <div class="d-flex flex-row justify-content-center align-items-end position-static" style="height: 150px;">
                    <img src="{{asset('storage/images/logo.svg')}}" alt="Logo MiLorito" class="h-75 mt-3 mb-1">
                </div>
                <div class="my-0">
                    <div class="mt-6 p-2 bg-yellow dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg" style="z-index:0;">
                        <h2 class="p-2 my-3 text-center h3">Espacio para amantes de loros</h2>
                        <p class="text-center">Bienvenido, amigo! Si te encantan loros, eres criador o buscas un pajarito, estas en sitio correcto!
                            Aquí puedes encontrar crías de loros disponibles en toda España! Crea tu cuenta para poder conectar con anunciantes - es gratis.
                            Clic "ofertas" para encontrar tu nuevo amiguito! Si eres criador, haz clic "demandas" para encontrar nueva familia para tus crias. </p>
                        <div class="justify-center ">
                            <div class="align-items-center d-flex justify-content-center p-3">
                                <div class="btn-group border d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-outline-success active px-2" id="ofertas" style="min-width:100px;"><strong>OFERTAS</strong></button>
                                    <button type="button" class="btn btn-sm btn-outline-success" id="demandas" style="min-width:100px;"><strong>DEMANDAS</strong></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Anuncios oferta -->
                <div id="ofertas-block" class="mt-8 p-2 bg-yellow dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg" style="min: height 25vh;">
                    @if( $ofertas!=null && $ofertas->count()>0)
                    <div class="row d-flex justify-content-center align-content-center m-3">
                        <form action="{{ route('filter.index') }}">
                            <input type="hidden" name="comunidad" id="comunidad" value="todo">
                            <input type="hidden" name="provincia" id="provincia" value="todo">
                            <input type="hidden" name="poblacion" id="poblacion" value="todo">
                            <input type="hidden" name="raza" id="raza" value="todo">
                            <input type="hidden" name="genero" id="genero" value="todo">
                            <div class="w-100 row d-flex justify-content-center align-content-center">
                                <button type="submit" class="green-brillante-boton w-50">VER TODAS OFERTAS</button>
                            </div>
                        </form>
                    </div>
                    @endif
                    <!-- anuncio oferta particular -->
                    @if( $ofertas!=null && $ofertas->count()>0)
                    <div class="row m-0 p-1">
                        @foreach ($ofertas as $oferta)
                        <?php
                        $fotos = $oferta->fotos; ?>
                        <div class="col-md-6 col-lg-4 col-xl-3 position-relative" style="max-width: 400px; height: 400px; cursor: pointer; z-index:0;" onclick="window.location='{{ '/ofertas/' . $oferta->id }}';">
                            <div class="p-1 w-100 h-100">
                                <img class="border border-1 border-success rounded w-100 h-100 m-1" src="<?php echo $fotos[0]->enlace; ?>" alt="" style="display: block; object-fit: cover;z-index:0;" data-holder-rendered="true">
                                <div class="position-absolute bottom-0 row bg-yellow w-100 p-2" style="height:60px;">
                                    <div class="col-6 text-left">
                                        <h3 class="text-uppercase align-items-center p-0 m-0"><strong>{{ $oferta->titulo}}</strong></h3>
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
                    <div class="w-100 d-flex justify-content-center mt-4">
                        <img class="md:w-25 xs:w-50" src="{{asset('storage/images/periquitos.png')}}" alt="">
                    </div>
                    @else
                    <!-- Este mensaje muestra cuando conexion con hay anuncios de oferta en la base de datos -->
                    <h4 class="text-center">Disculpa, no hemos encontrado anuncios...</h4>
                    <div class="w-100 d-flex justify-content-center mt-4">
                        <img class="md:w-25 xs:w-50" src="{{asset('storage/images/periquitos.png')}}" alt="">
                    </div>
                    @endif
                </div>

                <!-- ANUNCIOS DEMANDA -->
                <div id="demandas-block" class="mt-8 p-2 bg-yellow dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg d-none" style="min-height:400px;">
                    <div class="row">
                        <!-- bloque de uno Anuncio demanda -->
                        @if( $demandas!=null && $demandas->count()>0)
                        @foreach ($demandas as $demanda)
                        <div class="col-md-6 col-lg-4 col-xs-12">
                            <div class="card mb-2" style="min-height: 200px;">
                                <div class="card-body ">
                                    <h3 class="text-uppercase pb-2">{{ $demanda->titulo }}</h3>
                                    <div class="descripcion d-flex align-items-stretch" style="line-height:1.2em; max-height: 3.6em; overflow: hidden; ">
                                        {{ $demanda->descripcion }}
                                    </div>
                                    <div class="position-absolute bottom-0 left-0 w-100 h-auto mb-1 p-2">
                                        <div class="w-100 d-flex flex-md-row flex-xs-column-reverse justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <?php $url = '/demandas/' . $demanda->id; ?>
                                                <a href="<?php echo $url; ?>" class="btn-green rounded text-center" style="min-width:50px; height:30px;">
                                                    <strong class="text-center align-middle px-2">Detalles</strong>
                                                </a>
                                                @auth
                                                <?php $user_id = Auth::user()->id;
                                                $user = Auth::user();
                                                ?>
                                                <!-- Muestra boton de favoritos solo si usuario no es autor del anuncio -->
                                                @if($demanda->autor->id!=$user->id)
                                                <!-- si anuncio ya añadido a favoritos mostra botón para eliminar de favoritos, 
                                                        si no es favorito - mostra borón para añadir a favoritos -->
                                                @if(!$demanda->anuncio->esFavorito($user, $demanda->anuncio))
                                                <form method="POST" action="{{ route('user.favoritos.store',['user' => $user->id]) }}">
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
                        <div class="w-100 d-flex justify-content-center mt-4">
                            <img class="md:w-25 xs:w-50" src="{{asset('storage/images/periquitos.png')}}" alt="">
                        </div>
                        @else
                        <!-- Este mensaje muestra cuando conexion con hay anuncios de demanda en la base de datos -->
                        <div class="text-center">Disculpa, no hemos encontrado anuncios...</div>
                        <div class="w-100 d-flex justify-content-center mt-4">
                            <img class="md:w-25 xs:w-50" src="{{asset('storage/images/periquitos.png')}}" alt="">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <x-footer />
    </footer>
    <script src="{{asset('storage/js/welcome.js')}}"></script>
    @endif
</body>

</html>
