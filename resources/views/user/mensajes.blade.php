<?php

use App\Models\Anuncio; ?>
@auth
@if(Auth::user()->rol=="admin")
<!--  <a class="nav-link" href="{{ url('/home') }}">Panel de admin</a> -->
<?php echo "I am admin";
//  return redirect()->route('admin/dashboard');
?>
@else
<script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis mensajes') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center ">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Mis mensajes') }}
                    </h2>

                    <div class="pt-3">
                        @if($dialogos == null)
                        <div class="text-center">todavia no tienes mensajes</div>
                        @else
                        <div>Tienes {{ count($dialogos) }} conversaciones</div>
                        @foreach($dialogos as $key=>$dialogo)

                        <?php $anuncio = Anuncio::find($dialogo[$key]->anuncio_id) ?>


                        <div class="row p-2 w-100">
                            <div class=" col-1 text-left"><span>id: </span><span id="{{'anuncio'.$key}}">{{$anuncio->id}}</span></div>
                            <div class="col-1 text-left">autor: {{ $anuncio->autor->name }}</div>
                            @if($anuncio->tipo =='oferta')
                            <div class="col-1 text-left"><img style="height: 80px; width: 80px; display: block; object-fit: cover" src="{{ $dialogo[0]->anuncio->anuncioOferta->fotos[0]->enlace }}" alt="{{ $dialogo[0]->anuncio->anuncioOferta->titulo }}"> </div>

                            <div class="col text-left">{{ $anuncio->tipo }}: {{ $anuncio->anuncioOferta->titulo }}</div>
                            @elseif($anuncio->tipo =='demanda')
                            <div class="col text-left">{{ $anuncio->tipo }}: {{ $anuncio->anuncioDemanda->titulo }}</div>
                            @endif
                            <div class="col-3 text-left">
                                <?php $id_chat = "chat" . $key;  ?>
                                <p>Chat id: {{ $id_chat}}</p>
                                <div class="btn-group d-flex align-items-center">
                                    @if($anuncio->tipo =='oferta')
                                    <a href="/ofertas/{{$anuncio->id}}" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver anuncio</a>
                                    @elseif($anuncio->tipo =='demanda')
                                    <a href="/demandas/{{$anuncio->id}}" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver anuncio</a>
                                    @endif
                                    <a id='_{{$key}}' href="#<?php echo $id_chat; ?>" class="mostrarChatBoton btn btn-sm btn-outline-secondary text-uppercase">Mostrar chat</a>
                                </div>
                            </div>
                        </div>

                        <div id="<?php echo $id_chat; ?>" class="chat hidden  position-relative mx-auto w-100" title="">
                            <span hidden>{{$anuncio->id}}</span>
                            <div id="<?php echo ('chat_body' . $key); ?>" class="border" style="min-height:25%; max-height:50%; background-color: #D8F3DC; overflow-y: scroll;overflow-x: hidden;">
                                <!-- Flecha para cerrar ventana del chat -->
                                <div id="cruce" data-title="Cerrar" class="cruce bg-white position-sticky top-0 start-0" style="width:25px; height:25px; z-index:30; cursor:pointer;">
                                    <svg style="z-index:35;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16">
                                        <path fill="#1F2937" d="M11.414 4.586a2 2 0 0 0-2.828 0L8 5.172 6.414 3.586a2 2 0 1 0-2.828 2.828L5.172 8l-1.586 1.586a2 2 0 1 0 2.828 2.828L8 10.828l1.586 1.586a2 2 0 1 0 2.828-2.828L10.828 8l1.586-1.586a2 2 0 0 0 0-2.828z" />
                                    </svg>
                                </div>
                                <?php $user1 = $dialogo[0]->remitente_id;
                                $user2 = $dialogo[0]->recipiente_id ?>
                                
                                <span id="user1" hidden>{{ $user1 }}</span>
                                <span id="user2" hidden>{{ $user2 }}</span>
                               
                                @foreach($dialogo as $mensaje)
                                @if($mensaje->remitente->id == Auth::user()->id)
                                <div class="row flex justify-content-end">
                                    <div class="col-lg-8 mx-3">
                                        <ul class="list-group">

                                            <!-- <li class="d-flex justify-content-end w-100">Yo:</li> -->
                                            <li class="d-flex justify-content-end w-100 mb-2 mt-0">
                                                <div class="bg-white rounded px-3 py-2">{{ $mensaje->texto }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @else
                                <div class="row flex justify-content-start">
                                    <div class="col-lg-8">
                                        <ul class="list-group">
                                            <li class="d-flex justify-content-start w-100">{{ $mensaje->remitente->name}}:</li>

                                            <li class="d-flex justify-content-start w-100 mb-2 mt-0">
                                                <div class="bg-white rounded px-3 py-2">{{ $mensaje->texto }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                <div class="row flex justify-content-end">
                                    <div class="col-lg-8 mx-3">
                                        <ul class="list-group" id="<?php echo ('ultimo_mensaje' . $key) ?>">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
@endauth

<script src="{{asset('storage/js/mensajes.js')}}"></script>