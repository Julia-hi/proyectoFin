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
    $stat = "error";
}

if ($user != null) {
    $user_name = $user->name;
    $user_id = $user->id;
    $stat='ok';
}
?>
@endauth
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
            <div class="justify-center sm:px-6 lg:px-8 ">
                <div class="d-flex flex-row justify-content-center align-items-end" style="height: 150px;">
                    <img src="{{asset('storage/images/logo.svg')}}" alt="Logo MiLorito" class="h-75 mt-3 mb-1" onclick="location.href='/'" style="cursor: pointer;">
                </div>
                <!-- Anuncio demanda -->
                <div id="demandas-block" class="mt-8 bg-yellow dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-3">

                    <div class="row d-flex justify-content-center align-content-center m-3">
                        <a type="button" class="green-brillante-boton w-50" href="{{ url()->previous() }}"><strong>VOLVER</strong></a>
                    </div>
                    <div class="row" style="min-height: 200px;">
                        @if($demanda!=null)
                        <div class="col-md-6">
                            <div class="card mb-4 p-2 h-100">
                                <h1 class="text-uppercase pb-2 h2 text-dark-green">{{ $demanda->titulo}}</h1>
                                <p class="card-text py-2">{{ $demanda->descripcion }}</p>
                                <div class="position-absolute bottom-0 left-0 w-100 mb-2 p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-row">
                                            @auth
                                            <img src="{{asset('storage/images/icons/square-phone-flip-solid.svg')}}" style="width:1.2em;" class="mr-2">
                                            <span>{{$autor->telefono}}</span>
                                            @endauth
                                        </div>
                                        <div>
                                            <small class="text-muted">Publicato: {{ $demanda->created_at->format('M j, Y') }}</small>
                                            <p>Anunciante: {{ $autor->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- section enviar mensaje -->
                        <div class="col-md-6">
                            <div class="border bg-white rounded mb-4 p-2 h-100" style="min-height: 200px;">
                                @guest
                                <p class="text-left py-2">No estas logueado, por favor, <a href="/login"><b>inicia seccion</b></a> para enviar mensaje y ver telefono del anunciante. Nosotros respetamos privacidad de los
                                    usuarios, por este motivo uso de mansajeria disponibile solo para usuarios registrados.
                                </p>
                                @endguest
                                @auth
                                @if($user->id != $autor->id && $user->rol!='admin')
                                <h3 class="p-2">Enviar mensaje a {{ $autor->name }}:</h3>
                                <form id="enviar_mens_form" method="POST" action="{{ route('user.mensajes.store',$autor->id) }}">
                                    @csrf
                                    <textarea class="border rounded border-green w-100" id="mensaje" rows="5" name="texto" placeholder="Escribe mensaje aquí..."></textarea>
                                    <x-input-error :messages="$errors->get('texto')" class="mt-2" />
                                    <input name="anuncio_id" type="hidden" value="{{ $demanda->id }}" />
                                    <input name="remitente_id" type="hidden" value="{{ Auth::user()->id }}" />
                                    <input name="recipiente_id" type="hidden" value="{{ $autor->id }}" />
                                    <div class="d-flex items-center justify-content-between m-4">
                                        <button id="submit_form_mensaje" type="submit" class=" btn btn-sm btn-outline-success text-uppercase px-4 active">Enviar</button>
                                        <button type="reset" class="btn btn-sm btn-outline-danger text-uppercase px-4">Limpiar</button>
                                    </div>
                                </form>
                                @else
                                <p class="text-center p-3">Autor del anuncio o administrador no puede enviar mensaje desde este campo.
                                </p>
                                @endif
                                @if($demanda->anuncio->estado == "blocked")
                                <button class="btn btn-sm btn-danger active" type="button" title="Anuncio bloqueado"><b>anuncio bloqueado!</b></button>
                                @endif
                                @if($user->id != $autor->id && $user->rol!='admin')
                                <button class="btn btn-danger active" type="button">Denunciar</button>
                                @endif
                                @endauth
                            </div>
                        </div>
                        @elseif($stat=='error')
                        <div class="text-center">Disculpa, la conexion fallida, intenta más tarde...</div>
                        @else
                        <div class="text-center">Disculpa, este anuncio ya no está disponible.</div>
                        @endif
                    </div>
                </div> <!-- fin demandas block -->
            </div>
        </div> <!-- fin container -->
    </div>
    <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            //evento para confirmar envio del mensaje
            $('#submit_form_mensaje').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estas seguro? Queres Enviar mensaje?',
                    text: 'Puedes ver todos mensajes en tu area privada',
                    icon: 'warning',
                    iconColor: '#FC4B3B',
                    showCancelButton: true,
                    confirmButtonColor: '#76A728',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si! enviar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // se envia la peticion si usuario ha confirmado
                        $("#enviar_mens_form").submit();
                    }
                });
            });
        });
    </script>
</body>

</html>