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

if (Auth::user()) {
    $user = Auth::user();
    $stat = "ok";
} else {
    $user = null;
    $stat = "error";
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
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    @if($stat =="ok")
    <div class="hojas relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 py-4 sm:pt-0 ">

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
                    @if(Auth::user()->rol=='user')
                    @include('layouts.navigation-welcome')
                    @elseif(Auth::user()->rol=='admin')
                    @include('layouts.navigation-welcome-admin')
                    @endif
                </div>
            </div>
            @endauth
            @guest
            <a href="{{ route('login') }}" class="bg-light rounded p-2 text-sm text-gray-700 dark:text-gray-500 underline">Iniciar sesión</a>

            <a href="{{ route('register') }}" class="bg-light rounded p-2 ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Crear cuenta</a>
            @endguest

        </div>

        <div id="draggable" class="col-sm-10 col-lg-6 rounded border shadow hidden">
            <div class="">
                <h3 class="p-2">Vas a enviar mensaje a {{ $autor->name }}</h3>
                @auth
                <form id="enviar_mens_form" method="POST" action="{{ route('user.mensajes.store',$autor->id) }}" class="w-100">
                    @csrf
                    <textarea class="border border-green rounded w-100" id="mensaje" rows="10" name="texto" placeholder="Escribe mensaje aquí..." class="w-100"></textarea>
                    <x-input-error :messages="$errors->get('texto')" class="mt-2" />
                    <input name="anuncio_id" type="hidden" value="{{ $oferta->id }}" />
                    <input name="remitente_id" type="hidden" value="{{ Auth::user()->id }}" />
                    <input name="recipiente_id" type="hidden" value="{{ $autor->id }}" />
                    <div class="d-flex items-center justify-content-between my-4">
                        <x-primary-button class="ml-3" id="enviar_mensaje">
                            {{ __('Enviar') }}
                        </x-primary-button>
                        <button id="cerrar_dragable" type="button" class="cerrar_dragable btn">Cerrar</button>
                    </div>
                </form>
                @endauth
            </div>
        </div>
        <div class="container">

            <div class="justify-center sm:px-6 lg:px-8 h-auto">
                <div class="d-flex flex-row justify-content-center align-items-end" style="height:20vh; max-height: 150px;">
                    <img src="{{asset('storage/images/logo.svg')}}" alt="Logo MiLorito" class="h-75 mt-3 mb-1" onclick="location.href='/'" style="cursor: pointer;">
                </div>
                <div class="m-2 h-auto ">
                    <!-- Anuncio oferta -->
                    <div id="" class="mt-8 bg-yellow dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-3">
                        <div class="row d-flex justify-content-center align-content-center m-3 ">
                            <a type="button" class="green-brillante-boton w-50" href="{{ url()->previous() }}"><strong>VOLVER</strong></a>
                        </div>
                        <div class="row h-auto">
                            @if($oferta!=null)
                            <div class="border rounded bg-white" style="min-height: 500px;">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        @if($fotos->count()<=1) <div class="col-md-6 col-sm-12 md:px-5 sm:px-1">
                                            <div class="h-100 p-2">
                                                <img src="<?php echo $fotos->first()->enlace; ?>" alt="" style="max-height:450px; width:auto; min-width:400px; object-fit: cover;" data-holder-rendered="true">
                                            </div>
                                    </div>
                                    @else
                                    <div class="col-lg-6 col-xs-12 lg:px-5 xs:px-1 py-2">
                                        <?php $fotos = $oferta->fotos; ?>
                                        <div id="carouselControl" class="carousel slide position-relative" data-ride="carousel">
                                            <div class="carousel-inner carousel-inner0">
                                                @foreach($fotos as $foto)
                                                <div class="carousel-item active p-3 text-center">
                                                    <img class="d-block w-100" style="height: 500px; width: auto; display: block; object-fit: cover" src="<?php echo ($foto->enlace); ?>" alt="First slide">
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
                                    <div class="col-lg-6 col-xs-12 lg:px-5 xs:px-1 py-2 max-h-100">
                                        <div class="d-flex flex-column w-100 justify-content-between h-100">
                                            <div>
                                                <div class="d-flex flex-row justify-content-between">
                                                    <h1 class="text-uppercase pb-2 h2 text-dark-green">{{ $oferta->titulo }}</h1>
                                                    @auth
                                                    @if($user->id != $autor->id && $user->rol!='admin')
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
                                                    @if($oferta->anuncio->estado == "blocked")
                                                    <button class="btn btn-sm btn-danger active" type="button" title="Anuncio bloqueado"><b>anuncio bloqueado!</b></button>
                                                    @endif
                                                    @endauth
                                                    @guest
                                                    <a href="{{ route('login') }}" class="btn "><img title="Guardar como favorito" src="{{asset('storage/images/icons/heart-regular.svg')}}" style="width:1.5em;" class="m-2"></a>
                                                    @endguest
                                                </div>
                                                <h2 class="py-1"><b>Raza</b>: <span class="text-capitalize">{{ $oferta->raza }}</span></h2>
                                                <h2 class="py-1"><b>Genero</b>: <span class="text-capitalize">{{ $oferta->genero }}</span></h2>
                                                <h2 class="py-1"><b>Nacido</b>: <span class="text-capitalize">{{ $oferta->fecha_nac }}</span></h2>
                                                <h2 class="py-1"><b>Localidad</b>: <span class="text-capitalize">{{$oferta->poblacion}}, {{$oferta->provincia}}({{ $oferta->comunidad }})</span></h2>
                                            </div>
                                            <div class="mt-1 min-h-50">
                                                <b class="pb-1">Descripción: </b>
                                                <p class="my-1">{{ $oferta->descripcion }}</p>
                                            </div>
                                            <div>
                                                <div class="w-100 d-flex flex-row justify-content-between align-items-center">
                                                    @guest
                                                    <p class="text-left py-2">No estas logueado, por favor, <a href="/login"><b>inicia seccion</b></a> para enviar mensaje y ver telefono del anunciante. Nosotros respetamos privacidad de los
                                                        usuarios, por este motivo uso de mansajeria disponibile solo para usuarios registrados.
                                                    </p>
                                                    @endguest
                                                    @auth
                                                    @if($autor->id!= Auth::user()->id && Auth::user()->rol !='admin')
                                                    <button id="crearMensaje" type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje a {{ $autor->name }}</button>
                                                    @endif
                                                    <div class="d-flex flex-row"><img src="{{asset('storage/images/icons/square-phone-flip-solid.svg')}}" style="width:1.2em;" class="mr-2">
                                                        <span>{{$autor->telefono}}</span>
                                                    </div>
                                                    @if($user->id != $autor->id && $user->rol!='admin')
                                                    <button class="btn btn-danger active" type="button">Denunciar</button>
                                                    @endif
                                                    @endauth

                                                </div>
                                                <div class="align-self-baseline ">
                                                    <small class="text-muted">Publicato: {{ $oferta->created_at->format('M j, Y') }}</small>
                                                    <p><b>Anunciante</b>: {{ $autor->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN del bloque de uno Anuncio demanda -->
    @elseif($stat=='error')
    <div class="text-center">Disculpa, la conexion fallida, intenta más tarde...</div>
    @else
    <div class="text-center">Disculpa, este anuncio ya no está disponible.</div>
    @endif

    <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('storage/js/anuncio-oferta.js')}}"></script>
    <script src="{{asset('storage/js/slider.js')}}"></script>
    <script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            //evento para confirmar envio del mensaje
            $('#enviar_mensaje').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estas seguro? Queres Enviar mensaje?',
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