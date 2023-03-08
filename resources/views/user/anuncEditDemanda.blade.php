<?php

use App\Models\AnuncioDemanda;
use App\Models\Anuncio;
use Illuminate\Support\Facades\DB;

$user_id = Auth::user()->id; ?>
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
            {{ __('Modificar anuncio') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="justify-center sm:px-6 lg:px-8">
            <div class="m-2 ">
                <div class="mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">Modifica anuncio</h2>

                </div>
            </div>
            <div class="m-2">
                <!-- Anuncios DEMANDA -->
                <div id="demandas-block" class="mt-8 p-3 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <?php
                    $url_update="/user/".$user_id."/anuncios-demanda/".$anuncio->id ?>
                        <form method="post" enctype="multipart/form-data" action="{{$url_update}}" id="edit-demanda">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-8">
                                    <!-- titulo del anuncio -->
                                    <div class="py-2">
                                        <label for="titulo" class="form-label">Titulo del anuncio</label>
                                        <input type="text" class="border rounded h-100 w-100 p-2" id="titulo" name="titulo" value="{{$anuncio->titulo}}" required min=10 max=100>
                                        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                                    </div>
                                    <div class="py-2">
                                        <!-- Descripcion -->
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="descripcion" rows="10" name="descripcion" required min=10 max=300>{{$anuncio->descripcion}}</textarea>
                                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <input hidden type="text" class="border rounded h-100 w-100 p-2" id="tipo_anuncio" name="tipo_anuncio" value="demanda">
                            <input hidden type="text" class="border rounded h-100 w-100 p-2" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                            <!-- bottones del formulario -->
                            <div class="row justify-content-center">
                                <div class="col-2">
                                    <input type="submit" name="enviar" value="Guardar cambios" class="btn btn-danger w-100 active text-uppercase font-weight-bold">
                                </div>
                                <div class="col-2">
                                    <a href="{{route('user.anuncios.index',Auth::user()->id)}}" class="btn btn-outline-danger w-100 text-uppercase font-weight-bold">Salir sin cambios</a>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
</x-app-layout>
<script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
@endif
@endauth