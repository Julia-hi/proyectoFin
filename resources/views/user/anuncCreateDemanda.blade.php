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
                                <a href="{{route('user.anuncios-oferta.create', $user_id)}}" title="publicar oferta" class="btn btn-sm btn-outline-success px-2 text-uppercase" id="ofertas" style="min-width:200px;"><strong>buscar nuevo dueño</strong></a>
                                <a href="{{route('user.anuncios-demanda.create', $user_id)}}" title="publicar demanda" class="btn btn-sm btn-outline-success text-uppercase active" id="demandas" style="min-width:200px;"><strong>buscar LORO</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-2">
                <!-- Anuncios DEMANDA -->
                <div id="demandas-block" class="mt-8 p-3 bg-yellow dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="w-100 row d-flex justify-content-center align-content-center mb-2">
                        <button class="green-brillante-boton w-50 text-uppercase" onclick="window.location='{{ '/'}}';">a la pagina principal</button>
                    </div>
                    <h3 class="text-center p-2">Rellena formulario para publicar anuncio de demanda - si buscas lorito(s)</h3>
                    <form method="post" enctype="multipart/form-data" action="{{route('user.anuncios-demanda.store', $user_id)}}" id="create-demanda">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-lg-8">
                                <!-- titulo del anuncio -->
                                <div class="py-2">
                                    <label for="titulo" class="form-label">Titulo del anuncio</label>
                                    <input type="text" class="border border-success rounded h-100 w-100 p-2" id="titulo" name="titulo">
                                    <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                                </div>
                                <div class="py-2">
                                    <!-- Descripcion -->
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="border border-success rounded w-100" id="descripcion" rows="10" name="descripcion"></textarea>
                                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-lg-4 d-none d-xs-none d-md-none d-lg-block align-self-center">
                                <div class="d-flex justify-content-center">
                                    <img class="w-75" src="{{asset('storage/images/periquitos.png')}}" alt="" >
                                </div>
                            </div>
                        </div>
                        <input hidden type="text" class="border rounded h-100 w-100 p-2" id="tipo_anuncio" name="tipo_anuncio" value="demanda">
                        <input hidden type="text" class="border rounded h-100 w-100 p-2" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                        <!-- bottones del formulario -->
                        <div class="row justify-content-center">
                            <div class="col-lg-3 col-sm-12 mt-2">
                                <input id="crear-anuncio" type="submit" name="enviar" value="Crear anuncio" class="btn btn-green w-100 active text-uppercase font-weight-bold">
                            </div>
                            <div class="col-lg-3 col-sm-12 mt-2">
                                <input type="reset" name="limpiar" value="Limpiar" class="btn btn-outline-danger w-100 text-uppercase font-weight-bold">
                            </div>
                        </div>
                    </form>
                </div>


            </div>



</x-app-layout>
<script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
<!-- <script src="{{asset('storage/js/of-lista.js')}}"></script>
<script src="{{asset('storage/js/welcome.js')}}"></script> -->
<script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
@endif
@endauth