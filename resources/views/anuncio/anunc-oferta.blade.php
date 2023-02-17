<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

$logoUrl = Storage::url('logo.png');

?>
<!-- Vista del anuncio demanda elegido -->
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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<?php $backgrounImg = Storage::url('images/hojas-fondo1.svg'); ?>

<body class="antialiased">
    <!-- Page Heading - resources/views/components/header.blade.php -->

    <div class="hojas relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 py-4 sm:pt-0 ">

        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @guest
            <a type="button" class="red-brillante-boton mr-2 p-2 text-center" href="{{ url('/login')}}" tabindex="0"><span>Publicar anuncio</span></a>
            @endguest
            @auth
            <?php $user_name = Auth::user()->name;
            $user_id = Auth::user()->id; ?>
            <a type="button" class="red-brillante-boton mr-2 p-2 text-center" href="/user/<?php echo $user_id; ?>/anuncios-oferta/create" tabindex="0"><span>Publicar anuncio</span></a>
            <a href="{{ url('/dashboard') }}" class="bg-light rounded p-2 text-sm text-gray-700 dark:text-gray-500 underline"><?php echo $user_name; ?></a>
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
                   <a href="/"> <img src="<?php echo Storage::url('images/logo.png'); ?>" alt="Logo MiLorito" class="h-75 mt-3 mb-1"></a>
                </div>

                <div class="m-2">
                    <!-- Anuncio oferta -->
                    <div id="" class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg  p-3">

                        <div class="row d-flex justify-content-center align-content-center m-3">
                            <a type="button" class="btn btn-sm btn-outline-secondary w-50" href="{{ url()->previous() }}">VOLVER</a>
                        </div>
                        <div class="row">
                            @if($oferta!=null)
                            <div class="col-md-12">
                                <div class="card" style="height: 500px;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($fotos->count()<=1) <div style="height: auto;">
                                                    <img class="rounded h-auto w-100" src="<?php echo $fotos->first()->enlace; ?>" alt="" style="object-fit: cover;" data-holder-rendered="true">
                                            </div>
                                            @else
                                            <div class="col-md-6">
                                                <!-- Slider de fotos https://getbootstrap.com/docs/4.0/components/carousel/ -->
                                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                    <ol class="carousel-indicators">
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                                    </ol>
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item active">
                                                            <img class="d-block w-100" src="..." alt="First slide">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img class="d-block w-100" src="..." alt="Second slide">
                                                        </div>
                                                        <div class="carousel-item">
                                                            <img class="d-block w-100" src="..." alt="Third slide">
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- FIN SLIDER -->
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <h3 class="text-uppercase pb-2">{{ $oferta->titulo }}</h3>
                                            <h3>Raza: {{ $oferta->rasa }}</3>
                                            <p>Genero: {{ $oferta->genero }}</p>
                                            <p>Nacido: {{ $oferta->fecha_nac }}</p>
                                            <b>Localidad: </b><span class="text-capitalize">{{ $oferta->comunidad }}</span>
                                            
                                            <h3>Descripción: </h3>
                                            <p class="card-text py-2">{{ $oferta->descripcion }}</p>

                                            <div class="w-100 d-flex  justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje</button>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Publicato hace: </small>
                                                    <p>Publicado por: {{ $autor->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- section enviar mensaje -->
                    <div hidden class="col-md-6">
                        <h3>Enviar mensaje a {{ $oferta->autor }}</h3>
                        <form action="" method="post">
                            @csrf
                            <label for="tema_mensaje">Tema</label>
                            <input type="text" name="tema_mensaje" value=" {{ $oferta->titulo }}">
                            <label for="body_mensaje">Tema</label>
                            <input type="textarea" name="body_mensaje">
                            <!-- bottones del formulario -->
                            <div class="row justify-content-center">
                                <div class="col-2">
                                    <input type="submit" name="enviar" value="Enviar mensaje" class="btn btn-danger w-100 active text-uppercase font-weight-bold">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="añadir a favoritos">Favoritos</button>
                                </div>
                                <div class="col-2">
                                    <input type="reset" name="limpiar" value="Limpiar" class="btn btn-outline-danger w-100 text-uppercase font-weight-bold">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- FIN del bloque de uno Anuncio demanda -->
                    @elseif($status=='error')
                    <div class="text-center">Disculpa, la conexion fallida, intenta más tarde...</div>
                    @else
                    <div class="text-center">Disculpa, este anuncio ya no está disponible.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

</html>