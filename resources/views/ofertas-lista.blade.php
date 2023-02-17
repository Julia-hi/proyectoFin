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

<body class="antialiased mt-0">
    <!-- Page Heading - resources/views/components/header.blade.php -->

    <header>
        <x-header />
    </header>


    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <div class="align-self-center" style="height:50px;">
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
        </div>
        @endif
        <div class="container">
            <div class="justify-center sm:px-6 lg:px-8">
                <div class="m-2">
                    <div class=" mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                        <!-- method="get" action="" -> para no cambiar ruta, solo añadir post parametros a ella e muestrar resultado de busquda -->
                        <form id="formulario" method="get" action="">
                            <div class="row p-3 g-6">
                                <div class="col">
                                    <div class="row border rounded h-100">
                                        <div class="col-2 p-1">
                                            <svg style="max-height: 50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm2-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21 10.986c0 4.628-4.972 8.753-7.525 10.567a2.528 2.528 0 0 1-2.95 0C7.972 19.739 3 15.613 3 10.986 3 5.576 7.03 2 12 2s9 3.576 9 8.986Zm-2 0c0 1.613-.886 3.348-2.328 5.043-1.411 1.659-3.144 3.034-4.355 3.893a.529.529 0 0 1-.634 0c-1.21-.86-2.944-2.234-4.354-3.893C5.886 14.334 5 12.599 5 10.986 5 6.748 8.065 4 12 4s7 2.748 7 6.986Z"></path>
                                            </svg>
                                        </div>
                                        <select name="comunidad" id="comunidad" class="col-10 border-0" aria-label=".form-select-lg example">
                                            <option value="todo" selected>Seleccione Región ...</option>
                                            <option value="andalucia">Andalucía</option>
                                            <option value="aragon">Aragón</option>
                                            <option value="asturias">Asturias</option>
                                            <option value="canarias">Canarias</option>
                                            <option value="cantabria">Cantabria</option>
                                            <option value="castilla-la-mancha">Castilla La Mancha</option>
                                            <option value="castila-leon">Castilla León</option>
                                            <option value="catalunya">Catalunya</option>
                                            <option value="ceuta-y-melilla">Ceuta y Melilla</option>
                                            <option value="extremadura">Extremadura</option>
                                            <option value="galicia">Galicia</option>
                                            <option value="islas-baleares">Islas Baleares</option>
                                            <option value="rioja">La Rioja</option>
                                            <option value="madrid">Madrid</option>
                                            <option value="murcia">Murcia</option>
                                            <option value="navarra">Navarra</option>
                                            <option value="pais-vasco">País Vasco</option>
                                            <option value="valencia">Valencia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row border rounded h-100">
                                        <select name="provincia" id="provincia" class="border-0" aria-label=".form-select-lg example">
                                            <option value="todo" selected>Seleccione provincia ...</option>
                                            <!-- opciones insertarán desde script of-lista.js -->
                                        </select>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row border rounded h-100">
                                        <select name="poblacion" id="poblacion" class="border-0" aria-label=".form-select-lg example">
                                            <option value="todo" selected>Seleccione población ...</option>
                                            <!-- opciones insertarán desde script of-lista.js -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <select name="raza" id="raza" class="border rounded h-100 w-100 p-2">
                                        <option value="todos">Todas razas</option>
                                        <option value="agapornis">agapornis</option>
                                        <option value="ara">ara</option>
                                        <option value="amazona">amazona</option>
                                        <option value="cocatúa">cocatúa</option>
                                        <option value="ninfa">ninfa</option>
                                        <option value="periquito">periquito</option>
                                        <option value="yaco">yaco</option>
                                        <option value="otros">otros</option>
                                    </select>
                                </div>
                                <div class="col ">
                                    <select name="sexo" id="sexo" class="border rounded h-100 w-100 p-2">
                                        <option value="todos" checked>Genero no importa</option>
                                        <option value="macho">macho</option>
                                        <option value="embra">embra</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" class="p-3 rounded border w-100">BUSCAR</button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
                <!--   Block para anuncios de ofertas   -->
                <div class="mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <?php
                    if (isset($_GET['comunidad']) && $_GET['comunidad'] != "todo") {
                        $comunidad = $_GET['comunidad'];
                    } else {
                        $comunidad = " toda España <br>";
                    } ?>
                    <h2 class="p-2 my-4 text-center">Ofertas en <span class="text-capitalize"><?php echo $comunidad; ?></span>

                    </h2>
                    <?php
                    if ($ofertas == "ofertas not found") { ?>
                        <div class="text-center">
                            <p>Lo sentimos, este momento no hemos encontrado ofertas en <span class="text-capitalize"><?php echo $comunidad ?></span></p>
                            <p>Consulta ofertas sin filtros (para toda España) o intenta más tarde.</p>
                            <div class="row d-flex justify-content-center align-content-center m-3">
                                <a type="button" class="btn btn-sm btn-outline-secondary col-3" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Volver</a>
                            </div>
                        </div>
                    <?php } else {

                    ?>
                        <div class="btn-group row w-50 mb-3">
                            <a href="#" class="btn btn-sm btn-outline-secondary col-3" active>Lista</a>
                            <a href="#" class="btn btn-sm btn-outline-secondary col-3">Ver en mapa</a>
                        </div>
                        <div>
                            <div class="row">
                                @if( $ofertas!=null && $ofertas->count()>0)
                                @foreach ($ofertas as $oferta)
                                <div class="col-md-4">
                                    <div class="card mb-4" style="height: 500px;">
                                        <div class="card-body">
                                            <?php $fotos = $oferta->fotos; ?>
                                            @foreach($fotos as $foto)
                                            <div style="height: 70%;"> <?php //echo Storage::url('usersImages/29-1-foto0.jpg'); 
                                                                        ?>
                                                <img class="card-img-top" src="<?php echo ($foto->enlace); ?>" alt="" style="height: 300px; width: 100%; display: block; object-fit: cover" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1859bebb3c0%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1859bebb3c0%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.71249771118164%22%20y%3D%22120.18000011444092%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
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
                                                        <button type="button" class="btn btn-sm btn-outline-secondary">Ver</button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary">Enviar mensaje</button>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted">Publicato hace: </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @elseif($status=='error')
                                <h4 class="text-center">Disculpa, la conexion fallida, intenta más tarde...</h4>
                                @else
                                <h4 class="text-center">Disculpa, no hemos encontrado anuncios...</h4>
                                @endif
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('storage/js/of-lista.js')}}"></script>
</body>

</html>