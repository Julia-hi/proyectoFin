<?php

use App\Models\Calendar;
use Illuminate\Support\Facades\Storage;

$calendarStyle = Storage::url('calendar.css'); ?>

<x-app-layout>
    @push('styles')
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    @endpush

    <div class="container pt-3">

        <div class="mt-8 p-2 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">

            <h2 class='p-2 my-2 text-center'>Crear nuevo anuncio</h2>
            @auth
            <div class="row justify-content-center">
                <div class="btn-group border d-flex justify-content-center w-50">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.href='{{ url('/ofertas/lista/todo')}}'">OFERTAS</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.href='{{ url('/demandas') }}'">DEMANDAS</button>
                </div>
            </div>
            <div class="container">
                <div class="justify-content-center p-3 w-100 " id="form-ofertas">
                    <form method="post" enctype="multipart/form-data" action="{{route('anuncio.store')}}" id="create_anuncio">
                        <div class="align-items-start row">
                            <div class="col py-2">
                                <label for="title" class="form-label">Titulo</label>
                                <input type="text" class="border rounded h-100 w-100 p-2" id="title" name="title">
                                <div class="py-2">
                                    <select name="genero" id="genero" class="border rounded h-100 w-100 p-2">
                                        <option value="none" checked>Elegir genero</option>
                                        <option value="indefinido">indefinido</option>
                                        <option value="macho">macho</option>
                                        <option value="embra">embra</option>
                                    </select>
                                </div>
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
                                <!--Elegir fecha de nacimiento -->
                                <div class="py-2">
                                    <p>Fecha de nacimiento</p>
                                    <!-- <label for="paisOrigen" class="form-label">Fecha de nacimiento</label> -->
                                    <input type="text" class="form-control" id="paisOrigen" name="paisOrigen">

                                </div>
                                <!-- Incluso "component" of calendario ruta: resources/views/components/calendar.blade.php-->
                                <div class="col"><x-calendar> </x-calendar></div>
                            </div>

                            <!-- Descripcion -->
                            <div class="col py-2">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" rows="10" name="description"></textarea>
                                <label for="foto" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="foto" name="foto">

                            </div>
                            <div class='row'>
                                <input type="submit" name="enviar" value="Enviar" class='btn btn-warning btn-mio'>
                                <input type="reset" name="limpiar" value="Limpiar" class='btn btn-outline-warning btn-mio'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endauth

            @guest
            <p class="text-white">bienvenidos, guest! No estas logeado...</p>
            <button>register</button>
            <button>login</button>
            @endguest
        </div>

    </div>

</x-app-layout>