<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@auth
<?php
try {
    $user_id = session()->get('user_id');
    $user = User::find($user_id);
    $stat = "ok";
} catch (Exception $ex) {
    $user = null;
    $stat = "error";
}

if ($user != null) {
    $user_name = $user->name;
    $user_id = $user->id;
}
?>
@endauth

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    <title>MiLorito</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('storage/css/mi_estilo.css') }}">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased mt-0">
    <!-- Page Heading - resources/views/components/header.blade.php -->
    <header>
        <x-header />
    </header>
    <div class="flex items-top justify-center min-h-screen bg-white dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
       
        <div class="hidden fixed top-0 px-6 py-4 sm:block " style="right:60px;">
            <div class="align-self-center">
                @guest
                <a type="button" class="nav-botton red-brillante-boton mr-2 text-center" href="{{ url('/login')}}" tabindex="0" style="z-index:10;"><span>Publicar anuncio</span></a>
                @endguest
                @auth
                <div class="col m-0">
                    <a type="button" class="nav-botton h-100 red-brillante-boton mr-2 p-2 text-center" href="/user/{{Auth::user()->id}}/anuncios-oferta/create" tabindex="0" style="z-index:10;"><span>Publicar anuncio</span></a>
                </div>
                @else
                <a href="{{ route('login') }}" class="bg-light rounded p-2 text-sm text-gray-700 dark:text-gray-500 underline">Iniciar sesión</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="bg-light rounded p-2 ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Crear cuenta</a>
                @endif
                @endauth
            </div>
        </div>
       
        <div class="container">
            <div class="justify-center xs:px-1 sm:px-6 lg:px-8">
                <div>
                    <div class="p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg position-sticky" style="top:5px; z-index:5;">
                        <!-- method="get" action="" -> para no cambiar ruta, solo añadir post parametros a ella e muestrar resultado de busquda -->
                        <form id="filter_form" method="get" action="{{ route('filter.index') }}" class="">
                            <div class="row p-3 g-3">
                                <div class="col-xs-12 col-lg-2" style="height:40px;">
                                    <div class="row h-100 border rounded-left border-success w-100 m-0">
                                        <div class="col-2 p-1 bg-white rounded-left">
                                            <svg style="height: 30px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" fill="red" clip-rule="evenodd" d="M12 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm2-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"></path>
                                                <path fill-rule="evenodd" fill="red" clip-rule="evenodd" d="M21 10.986c0 4.628-4.972 8.753-7.525 10.567a2.528 2.528 0 0 1-2.95 0C7.972 19.739 3 15.613 3 10.986 3 5.576 7.03 2 12 2s9 3.576 9 8.986Zm-2 0c0 1.613-.886 3.348-2.328 5.043-1.411 1.659-3.144 3.034-4.355 3.893a.529.529 0 0 1-.634 0c-1.21-.86-2.944-2.234-4.354-3.893C5.886 14.334 5 12.599 5 10.986 5 6.748 8.065 4 12 4s7 2.748 7 6.986Z"></path>
                                            </svg>
                                        </div>
                                        <select name="comunidad" id="comunidad" class="col-10 border-0 h-100" aria-label=".form-select-lg example" style="height:40px;">
                                            <option value="todo" selected>Seleccione Región ...</option>
                                            <option value="andalucia">Andalucía</option>
                                            <option value="aragon">Aragón</option>
                                            <option value="asturias">Asturias</option>
                                            <option value="canarias">Canarias</option>
                                            <option value="cantabria">Cantabria</option>
                                            <option value="castilla-la mancha">Castilla La Mancha</option>
                                            <option value="castilla-leon">Castilla León</option>
                                            <option value="cataluña">Cataluña</option>
                                            <option value="ceuta">Ceuta</option>
                                            <option value="extremadura">Extremadura</option>
                                            <option value="galicia">Galicia</option>
                                            <option value="baleares">Islas Baleares</option>
                                            <option value="rioja">La Rioja</option>
                                            <option value="madrid">Madrid</option>
                                            <option value="melilla">Melilla</option>
                                            <option value="murcia">Murcia</option>
                                            <option value="navarra">Navarra</option>
                                            <option value="pais vasco">País Vasco</option>
                                            <option value="valencia">Valencia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-2">
                                    <div class="row border border-success h-100 w-100 m-0">
                                        <select name="provincia" id="provincia" class="border-0" aria-label=".form-select-lg example">
                                            <option value="todo">Seleccione provincia ...</option>
                                            <!-- opciones insertarán desde script of-lista.js -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-2">
                                    <div class="row h-100 w-100 m-0">
                                        <select name="poblacion" id="poblacion" class="border border-success rounded-right" aria-label=".form-select-lg example" style="height:40px;">
                                            <option value="todo">Seleccione población ...</option>
                                            <!-- opciones insertarán desde script of-lista.js -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-2">
                                    <select name="raza" id="raza" class="border border-success rounded h-100 w-100 p-2 " style="height:40px;">
                                        <option value="todo">Todas razas</option>
                                        <option value="agapornis">agapornis</option>
                                        <option value="ara">ara</option>
                                        <option value="amazona">amazona</option>
                                        <option value="cacatúa">cacatúa</option>
                                        <option value="ninfa">ninfa</option>
                                        <option value="periquito">periquito</option>
                                        <option value="yaco">yaco</option>
                                        <option value="otros">otros</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-lg-2">
                                    <select name="genero" id="genero" class="border border-success rounded h-100 w-100 p-2">
                                        <option value="todo">Genero no importa</option>
                                        <option value="macho">macho</option>
                                        <option value="embra">embra</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-lg-2">
                                    <button id="buscar-botton" type="submit" class="green-brillante-boton active text-uppercase h-100 w-100"><strong>BUSCAR</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--   Block para anuncios de ofertas   -->
                    <div class="position-relative p-2 bg-yellow dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg " style="min-height:500px;">
                        @auth
                        <div class="row w-100 justify-content-end">
                            <div class="col-lg-2 col-xs-6 m-0">
                                @if($user!=null && $user->rol=='user')
                                @include('layouts.navigation-welcome')
                                @elseif($user!=null && $user->rol=='admin')
                                @include('layouts.navigation-welcome-admin')
                                @endif
                            </div>
                        </div>
                        @endauth
                        <!-- method="get" action="" -> para no cambiar ruta, solo añadir post parametros a ella e muestrar resultado de busquda -->

                        <?php
                        if (isset($_GET['comunidad']) && $_GET['comunidad'] != "todo") {
                            $comunidad = $_GET['comunidad'];
                        } else {
                            $comunidad = " toda España <br>";
                        } ?>
                        <h2 class="p-2 my-1 text-center h3 text-uppercase">Loritos en <span><?php echo $comunidad; ?></span></h2>
                        @if($ofertas == "ofertas not found")
                        <div class="text-center">
                            <p>Lo sentimos, este momento no hemos encontrado ofertas en <span class="text-capitalize"><?php echo $comunidad ?></span></p>
                            <p>Consulta ofertas sin filtros (para toda España) o intenta más tarde.</p>
                            <div class="row d-flex justify-content-center align-content-center m-3">
                                <a type="button" class="btn btn-sm btn-outline-secondary col-3" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Volver</a>
                            </div>
                        </div>
                        @else
                        <div>
                            <div class="row">
                                @if( $ofertas!=null && $ofertas->count()>0)
                                <div class="align-items-center d-flex justify-content-center p-3">
                                    <div class="btn-group row w-50 mb-3">
                                        <a id="linkFilter" class="btn btn-sm btn-outline-success active col-3"><strong>Lista</strong></a>
                                        <a id="mapaFilter" class="btn btn-sm btn-outline-success col-3"><strong>Ver en mapa</strong></a>
                                    </div>
                                </div>
                                @foreach ($ofertas as $ind=>$oferta)
                                <div class="col-sm col-lg-4 col-md-6">
                                    <div class="card mb-4" style="height: 500px;">
                                        <div class="card-body">
                                            <?php $fotos = $oferta->fotos; ?>
                                            <div id="carouselControl{{$oferta->id}}" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner carousel-inner{{$ind}}">
                                                    @foreach($fotos as $foto)
                                                    <div class="carousel-item active">
                                                        <img class="d-block w-100" style="height: 300px; width: 100%; display: block; object-fit: cover" src="<?php echo ($foto->enlace); ?>" alt="First slide">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <a id="prev" class="carousel-control-prev" href="#carouselControl{{$oferta->id}}" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previo</span>
                                                </a>
                                                <a id="next" class="carousel-control-next" href="#carouselControl{{$oferta->id}}" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Siguiente</span>
                                                </a>
                                            </div>

                                            <div class="" style="height: 30%;">
                                                <h3 class="text-uppercase py-2 h4">{{ $oferta->titulo}}</h3>
                                                <div class="descripcion d-flex align-items-stretch" style="line-height:1.2em; max-height: 3.6em; overflow: hidden;">
                                                    <p class="card-text text-capitalise">{{ $oferta->descripcion }}</p>
                                                </div>
                                            </div>
                                            <div class="position-absolute bottom-0 left-0 w-100 p-2">
                                                <div class="d-flex flex-row justify-content-between align-items-center">
                                                    <div class="flex">
                                                        <!-- botones -->
                                                        <div class="btn-group" style="height:30px;">
                                                            <?php $url = '/ofertas/' . $oferta->id; ?>
                                                            <a href="<?php echo $url; ?>" class="btn btn-sm btn-outline-success">
                                                                <span class="text-center">Detalles</span>
                                                            </a>
                                                        </div>
                                                        @auth

                                                        @if($oferta->autor->id!=Auth::user()->id)
                                                        <!-- si anuncio ya añadido a favoritos mostra botón para eliminar de favoritos, 
                                                        si no es favorito - mostra borón para añadir a favoritos -->
                                                        @if(!$oferta->anuncio->esFavorito(Auth::user(), $oferta->anuncio))
                                                        <form method="POST" action="{{ route('user.favoritos.store',['user' => Auth::user()->id]) }}">
                                                            @csrf
                                                            <input type="hidden" name="anuncio_id" value="{{ $oferta->id }}">
                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                            <button type="submit" data-title="Guardar como favorito"><img src="{{asset('storage/images/icons/heart-regular.svg')}}" style="width:1.5em;" class="mx-2"></button>
                                                        </form>
                                                        @else
                                                        <?php $favorito = $oferta->favoritos->first(); ?>
                                                        <!-- formulario para Eeiminar favorito de la lista -->
                                                        <form method="POST" action="{{ route('user.favoritos.destroy', [Auth::user(), $favorito]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"><img data-title="Eliminar de favoritos" src="{{asset('storage/images/icons/heart-solid.svg')}}" style="width:1.5em;" class="mx-2"></button>
                                                        </form>
                                                        @endif
                                                        @endif
                                                        @endauth
                                                        @guest
                                                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary"><img title="Guardar como favorito" src="{{asset('storage/images/icons/heart-regular.svg')}}" style="width:1.5em;" class="mx-2"></a>
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
                                @elseif($stat=='error')
                                <h4 class="text-center">Disculpa, la conexion fallida, intenta más tarde...</h4>
                                @else
                                <!-- Este mensaje muestra cuando conexion con hay anuncios de oferta en la base de datos -->
                                <h4 class="text-center">Disculpa, no hemos encontrado anuncios con estés parámetros pero...<br>
                                    ¡seguro que alguno pequeño pajarito te esta esperando. <br>Cambia parametros de busqueda para encontrarlo!</h4>
                                <div class="w-100 d-flex justify-content-center mt-4"> <img class="w-25" src="{{asset('storage/images/periquitos.png')}}" alt=""></div>
                                @endif
                            </div>
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
    <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('storage/js/of-lista.js')}}"></script>
    <script src="{{asset('storage/js/slider.js')}}"></script>
</body>

</html>