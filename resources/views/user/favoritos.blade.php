@auth
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis favoritos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-yellow text-center" style="min-height:500px;">
                    <div class="w-100 row d-flex justify-content-center align-content-center mb-2">
                        <button class="green-brillante-boton w-50 text-uppercase" onclick="window.location='{{ '/'}}';">a la pagina principal</button>
                    </div>
                    <h2 class="h3 text-uppercase mt-4">Mis favoritos</h2>
                    <div class="pt-3">
                        @if ($favoritos == null)
                        <p>Todavia no tienes favoritos</p>
                        <div class="w-100 d-flex justify-content-center mt-4">
                            <img class="w-25" src="{{asset('storage/images/periquitos.png')}}" alt="">
                        </div>
                        @else
                        @foreach ($favoritos as $fav)
                        @if($fav->anuncio->tipo =='oferta')
                        <div class="row w-100 m-0 p-2 align-items-center">
                            <div class="col-1 text-left"><b>ID</b>: {{ $fav->anuncio->id }}</div>
                            <?php $fotos = $fav->anuncio->anuncioOferta->fotos; ?>
                            <div class="col-1 text-left">
                                <img class="card-img-top" src="{{ $fotos[0]->enlace }}" alt="{{ $fav->anuncio->titulo }}" style="height: 80px; width: 100%; display: block; object-fit: cover" data-holder-rendered="true">
                            </div>
                            <div class="col-2 text-left"> {{ $fav->anuncio->anuncioOferta->titulo }}</div>
                            <div class="col text-left"> {{ $fav->anuncio->anuncioOferta->descripcion }}</div>
                            <div class="col-3">
                                <div class="btn-group border d-flex align-items-center justify-content-center">
                                    <a href="{{ '/ofertas/' . $fav->anuncio->anuncioOferta->id }}" role="button" class="btn btn-sm btn-outline-success active px-2 text-uppercase">Ver</a>
                                    <!-- formulario para Eeiminar favorito de la lista -->
                                    <form action="{{ route('user.favoritos.destroy', [Auth::user()->id, $fav->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-success text-uppercase"><strong>Eliminar de favoritos</strong></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @elseif($fav->anuncio->tipo =='demanda')
                        <div class="row w-100 m-0 p-2 align-items-center">
                            <div class="col-1 text-left"> {{ $fav->anuncio->id }}</div>

                            <div class="col-2 text-left"> {{ $fav->anuncio->anuncioOferta->titulo }}</div>
                            <div class="col text-left"> {{ $fav->anuncio->anuncioOferta->descripcion }}</div>
                            <div class="col-3">
                                <div class="btn-group d-flex align-items-center">
                                    <?php $url = '/ofertas/' . $fav->id; ?>
                                    <a href="<?php echo $url; ?>" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver</a>

                                    <!-- formulario para Eeiminar favorito de la lista -->
                                    <form action="{{ route('user.favoritos.destroy', [Auth::user()->id, $fav->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-secondary text-uppercase">Eliminar de favoritos</button>
                                    </form>
                                    <!-- <a href="" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Dejar de seguir</a> -->
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endauth
@guest
<div>Para ver favoritos tienes que iniciar sesión</div>
@endguest