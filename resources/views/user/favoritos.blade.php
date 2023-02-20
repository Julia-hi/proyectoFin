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
            {{ __('Mis favoritos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Mis favoritos') }}
                    </h2>
                    <div class="pt-3">

                        @if ($favoritos == null)
                        <p>Todavia no tienes favoritos</p>
                        @else
                        @foreach ($favoritos as $fav)
                        @if($fav->anuncio->tipo =='oferta')
                        <div class="row w-100 m-0 p-2 align-items-center">
                            <div class="col-1 text-left"> {{ $fav->anuncio->id }}</div>
                            <?php $fotos = $fav->anuncio->anuncioOferta->fotos; ?>
                            <div class="col-1 text-left">
                                <img class="card-img-top" src="{{ $fotos[0]->enlace }}" alt="{{ $fav->anuncio->titulo }}" style="height: 80px; width: 100%; display: block; object-fit: cover" data-holder-rendered="true">
                            </div>
                            <div class="col-2 text-left"> {{ $fav->anuncio->anuncioOferta->titulo }}</div>
                            <div class="col text-left"> {{ $fav->anuncio->anuncioOferta->descripcion }}</div>
                            <div class="col-3">
                                <div class="btn-group d-flex align-items-center">
                                    <?php $url = '/ofertas/' . $fav->id; ?>
                                    <a href="<?php echo $url; ?>" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver</a>
                                    <!--   <form method="delete" action="{{ route('user.favoritos.destroy',['user'=>Auth::user(),'favorito' => $fav->id]) }}">

                                        <input type="hidden" name="id_anuncio" value="{{ $fav->anuncio->id }}">
                                        <button type="submit"><img title="eliminar de favoritos" src="<?php echo Storage::url('images/icons/heart-solid.svg'); ?>" style="width:1em;" class="mx-2"></button>
                                    </form> -->
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
@endif
@endauth