<?php $user_id = Auth::user()->id; ?>
@auth
@if(Auth::user()->rol=="admin")
<!--  <a class="nav-link" href="{{ url('/home') }}">Panel de admin</a> -->
<?php echo "I am admin";
//  return redirect()->route('admin/dashboard');
?>
@else

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publicar anuncio') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="justify-center sm:px-6 lg:px-8">
            <div class="m-2 ">
                <div class="mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">Publicar anuncio</h2>
                    <div class="justify-center">
                        <div class="align-items-center d-flex justify-content-center p-3">
                            <div class="btn-group border d-flex justify-content-center">
                                <button type="button" class="btn btn-sm btn-outline-secondary active" id="ofertas">VENDER LORO</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="demandas">COMPRAR LORO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-2">
                <!-- Anuncios oferta -->
                <div id="ofertas-block" class="mt-8 p-3 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg ">
                    <h3 class="text-center">FORMULARIO PARA VENDER</h3>
                    <form method="post" enctype="multipart/form-data" action="{{route('user.anuncios.store',$user_id)}}" id="create-oferta">
                        @csrf
                        <div class="row">
                            <div class="col-8">
                                <!-- titulo del anuncio -->
                                <div class="py-2">
                                    <label for="titulo" class="form-label">Titulo del anuncio</label>
                                    <input type="text" class="border rounded h-100 w-100 p-2" id="titulo" name="titulo">
                                </div>
                                <div class="py-2">
                                    <!-- Descripcion -->
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" rows="10" name="descripcion"></textarea>
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
                        <input hidden type="text" class="border rounded h-100 w-100 p-2" id="tipo_anuncio" name="tipo_anuncio" value="oferta">
                        <input hidden type="text" class="border rounded h-100 w-100 p-2" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
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


                <!-- Anuncios DEMANDA -->
                <div id="demandas-block" class="mt-8 p-3 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg d-none">
                    <h3 class="text-center">FORMULARIO PARA COMPRAR</h3>
                    <form method="post" enctype="multipart/form-data" action="{{route('user.anuncios.store', $user_id)}}" id="create-demanda">
                        @csrf
                        <div class="row">
                            <div class="col-8">
                                <!-- titulo del anuncio -->
                                <div class="py-2">
                                    <label for="titulo" class="form-label">Titulo del anuncio</label>
                                    <input type="text" class="border rounded h-100 w-100 p-2" id="titulo" name="titulo">
                                </div>
                                <div class="py-2">
                                    <!-- Descripcion -->
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" rows="10" name="descripcion"></textarea>
                                </div>

                            </div>

                        </div>
                        <input hidden type="text" class="border rounded h-100 w-100 p-2" id="tipo_anuncio" name="tipo_anuncio" value="demanda">
                        <input hidden type="text" class="border rounded h-100 w-100 p-2" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
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
            </div>

            <!--  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Publicar anuncio') }}
                    </h2>
                    <div class="pt-3">
                        
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</x-app-layout>
<script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('storage/js/of-lista.js')}}"></script>
<script src="{{asset('storage/js/welcome.js')}}"></script>
<script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
@endif
@endauth