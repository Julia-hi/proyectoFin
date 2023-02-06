<?php

use App\Models\Calendar;
use Illuminate\Support\Facades\Storage;

$calendarStyle = Storage::url('calendar.css');
?>

<x-app-layout>
    @push('styles')
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    @endpush

    <div class="container pt-3">
        <div class="mt-4 mb-4 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <h2 class='p-2 my-2 text-center text-uppercase font-weight-bold'>Crear nuevo anuncio</h2>
            @auth
            <?php $id_ususario = Auth::id(); ?>
            <div class="row justify-content-center">
                <div class="btn-group d-flex justify-content-center w-50">
                    <button type="button" class="btn btn-sm btn-outline-secondary active" id="ofertas">PUBLICAR OFERTA</button>
                    <button type="button" type="button" class="btn btn-sm btn-outline-secondary" id="demandas">PUBLICAR DEMANDA</button>
                </div>
            </div>

            <div class="container">
                <!--   BLOQUE PARA CREAR ANUNCIO OFERTA  -->
                <div id="ofertas-block" class="justify-content-center p-3 w-100">
                    <form method="post" enctype="multipart/form-data" action="{{route('anuncio.create')}}" id="create-anuncio">
                        <div class="row">
                            <div class="col-8">
                                <!-- titulo del anuncio -->
                                <div class="py-2">
                                    <label for="titulo" class="form-label">Titulo del anuncio</label>
                                    <input type="text" class="border rounded h-100 w-100 p-2" id="titulo" name="titulo">
                                </div>
                                <div class="py-2">
                                    <!-- Descripcion -->
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="description" rows="10" name="description"></textarea>
                                </div>
                                <div class="py-2">
                                    <!-- Localidad -->
                                    <h2>Localidad</h2>
                                    <p>Por favor, eliga localidad, es requerida para mejorar busqueda.</p>
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
                                            <!-- Latitud y longitud de pueblo elegido -->
                                            <input hidden type="text" id="lat-pueblo" name="lat-pueblo" value="">
                                            <input hidden type="text" id="lon-pueblo" name="lat-pueblo" value="">
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-4">
                                <!-- elegir raza -->
                                <div class="py-2">
                                    <select name="raza" id="raza" class="border rounded h-100 w-100 p-2">
                                        <option value="todos">Elegir raza</option>
                                        <option value="agapornis">Agapornis</option>
                                        <option value="ara">Ara</option>
                                        <option value="amazona">Amazona</option>
                                        <option value="cocatúa">Cocatúa</option>
                                        <option value="ninfa">Ninfa</option>
                                        <option value="periquito">Periquito</option>
                                        <option value="yaco">Yaco</option>
                                        <option value="otros">Otros</option>
                                    </select>
                                </div>
                                <!-- Elegir genero -->
                                <div class="py-2">
                                    <select name="genero" id="genero" class="border rounded h-100 w-100 p-2">
                                        <option value="none" checked>Genero indefinido</option>
                                        <option value="macho">macho</option>
                                        <option value="embra">embra</option>
                                    </select>
                                </div>
                                <!--Elegir fecha de nacimiento -->
                                <div class="py-2">
                                    <label for="fecha-nac" class="form-label">Fecha de nacimiento</label>
                                    <input type="date" class="form-control border rounded h-100 w-100 p-2" id="fecha-nac" name="fecha-nac">
                                </div>

                                <!-- Campo de Fotos -->
                                <div class="py-2">
                                    <p>Cargar fotos (minimo una, maximo 5)</p>
                                    <div class="form-control">
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto1" name="foto1">
                                        </div>
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto2" name="foto2">
                                        </div>
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto3" name="foto3">
                                        </div>
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto3" name="foto3">
                                        </div>
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto3" name="foto3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <input hidden type="text" class="border rounded h-100 w-100 p-2" id="tipo-anuncio" name="tipo-anuncio" value="oferta">
                        <input hidden type="text" class="border rounded h-100 w-100 p-2" id="id_usuario" name="id_usuario" value="<?php echo $id_ususario; ?>">
                        <!-- bottones del formulario -->
                        <div class="row justify-content-center">
                            <div class="col-2">
                                <input type="submit" name="enviar" value="Crear anuncio" class="btn btn-danger w-100 active text-uppercase font-weight-bold">
                            </div>
                            <div class="col-2">
                                <input type="reset" name="limpiar" value="Limpiar" class="btn btn-outline-danger w-100 text-uppercase font-weight-bold">
                            </div>
                        </div>
                    </form>
                </div>
                <!--   BLOQUE PARA FORMULARIO ANUNCIOS DEMANDA  -->
                <div id="demandas-block" class="mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg d-none">
                    <form method="post" enctype="multipart/form-data" action="{{ route('anuncio.create') }}" id="create-anuncio">
                        <div class="">
                            <!-- titulo del anuncio  -->
                            <div class="py-2">
                                <label for="titulo" class="form-label">Titulo del anuncio</label>
                                <input type="text" class="border rounded h-100 w-100 p-2" id="titulo" name="titulo">

                            </div>
                            <div class="py-2">
                                <!-- Descripcion -->
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" rows="10" name="description"></textarea>
                            </div>

                            <input hidden type="text" class="border rounded h-100 w-100 p-2" id="tipo-anuncio" name="tipo-anuncio" value="demanda">
                            <input hidden type="text" class="border rounded h-100 w-100 p-2" id="id_usuario" name="id_usuario" value="<?php echo $id_ususario; ?>">
                            <!-- bottones del formulario -->
                            <div class="row justify-content-center">
                                <div class="col-2">
                                    <input id="submit-button" type="submit" name="enviar" value="Crear anuncio" class="btn btn-danger w-100 active text-uppercase font-weight-bold">
                                </div>
                                <div class="col-2">
                                    <input type="reset" name="limpiar" value="Limpiar" class="btn btn-outline-danger w-100 text-uppercase font-weight-bold">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endauth

                @guest
                <p class="text-white">bienvenidos, guest! No estas logeado...</p>
                <button class="border rounded p=2">Registrar</button>
                <button>Iniciar sesión</button>
                @endguest
            </div>

        </div>

</x-app-layout>
<script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('storage/js/of-lista.js')}}"></script>
<script src="{{asset('storage/js/welcome.js')}}"></script>
<script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>

<!-- <script src="{{asset('storage/js/confirmar-formulario.js')}}"></script> -->