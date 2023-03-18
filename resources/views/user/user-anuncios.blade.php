<!-- Esta pagina puede ver solo usuario con rol "user" -->
@auth
@if(Auth::user()->rol=="admin")
<?php
return redirect()->route('admin', Auth::user()->id);
?>
@else
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis anuncios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-yellow overflow-hidden shadow-sm sm:rounded-lg" style="min-height:500px;">
                <div class="p-6 text-center">
                    <div class="w-100 row d-flex justify-content-center align-content-center mb-2">
                        <button class="green-brillante-boton w-50 text-uppercase" onclick="window.location='{{ '/'}}';">a la pagina principal</button>
                    </div>
                    <h2 class="h3 text-uppercase mt-4">Mis anucios</h2>
                    <div class="pt-3">
                        <?php
                        $numAnuncios = $demandas->count() + $ofertas->count(); ?>
                        @if( $numAnuncios> 0 )
                        <p class="text-left">Tienes {{ $numAnuncios }} anuncio(s) publicados</p>
                        @if ( $demandas->count()> 0 )
                        <h3 class="text-uppercase">Demandas</h3>
                        <div class="border rounded mt-2 p-0 bg-white">
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
                                        <a href="<?php echo $url; ?>" role="button" class="btn btn-sm btn-outline-success text-uppercase"><b>Ver</b></a>
                                        <a href="{{route('user.anuncios-demanda.edit',['user'=>Auth::user()->id,'anuncios_demanda'=>$demanda->id] )}}" role="button" class="modificar_anuncio btn btn-sm btn-outline-warning text-uppercase"><b>Modificar</b></a>
                                        <form action="{{ route('user.anuncios-demanda.destroy', ['user'=>Auth::user()->id,'anuncios_demanda'=>$demanda->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <!-- botón para eliminar anuncio demanda -->
                                            <button type="submit" class="eliminar_anuncio btn btn-sm btn-outline-danger text-uppercase">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @if( $ofertas->count()> 0 )
                        <h3 class="text-uppercase mt-3">Ofertas</h3>
                        <div class="border border-green rounded mt-2 p-0 bg-white">
                            <div class="row border-bottom m-0 py-1 bg-green text-white align-items-center">
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
                                    <img src="<?php echo ($oferta->fotos[0]->enlace); ?>" alt="{{ $oferta->titulo }}" style="height: 50px; width: 50px; display: block; object-fit: cover" data-holder-rendered="true">
                                </div>
                                <div class="col text-left"> {{ $oferta->descripcion }} </div>
                                <div class="col-3">
                                    <div class="btn-group d-flex align-items-center">
                                        <?php $url = '/ofertas/' . $oferta->id; ?>
                                        <a href="<?php echo $url; ?>" role="button" class="btn btn-sm btn-outline-success text-uppercase"><b>Ver</b></a>
                                        <a href="{{route('user.anuncios-oferta.edit',['user'=>Auth::user()->id,'anuncios_ofertum'=>$oferta->id] )}}" role="button" class="modificar_anuncio btn btn-sm btn-outline-warning text-uppercase"><b>Modificar</b></a>
                                        <form action="{{ route('user.anuncios-oferta.destroy', ['user'=>Auth::user()->id,'anuncios_ofertum'=>$oferta->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <!-- botón para eliminar anuncio oferta -->
                                            <button type="submit" class="eliminar_anuncio btn btn-sm btn-outline-danger text-uppercase"><b>Eliminar</b></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @else
                        <p>todavia no tienes anuncios publicados"</p>
                        <div class="w-100 d-flex justify-content-center mt-4">
                            <img class="w-25" src="{{asset('storage/images/periquitos.png')}}" alt="">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
        <script>
            $(document).ready(function() {
                $('.eliminar_anuncio').on('click', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: '¿Estas seguro?',
                        text: 'Anuncio y fotos serán eliminado permanente, no podrás restaurar.',
                        icon: 'warning',
                        iconColor: '#FC4B3B',
                        showCancelButton: true,
                        confirmButtonColor: '#76A728',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Eliminar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // se envia la peticion si usuario ha confirmado
                            $(event.target).closest('form').submit();
                        }
                    });
                });
            });
        </script>
</x-app-layout>
@endif
@endauth