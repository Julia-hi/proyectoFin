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
    <style>
        #draggable {
            position: absolute;
            top: 30%;
            left: 40%;
            background-color: white;
            z-index: 3;
            max-width: 80%;
            padding: 20px;
            cursor: move;
        }
    </style>

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
            @auth
            <div id="draggable" class="w-25 rounded border shadow">
                <h3 class="p-2">Vas a enviar mensaje a {{ $autor->name }}</h3>
                <form method="POST" action="{{ route('user.mensajes.store',$autor->id) }}">
                    @csrf
                    <textarea class="form-control" id="mensaje" rows="10" name="texto" placeholder="Escribe qualcosa aquí..."></textarea>
                    <x-input-error :messages="$errors->get('texto')" class="mt-2" />
                    <input hidden name="anuncio_id" type="text" value="{{ $oferta->id }}" />
                    <input hidden name="user_id" type="text" value="{{ Auth::user()->id }}" />
                    <div class="d-flex items-center justify-content-between my-4">
                        <x-primary-button class="ml-3">
                            {{ __('Enviar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            @endauth
            @guest
            <div id="draggable" class="w-25 rounded border shadow">
                <a type="button" href="/login">Identificate</a>
            </div>

            @endguest
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
                                                    <div>
                                                        <img class="rounded w-100" src="<?php echo $fotos->first()->enlace; ?>" alt="" style="max-height:450px; object-fit: cover;" data-holder-rendered="true">
                                                    </div>
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
                                            <h1 class="text-uppercase pb-2">{{ $oferta->titulo }}</h1>
                                            <h2>Raza: <span class="text-capitalize">{{ $oferta->raza }}</span></h2>
                                            <h2>Genero: <span class="text-capitalize">{{ $oferta->genero }}</span></h2>
                                            <h2>Nacido: <span class="text-capitalize">{{ $oferta->fecha_nac }}</span></h2>
                                            <h2>Localidad: <span class="text-capitalize">{{ $oferta->comunidad }}</span></h2>
                                            <div class="mt-3 h-50">
                                                <h2 class="mb-1">Descripción: </h2>
                                                <p class="card-text my-1">{{ $oferta->descripcion }}</p>
                                            </div>
                                            <div class="w-100 d-flex justify-content-between align-items-center">
                                                <div class="">
                                                    <button id="crearMensaje" type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje a {{ $autor->name }}</button>
                                                </div>
                                                <div class="align-self-baseline">
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
    <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            // showFormulario();
            // showDiv();
            var draggable = document.getElementById('draggable');
            var isDragging = false;
            var dragX, dragY;

            draggable.addEventListener('mousedown', function(e) {
                isDragging = true;
                dragX = e.clientX - draggable.offsetLeft;
                dragY = e.clientY - draggable.offsetTop;
            });

            document.addEventListener('mousemove', function(e) {
                if (isDragging) {
                    draggable.style.left = (e.clientX - dragX) + 'px';
                    draggable.style.top = (e.clientY - dragY) + 'px';
                }
            });

            document.addEventListener('mouseup', function() {
                isDragging = false;
            });

        });

        function showDiv() {
            var button = document.getElementById('crearMensaje');
            button.addEventListener('click', function() {
                // Create a new div element
                var newDiv = document.createElement('div');

                // Set some properties for the new div element
                newDiv.innerHTML = 'This is a dynamically created div.';
                newDiv.style.backgroundColor = 'blue';
                newDiv.style.width = '100px';
                newDiv.style.height = '100px';
                newDiv.style.color = 'white';
                newDiv.style.padding = '20px';
                newDiv.style.margin = '10px';

                // Append the new div element to the document body
                document.body.appendChild(newDiv);
            });
        }

        function showFormulario() {

            document.getElementById('crearMensaje').addEventListener('click', function() {
                // Open a new window with the form
                var messageWindow = window.open('', 'messageWindow', 'width=400,height=400');

                // Create the form elements
                var form = messageWindow.document.createElement('form');
                var label = messageWindow.document.createElement('label');
                var input = messageWindow.document.createElement('input');
                var submit = messageWindow.document.createElement('input');

                // Set attributes for the form elements
                form.setAttribute('method', 'post');
                form.setAttribute('action', 'submit-form.php');
                label.innerHTML = 'Message:';
                input.setAttribute('type', 'text');
                input.setAttribute('name', 'message');
                submit.setAttribute('type', 'submit');
                submit.setAttribute('value', 'Send');

                // Add the form elements to the form and the form to the window
                form.appendChild(label);
                form.appendChild(input);
                form.appendChild(submit);
                messageWindow.document.body.appendChild(form);
            })
        }
    </script>
</body>

</html>