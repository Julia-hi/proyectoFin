
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
                    <p>Anuncios favoritos disponibles.</p>
                    <div class="pt-3">
                        
                        @if ($anuncios == "favoritos no encontrados") 
                            echo "todavia no tienes favoritos";
                        @else
                            @foreach ($favoritos as $fav)
                            <div class="row w-100 m-0 p-2 align-items-center">
                                <div class="col-1 text-left"> {{ $fav->anuncio->id }}</div>
                                <div class="col-2 text-left"> {{ $fav->anuncio->titulo }}</div>
                                <div class="col text-left"> {{ $fav->anuncio->descripcion }}</div>
                                <div class="col-3 ">
                                    <div class="btn-group d-flex align-items-center">
                                    <?php $url = '/ofertas/'.$fav->id; ?>
                                        <a href="<?php echo $url; ?>" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver</a>
                                        <a href="" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Dejar de seguir</a>
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