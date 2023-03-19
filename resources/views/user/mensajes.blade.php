<?php
use App\Models\Anuncio;
?>
<x-app-layout>
@auth
@if(Auth::user()->rol == "admin")
ADMIN NO TIENE ACCESSO TO MENSAJERIA
<div class="w-100 row d-flex justify-content-center align-content-center mb-2">
    <button class="btn btn-success active w-50 text-uppercase" onclick="window.location='{{ '/admin-dashboard'}}';">ADMIN PAGE</button>
</div>
@else
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis mensajes') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center bg-yellow" style="min-height:500px;">
                    <div class="w-100 row d-flex justify-content-center align-content-center mb-2">
                        <button class="green-brillante-boton w-50 text-uppercase" onclick="window.location='{{ '/'}}';">a la pagina principal</button>
                    </div>
                    <h2 class="h3 text-uppercase mt-4">Mis mensajes</h2>
                    <div class="pt-3">
                        @if($dialogos == null || count($dialogos)==0)
                        <div class="text-center ">
                            <p>Todavia no tienes mensajes. Inicia chat con anunciantes desde campo del anuncio.
                                Despues todos mensajes seran disponibles aqui.</p>
                            <div class="w-100 d-flex justify-content-center mt-4">
                                <img class="w-25" src="{{asset('storage/images/periquitos.png')}}" alt="">
                            </div>
                        </div>
                        @else
                        <div>Tienes {{ count($dialogos) }} conversaciones</div>

                        @foreach($dialogos as $key=>$dialogo)
                        <?php $anuncio = Anuncio::find($dialogo[$key]->anuncio_id) ?>

                        <div class="row p-2 w-100">
                            <div class=" col-1 text-left"><strong>id: </strong><span id="{{'anuncio'.$key}}">{{$anuncio->id}}</span></div>
                            <div class="col-1 text-left">autor: {{ $anuncio->autor->name }}</div>
                            @if($anuncio->tipo =='oferta')
                            <div class="col-1 text-left">
                                <img style="height: 80px; width: 80px; display: block; object-fit: cover" src="{{ $dialogo[0]->anuncio->anuncioOferta->fotos[0]->enlace }}" alt="{{ $dialogo[0]->anuncio->anuncioOferta->titulo }}">
                            </div>
                            <div class="col text-left">{{ $anuncio->tipo }}: {{ $anuncio->anuncioOferta->titulo }}</div>
                            @elseif($anuncio->tipo =='demanda')
                            <div class="col text-left">{{ $anuncio->tipo }}: {{ $anuncio->anuncioDemanda->titulo }}</div>
                            @endif
                            <div class="col-3 text-left">
                                <?php $id_chat = "chat" . $key;  ?>
                                <div class="btn-group d-flex align-items-center">
                                    @if($anuncio->tipo =='oferta')
                                    <a href="/ofertas/{{$anuncio->id}}" role="button" class="btn btn-sm btn-outline-success text-uppercase"><strong>Ver anuncio</strong></a>
                                    @elseif($anuncio->tipo =='demanda')
                                    <a href="/demandas/{{$anuncio->id}}" role="button" class="btn btn-sm btn-outline-success text-uppercase"><strong>Ver anuncio</strong></a>
                                    @endif
                                    <a id='_{{$key}}' href="#<?php echo $id_chat; ?>" class="mostrarChatBoton btn btn-sm btn-outline-success text-uppercase"><strong>Mostrar chat</strong></a>
                                </div>
                            </div>
                        </div>

                        <div id="<?php echo $id_chat; ?>" class="chat hidden position-relative mx-auto w-100 " title="">
                            <div id="<?php echo ('chat_body' . $key); ?>" class="border border-green" style="min-height:25%; max-height:300px; background-color: #D8F3DC; overflow-y: scroll;overflow-x: hidden;">
                                <!-- Flecha para cerrar ventana del chat -->
                                <div id="cruce" data-title="Cerrar" class="cruce bg-white position-sticky top-0 start-0" style="width:25px; height:25px; z-index:30; cursor:pointer;">
                                    <svg style="z-index:35;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16">
                                        <path fill="#273A0E" d="M11.414 4.586a2 2 0 0 0-2.828 0L8 5.172 6.414 3.586a2 2 0 1 0-2.828 2.828L5.172 8l-1.586 1.586a2 2 0 1 0 2.828 2.828L8 10.828l1.586 1.586a2 2 0 1 0 2.828-2.828L10.828 8l1.586-1.586a2 2 0 0 0 0-2.828z" />
                                    </svg>
                                </div>
                                <?php $user1 = $dialogo[0]->remitente_id;
                                $user2 = $dialogo[0]->recipiente_id ?>

                                @foreach($dialogo as $mensaje)

                                @if($mensaje->remitente->id == Auth::user()->id)
                                <div class="row justify-content-end mx-3 my-1">
                                    <div class="col-8 bg-white rounded px-3 py-2 w-auto max-w-75 justify-content-end">
                                        <div class="flex justify-content-end">
                                            <p class="text-right pr-0">{{ $mensaje->texto }}</p>
                                        </div>
                                        <div class="flex justify-content-end"><small class="text-muted text-right">{{ $mensaje->created_at->format('d-m-Y H:i') }}</small></div>
                                    </div>
                                </div>
                                @elseif($mensaje->remitente->id != Auth::user()->id)
                                <div class="row flex justify-content-start mx-3 my-1">
                                    <small class="text-left">{{ $mensaje->remitente->name }}:</small>
                                    <div class="bg-white rounded p-2 w-auto max-w-75">
                                        <p class="text-left">{{ $mensaje->texto }} <br>
                                            <small class="text-muted">{{ $mensaje->created_at->format('d-m-Y H:i') }}</small>
                                        </p>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <?php if (Auth::user()->id == $user1) {
                                $remitente = $user1;
                                $recipiente = $user2;
                            } else {
                                $recipiente = $user1;
                                $remitente = $user2;
                            } ?>
                            <div class="pb-1">
                                <form id="enviar-mensaje" method="POST" action="{{ route('user.mensajes.store',$remitente) }}">
                                    @csrf
                                    <textarea class="form-control border-green" id="mensaje" rows="2" name="texto" placeholder="Escribe mensaje aquí..."></textarea>
                                    <x-input-error :messages="$errors->get('texto')" class="mt-2" />
                                    <input hidden name="anuncio_id" type="text" value="{{ $anuncio->id }}" />
                                    <input hidden name="recipiente_id" type="text" value="{{ $recipiente }}" />
                                    <input hidden name="remitente_id" type="text" value="{{ $remitente }}" />
                                    <input hidden name="id_chat" type="text" value="{{ $id_chat }}" />
                                    <div class="d-flex items-center justify-content-end my-4">
                                        <button type="submit" class="enviar-form btn btn-green active text-uppercase font-weight-bold ml-3" style="width:100px;height:40px;">Enviar</button>
                                        <button type="reset" class="limpiar-form btn btn-danger active text-uppercase font-weight-bold ml-3" style="width:100px;height:40px;">Limpiar</button>
                                        <button id="cerrar_dragable" type="button" style="width:150px; height:40px;" class="cerrar_form btn btn-outline-warning active text-uppercase font-weight-bold ml-3">Cerrar chat</button>
                                    </div>
                                </form>
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
<script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('storage/js/mensajes.js')}}"></script>
<script>
    $(document).ready(function() {
        //evento para confirmar envio del mensaje
        $('#enviar_mensaje').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estas seguro? Queres Enviar mensaje?',
                icon: 'warning',
                iconColor: '#FC4B3B',
                showCancelButton: true,
                confirmButtonColor: '#76A728',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si! enviar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // se envia la peticion si usuario ha confirmado
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.mensajes.store', ['user'=>Auth::user()->id]) }}",
                        data: $("#enviar_mens_form").serialize(),
                        success: function(response) {
                            // mostrar una alerta con la respuesta del servidor
                            Swal.fire({
                                title: '¡Mensaje enviado!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#76A728'
                            });
                        },
                        error: function(xhr) {
                            // manejar errores si es necesario
                        }
                    });
                }
            });
        });
    });
</script>