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

                                <a href="#" title="publicar oferta" class="btn btn-sm btn-outline-secondary text-uppercase active" id="ofertas">buscar nuevo dueño</a>
                                <a href="{{route('user.anuncios-demanda.create', $user_id)}}" title="publicar demanda" class="btn btn-sm btn-outline-secondary text-uppercase" id="demandas">buscar LORO</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-2">
                <!-- Anuncios oferta -->
                <div id="ofertas-block" class="mt-8 p-3 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg ">
                    <h3 class="text-center p-2">Formulario para publicar anuncio si queres VENDER / REGALAR / INTERCAMBIAR tu loro</h3>
                    <p>Importante: uno anuncio para uno lorito. Si tienes más loros - publica varios anuncios.</p>
                    <form method="post" enctype="multipart/form-data" action="{{route('user.anuncios-oferta.store',$user_id)}}" id="create_oferta">
                        @csrf
                        <div class="row">
                            <div class="col-8">
                                <!-- titulo del anuncio -->
                                <div class="py-2">
                                    <label for="titulo" class="form-label">Titulo del anuncio</label>
                                    <input type="text" class="border rounded h-100 w-100 p-2" id="titulo" name="titulo">
                                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                                </div>
                                <div class="py-2">
                                    <!-- Descripcion -->
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" rows="10" name="descripcion"></textarea>
                                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                                </div>
                                <div class="py-2">
                                    <!-- Localidad -->
                                    <h2>Localidad</h2>
                                    <p>Por favor, eliga localidad, es requerida para mejorar busqueda.</p>
                                    <div class="row p-3 g-6">
                                        <div class="col">
                                            <div class="row  rounded h-100">
                                                <div class="col-2 p-1 border">
                                                    <svg style="max-height: 50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm2-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"></path>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21 10.986c0 4.628-4.972 8.753-7.525 10.567a2.528 2.528 0 0 1-2.95 0C7.972 19.739 3 15.613 3 10.986 3 5.576 7.03 2 12 2s9 3.576 9 8.986Zm-2 0c0 1.613-.886 3.348-2.328 5.043-1.411 1.659-3.144 3.034-4.355 3.893a.529.529 0 0 1-.634 0c-1.21-.86-2.944-2.234-4.354-3.893C5.886 14.334 5 12.599 5 10.986 5 6.748 8.065 4 12 4s7 2.748 7 6.986Z"></path>
                                                    </svg>
                                                </div>
                                                <select name="comunidad" id="comunidad" class="col-10 border" aria-label=".form-select-lg example">
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
                                                <x-input-error :messages="$errors->get('comunidad')" class="mt-2" />
                                            </div>

                                        </div>
                                        <div class="col">
                                            <div class="row rounded h-100">
                                                <select name="provincia" id="provincia" class="border" aria-label=".form-select-lg example">
                                                    <option value="todo" selected>Seleccione provincia ...</option>
                                                    <!-- opciones insertarán desde script of-lista.js -->
                                                </select>
                                                <x-input-error :messages="$errors->get('provincia')" class="mt-2" />
                                            </div>
                                        </div>
                                        <div id="poblacion_block" class="col">
                                            <div class="row  rounded h-100">
                                                <select name="poblacion" id="poblacion" class="border" aria-label=".form-select-lg example">
                                                    <option value="todo" selected>Seleccione población ...</option>
                                                    <!-- opciones insertarán desde script of-lista.js -->
                                                </select>
                                                <x-input-error :messages="$errors->get('poblacion')" class="mt-2" />
                                            </div>
                                            <!-- Latitud y longitud de pueblo elegido, valores insertarán desde script of-lista.js - obtienen del json file -->
                                            <input  hidden type="text" id="lat_pueblo" name="lat" >
                                            <input hidden type="text" id="lon_pueblo" name="lon" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <!-- elegir raza -->
                                <div class="py-2">
                                    <select name="raza" id="raza" class="border rounded h-100 w-100 p-2">
                                        <option value="todo" selected>Seleccione Raza ...</option>
                                        <option value="agapornis">Agapornis</option>
                                        <option value="ara">Ara</option>
                                        <option value="amazona">Amazona</option>
                                        <option value="cacatúa">Cacatúa</option>
                                        <option value="ninfa">Ninfa</option>
                                        <option value="periquito">Periquito</option>
                                        <option value="yaco">Yaco</option>
                                        <option value="otros">Otros</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('raza')" class="mt-2" />
                                </div>
                                <!-- Elegir genero -->
                                <div class="py-2">
                                    <select name="genero" id="genero" class="border rounded h-100 w-100 p-2">
                                        <option value="todo" selected>Seleccione Genero ...</option>
                                        <option value="none">Genero indefinido</option>
                                        <option value="macho">macho</option>
                                        <option value="embra">embra</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('genero')" class="mt-2" />
                                </div>
                                <!--Elegir fecha de nacimiento -->
                                <div class="py-2">
                                    <label for="fecha_nac" class="form-label">Fecha de nacimiento</label>
                                    <input type="date" class="form-control border rounded h-100 w-100 p-2" id="fecha_nac" name="fecha_nac">
                                    <x-input-error :messages="$errors->get('fecha_nac')" class="mt-2" />
                                </div>

                                <!-- Campo de Fotos -->
                                <div class="py-2">
                                    <p>Cargar fotos (minimo una, maximo 5)</p>
                                    <div class="form-control">
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto1" name="foto1" accept="image/*" required>
                                            <x-input-error :messages="$errors->get('foto1')" class="mt-2" />
                                        </div>
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto2" name="foto2" accept="image/*">
                                            <x-input-error :messages="$errors->get('foto2')" class="mt-2" />
                                        </div>
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto3" name="foto3" accept="image/*">
                                            <x-input-error :messages="$errors->get('foto3')" class="mt-2" />
                                        </div>
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto4" name="foto4" accept="image/*">
                                            <x-input-error :messages="$errors->get('foto4')" class="mt-2" />
                                        </div>
                                        <div class="py-1">
                                            <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto5" name="foto5" accept="image/*">
                                            <x-input-error :messages="$errors->get('foto5')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <!-- checker mostrar telefono -->
                               <!--  <div class="py-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="mostrarTel" checked>
                                        <label class="form-check-label" for="mostrarTel">mostrar mi numero en anuncio</label>
                                    </div>
                                </div> -->

                            </div>

                        </div>
                        <!-- bottones del formulario -->
                        <div class="row justify-content-center">
                            <div class="col-2">
                                <input type="submit" name="enviar" value="Crear anuncio" class="btn  w-100 active text-uppercase font-weight-bold"> <!-- class btn-danger -->
                            </div>
                            <div class="col-2">
                                <input type="reset" name="limpiar" value="Limpiar" class="btn btn-outline-danger w-100 text-uppercase font-weight-bold">
                            </div>
                        </div>
                    </form>
                </div>
</x-app-layout>
<script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('storage/js/of-lista.js')}}"></script>
<script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
@endif
@endauth