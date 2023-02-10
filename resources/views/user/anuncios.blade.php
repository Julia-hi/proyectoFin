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
                        $numAnuncios = 0;
                        if ($demandas != null) {
                            $numAnuncios = $numAnuncios + $demandas->count();
                        } elseif ($ofertas != null) {
                            $numAnuncios = $numAnuncios + $ofertas->count();
                        } ?>
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
                                        <a href="#" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Ver</a>
                                        <a href="#" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Modificar</a>
                                        <a href="#" role="button" class="btn btn-sm btn-outline-secondary text-uppercase">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @elseif( $ofertas->count()> 0 )
                        <h3>Ofertas</h3>
                        @endif
                        @else
                        <p>todavia no tienes anuncios publicados"</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
@endauth