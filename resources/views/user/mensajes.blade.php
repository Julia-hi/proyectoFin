<?

use App\Models\Mensaje; ?>
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
            {{ __('Mis mensajes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Mis mensajes') }}
                    </h2>
                    <div class="pt-3">
                        @if($dialogos == null)
                        <div class="text-center">todavia no tienes mensajes</div>
                        @else
                        <div>Tienes {{ count($dialogos) }} conversaciones</div>
                        @foreach($dialogos as $key=>$dialogo)
                        <div>
                            <!-- grupo de mensajes pertenecentes a un anuncio -->
                            @if($dialogo[0]->anuncio->tipo =='oferta')
                            <div class="row p-2">
                                <div class="col-1 text-left">id: {{ $key }}</div>
                                <div class="col-1 text-left">autor: {{ $dialogo[0]->anuncio->anuncioOferta->autor->name }}</div>
                                <div class="col-1 text-left"><img style="height: 80px; width: 80px; display: block; object-fit: cover" src="{{ $dialogo[0]->anuncio->anuncioOferta->fotos[0]->enlace }}" alt="{{ $dialogo[0]->anuncio->anuncioOferta->titulo }}"> </div>
                                <div class="col-5 text-left">{{ $dialogo[0]->anuncio->tipo }}: {{ $dialogo[0]->anuncio->anuncioOferta->titulo }}</div>
                                <div class="col-2 text-left">
                                    <div class="btn-group d-flex align-items-center">
                                        <a href="/ofertas/{{$key}}" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver anuncio</a>
                                        <button id='mostrarChatBoton' class="btn btn-sm btn-outline-secondary text-uppercase">Mostrar el chat</button>
                                    </div>
                                </div>
                            </div>
                            <div id="{{ $key }}" class="border">
                                @foreach($dialogo as $mensaje)

                                <div class="row w-100 m-0 p-2 align-items-center hidden">
                                    <div class="col-1 text-left"> ID: {{ $mensaje->id }}</div>
                                    <div class="col-2 text-left">User: {{ $mensaje->usuario->name}} </div>
                                    <div class="col-2 text-left">tipoAnunc: {{ $mensaje->anuncio->tipo}} </div>
                                    <div class="col text-left">{{ $mensaje->texto}}</div>
                                    <div class="col-2 text-left">Enviado: {{ $mensaje->created_at }} </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                        <div>
                            <?php $autor = Auth::user(); ?>

                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
@endauth