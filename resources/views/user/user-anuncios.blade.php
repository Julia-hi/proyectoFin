@auth
@if(Auth::user()->rol=="admin")
<!--  <a class="nav-link" href="{{ url('/home') }}">Panel de admin</a> -->
<?php echo "I am admin";
//  return redirect()->route('admin/dashboard');
?>
@else
@if(isset($status))
<script>
    alert('Estoy aqui');
</script>

@endif
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis anuncios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Mis anuncios') }}
                    </h2>
                    <div class="pt-3">
                        <?php
                        $numAnuncios = $demandas->count() + $ofertas->count(); ?>
                        @if( $numAnuncios> 0 )
                        <p class="text-left">Tienes {{ $numAnuncios }} anuncio(s) publicados</p>
                        @if ( $demandas->count()> 0 )
                        <h3 class="text-uppercase">Demandas</h3>
                        <div class="border rounded mt-2 p-0">
                            <div class="row border-bottom m-0 p-1 align-items-center">
                                <div class="col-1 text-center text-uppercase">id</div>
                                <div class="col-2 text-center text-uppercase">titulo</div>
                                <div class="col text-center text-uppercase">Descripción</div>
                                <div class="col-3 text-uppercase">opciones</div>
                            </div>
                            @foreach ($demandas as $demanda)
                            <div class="row w-100 m-0 p-2 align-items-center">
                                <div class="col-1 text-left"> {{ $demanda->id }}</div>
                                <div class="col-2 text-left"> {{ $demanda->titulo }}</div>
                                <div class="col text-left"> {{ $demanda->descripcion }}</div>
                                <div class="col-3 ">
                                    <div class="btn-group d-flex align-items-center">
                                        <?php $url = '/demandas/' . $demanda->id; ?>
                                        <a href="<?php echo $url; ?>" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver</a>
                                        <a href="{{route('user.anuncios-demanda.edit',['user'=>Auth::user()->id,'anuncios_demanda'=>$demanda->id] )}}" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Modificar</a>
                                        <form action="{{ route('user.anuncios-demanda.destroy', ['user'=>Auth::user()->id,'anuncios_demanda'=>$demanda->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <!-- botón para eliminar anuncio demanda -->
                                            <button type="submit" class="btn btn-sm btn-outline-secondary text-uppercase">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @if( $ofertas->count()> 0 )
                        <h3 class="text-uppercase mt-3">Ofertas</h3>
                        <div class="border rounded mt-2 p-0">
                            <div class="row border-bottom m-0 p-0 align-items-center">
                                <div class="col-1 border-right text-center text-uppercase">Id</div>
                                <div class="col-2 border-right text-center text-uppercase">Titulo</div>
                                <div class="col-1 border-right text-center text-uppercase">Foto</div>
                                <div class="col border-right text-center text-uppercase">Descripción</div>
                                <div class="col-3 border-left text-uppercase">opciones</div>
                            </div>
                            @foreach ($ofertas as $oferta)
                            <div class="row w-100 m-0 p-2 align-items-center">
                                <div class="col-1 text-left"> {{ $oferta->id }} </div>
                                <div class="col-2 text-left"> {{ $oferta->titulo }} </div>
                                <div class="col-1">
                                    <img  src="<?php echo ($oferta->fotos[0]->enlace); ?>" alt="{{ $oferta->titulo }}" style="height: 50px; width: 50px; display: block; object-fit: cover" data-holder-rendered="true">
                                </div>
                                <div class="col text-left"> {{ $oferta->descripcion }} </div>
                                <div class="col-3">
                                    <div class="btn-group d-flex align-items-center">
                                        <?php $url = '/ofertas/' . $oferta->id; ?>
                                        <a href="<?php echo $url; ?>" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver</a>
                                        <a href="{{route('user.anuncios-oferta.edit',['user'=>Auth::user()->id,'anuncios_ofertum'=>$oferta->id] )}}" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Modificar</a>
                                        <form action="{{ route('user.anuncios-oferta.destroy', ['user'=>Auth::user()->id,'anuncios_ofertum'=>$oferta->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <!-- botón para eliminar anuncio oferta -->
                                            <button type="submit" class="btn btn-sm btn-outline-secondary text-uppercase">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @else
                        <p>todavia no tienes anuncios publicados"</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
@endif
@endauth