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
                    
                    <div class="pt-3 position-relative">
                        @if($dialogos == null)
                        <div class="text-center">todavia no tienes mensajes</div>
                        @else
                        <div>Tienes {{ count($dialogos) }} conversaciones</div>
                        @foreach($dialogos as $key=>$dialogo)

                        <!-- grupo de mensajes pertenecentes a un anuncio -->
                        @if($dialogo[0]->anuncio->tipo =='oferta')
                       
                        <div class="row p-2 w-100">
                            <div class="col-1 text-left">id: {{ $key }}</div>
                            <div class="col-1 text-left">autor: {{ $dialogo[0]->anuncio->anuncioOferta->autor->name }}</div>
                            <div class="col-1 text-left"><img style="height: 80px; width: 80px; display: block; object-fit: cover" src="{{ $dialogo[0]->anuncio->anuncioOferta->fotos[0]->enlace }}" alt="{{ $dialogo[0]->anuncio->anuncioOferta->titulo }}"> </div>
                            <div class="col-6 text-left">{{ $dialogo[0]->anuncio->tipo }}: {{ $dialogo[0]->anuncio->anuncioOferta->titulo }}</div>
                            <div class="col-3 text-left">
                                <div class="btn-group d-flex align-items-center">
                                    <a href="/ofertas/{{$key}}" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver anuncio</a>
                                    <button id='_{{$key}}' class="mostrarChatBoton btn btn-sm btn-outline-secondary text-uppercase">Mostrar el chat</button>
                                </div>
                            </div>
                        </div>
                        <div id="chatContent"></div>
                       <!--  <div id="chat{{ $key }}" class="oculto">
                            <div class="border position-absolute px-2 mx-auto w-25 h-25" style="top:0; left:0; min-height:25%; background-color: red; z-index:10;" title="Cerrar">
                                <div class="bg-white position-absolute top-0 start-0" style="width:25px; height:25px; z-index:30;" onclick="document.getElementById('chat{{ $key }}').classList.add('oculto');">
                                    <svg style="z-index:35;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16">
                                        <path fill="#1F2937" d="M11.414 4.586a2 2 0 0 0-2.828 0L8 5.172 6.414 3.586a2 2 0 1 0-2.828 2.828L5.172 8l-1.586 1.586a2 2 0 1 0 2.828 2.828L8 10.828l1.586 1.586a2 2 0 1 0 2.828-2.828L10.828 8l1.586-1.586a2 2 0 0 0 0-2.828z" />
                                    </svg>
                                </div>
                            </div>

                        </div>  -->

                        <!-- ************************* -->
                        <!-- <div id="chat{{ $key }}" class="h-50 hidden" style="overflow-y: auto; overflow-x: hidden;">
                                <div class="border position-relative px-2 mx-auto w-100" style="min-height:25%; background-color: #D8F3DC;" title="Cerrar">
                                    <div class="bg-white position-sticky top-0 start-0" style="width:25px; height:25px; " onclick="document.getElementById('chat{{ $key }}').classList.add('hidden');">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16">
                                            <path fill="#1F2937" d="M11.414 4.586a2 2 0 0 0-2.828 0L8 5.172 6.414 3.586a2 2 0 1 0-2.828 2.828L5.172 8l-1.586 1.586a2 2 0 1 0 2.828 2.828L8 10.828l1.586 1.586a2 2 0 1 0 2.828-2.828L10.828 8l1.586-1.586a2 2 0 0 0 0-2.828z" />
                                        </svg>
                                    </div>
                                    @foreach($dialogo as $mensaje)
                                    @if($mensaje->usuario->id == Auth::user()->id)
                                    <div class="row flex justify-content-end">
                                        <div class="col-lg-8">
                                            <ul class="list-group">
                                                <li class="d-flex justify-content-end w-100">Yo:</li>
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
                                                <li class="d-flex justify-content-start w-100">{{ $mensaje->usuario->name}}:</li>
                                                <li class="d-flex justify-content-start w-100 mb-2 mt-0">
                                                    <div class="bg-white rounded px-3 py-2">{{ $mensaje->texto }}</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    <div class="card-footer ">
                                        <form method="POST" action="{{ route('user.mensajes.store', Auth::user()->id) }}">
                                            @csrf
                                            <textarea class="form-control" id="mensaje" rows="2" name="texto" placeholder="Escribe mensaje aquí..."></textarea>
                                            <x-input-error :messages="$errors->get('texto')" class="mt-2" />
                                            <input hidden name="anuncio_id" type="text" value="{{ $dialogo[0]->anuncio->id }}" />
                                            <input hidden name="user_id" type="text" value="{{ Auth::user()->id }}" />
                                            <div class="d-flex items-center justify-content-end my-2">
                                                <x-reset-button class="ml-3">
                                                    {{ __('Limpiar') }}
                                                    </x-primary-button>
                                                    <x-primary-button class="ml-3">
                                                        {{ __('Enviar') }}
                                                    </x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                        @endif
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

// Check if there is a success message in the session
@if(session('visible'))
<script>
    // Scroll the page to the form element
    document.body.scrollIntoView({
        behavior: 'smooth'
    });
</script>
@endif

<script src="{{asset('storage/js/mensajes.js')}}"></script>