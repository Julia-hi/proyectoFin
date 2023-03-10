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
            <div class="m-2">
                <!-- Anuncios oferta -->
                <div id="ofertas-block" class="mt-8 p-3 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg h-auto">
                    <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">Modifica tu anuncio</h2>
                    <?php $url_update = "/user/" . $user_id . "/anuncios-oferta/" . $anuncio->id ?>

                    <div class="row">
                        <div class="col-8">
                            <form method="post" enctype="multipart/form-data" action="{{$url_update}}" id="edit_oferta">
                                @csrf
                                @method('PUT')
                                <!-- anuncio completo para uso de js -->
                                <div id="anuncio_actuale" class="hidden">{{ $anuncio }}</div>
                                <!-- titulo del anuncio -->
                                <div class="py-2">
                                    <label for="titulo" class="form-label">Titulo del anuncio</label>
                                    <input type="text" class="border rounded h-100 w-100 p-2" id="titulo" name="titulo" value="{{$anuncio->titulo}}" required minlength="10" maxlength="100">
                                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                                </div>
                                <!-- Descripcion -->
                                <div class="py-2">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="descripcion" rows="10" name="descripcion" required minlength="10" maxlength="300">{{$anuncio->descripcion}}</textarea>
                                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                                </div>
                                <!-- Localidad -->
                                <h2 class="w-0 p-0">Localidad</h2>
                                <div class="row p-3 g-6py-2">
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
                                            <x-input-error :messages="$errors->get('comunidad')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row rounded h-100">
                                            <select name="provincia" id="provincia" class="border" aria-label=".form-select-lg example">
                                                <option value="todo">Seleccione provincia ...</option>
                                                <!-- opciones insertarán desde script editOferta.js -->
                                            </select>
                                            <x-input-error :messages="$errors->get('provincia')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div id="poblacion_block" class="col">
                                        <div class="row  rounded h-100">
                                            <select name="poblacion" id="poblacion" class="border" aria-label=".form-select-lg example">
                                                <option value="todo">Seleccione población ...</option>
                                                <!-- opciones insertarán desde script editOferta.js -->
                                            </select>
                                            <x-input-error :messages="$errors->get('poblacion')" class="mt-2" />
                                        </div>
                                        <!-- Latitud y longitud de pueblo elegido, valores insertarán desde script of-lista.js - obtienen del json file -->
                                        <input hidden type="text" id="lat_pueblo" name="lat">
                                        <input hidden type="text" id="lon_pueblo" name="lon">
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- elegir raza -->
                                    <div class="col py-2">
                                        <label for="raza" class="form-label">Raza</label>
                                        <select name="raza" id="raza" class="border rounded w-100 p-2">
                                            <option value="todo">Seleccione Raza ...</option>
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
                                    <div class="col py-2">
                                        <label for="genero" class="form-label">Genero</label>
                                        <select name="genero" id="genero" class="border rounded w-100 p-2">
                                            <option value="none">Genero indefinido</option>
                                            <option value="macho">macho</option>
                                            <option value="embra">embra</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('genero')" class="mt-2" />
                                    </div>
                                    <!--Elegir fecha de nacimiento -->
                                    <div class="col py-2">
                                        <label for="fecha_nac" class="form-label">Fecha de nacimiento</label>
                                        <input type="date" class="form-control border rounded w-100 p-2" id="fecha_nac" name="fecha_nac">
                                        <x-input-error :messages="$errors->get('fecha_nac')" class="mt-2" />
                                    </div>
                                </div>
                                <!-- bottones del formulario -->
                                <div class="row justify-content-center">
                                    <div class="col-4">
                                        <input type="submit" name="enviar" value="Guardar cambios" class="btn  w-100 active text-uppercase font-weight-bold"> <!-- class btn-danger -->
                                    </div>
                                    <div class="col-4">
                                        <a href="{{route('user.anuncios.index',Auth::user()->id)}}" class="btn btn-outline-danger w-100 text-uppercase font-weight-bold">Salir sin cambios</a>
                                    </div>
                                </div>
                            </form>
                            <!-- FIN del formulario -->
                        </div>
                        <div class="col-4">
                            <!-- Campo de Fotos -->
                            <div class="py-2">
                                <p>Cargar fotos (minimo una, maximo 5)</p>
                                <div class="form-control">
                                    @foreach($anuncio->fotos as $i=>$foto)
                                    <div class="row p-1 ">
                                        <div class="col-4">
                                            <img src="{{$foto->enlace}}" alt="" style="width:100px; height: 100px; display: block; object-fit: cover">
                                        </div>
                                        <div class="col">
                                            @if($i!=0)
                                            <!-- Metodo delete eccepto primera foto (required, no se puede eliminar) -->
                                            <form method="POST" action="{{ route('oferta.fotos.destroy', ['ofertum'=>$anuncio->id, 'foto'=>$foto->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" name="enviar" value="Eliminar foto" class="btn w-auto active text-uppercase font-weight-bold m-1">
                                            </form>
                                            @endif
                                            <?php $url_put = 'oferta/{{$anuncio->id}}/fotos/{{$foto->id}}' ?>
                                            <div>
                                                <form class="" method="POST" action="{{ route('oferta.fotos.update', ['ofertum'=>$anuncio->id, 'foto'=>$foto->id]) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="file" class="h-100 w-100 p-2" id="foto{{$i}}" name="foto{{$i}}" accept="image/*" required>
                                                    <x-input-error :messages="$errors->get('foto1')" class="mt-2" />
                                                    <button type="submit" class="btn w-75 active text-uppercase font-weight-bold">modificar foto</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                                        <?php $numFotos = $anuncio->fotos->count(); ?>
                                        @if($numFotos < 5) 
                                        <div>
                                            <p>Puedes añadir {{5-$numFotos}} fotos más</p>
                                            <form method="post" action="{{ route('oferta.fotos.store', ['ofertum'=>$anuncio->id]) }}" enctype="multipart/form-data">
                                                @csrf
                                                @for ($i=($numFotos); $i <5; $i++) <div class="py-1">
                                                    <input type="file" class="form-control border rounded h-100 w-100 p-2" id="foto{{$i}}" name="foto{{$i}}" accept="image/*">
                                                    <x-input-error :messages="$errors->get('foto{{$i}}')" class="mt-2" />
                                                @endfor
                                                <button type="submit" class="btn w-75 active text-uppercase font-weight-bold">Añadir fotos</button>
                                            </form>
                                        </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
</x-app-layout>
<script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('storage/js/editOferta.js')}}"></script>
<!-- <script src="{{asset('storage/js/of-lista.js')}}"></script> -->
<script>
    $(document).ready(function() {
        $('#submit-both-forms').click(function() {
            $('.modificarFoto').each((ind, modificar) => {
                console.log(modificar);
                $(modificar).submit();
            })
            $('.crearFoto').each((ind, elemento) => {
                $(elemento).submit();
            })
        });
    });
</script>
@endif
@endauth