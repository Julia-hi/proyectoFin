<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MiLorito') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('storage/css/mi_estilo.css')}}">
    <!-- Scripts  ,'resources/js/scripts/of-lista.js' -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Page Heading - resources/views/components/header.blade.php -->
    @if($status == 'ok')

    <head>
        <x-header />
    </head>
    <div class="min-h-screen bg-gray-100">
        @auth
        @if(Auth::user()->rol =="admin")
        @include('layouts.navigation-admin')
        @else
        <p>Accesso denegado.</p>
        @endif
        @endauth
        <!-- Page Content -->
        <main>
            <div class="container">
                <div class="justify-center px-6">
                    <div class="mt-4 p-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg" style="min-height:400px;">
                        <div id="ofertas_activas" class="p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Ofertas activas</h2>
                            @if($ofertasAct == null || $ofertasAct->count()==0 )
                            <p class="text-center">No encontrado ofertas activas.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border text-uppercase">ID anuncio</div>
                                <div class="col border text-uppercase">ID autor</div>
                                <div class="col border text-uppercase">Estado</div>
                                <div class="col border text-uppercase">Titulo</div>
                                <div class="col border text-uppercase">Publicado</div>
                                <div class="col border text-uppercase">Ultima modificación</div>
                                <div class="col border text-uppercase text-center">Acción</div>
                            </div>
                            @foreach($ofertasAct as $oferta)
                            <div class="row">
                                <div class="col border py-2 text-center" data-title="ver detalles"><a href="/admin/{{Auth::user()->id}}/anuncios/{{$oferta->id}}" class="border bg-success text-white p-2 rounded" style="width:50px;">{{$oferta->id}}</a></div>
                                <div class="col border py-2">{{$oferta->user_id}}</div>
                                <div class="col border py-2">{{$oferta->estado}}</div>
                                <div class="col border py-2">{{$oferta->anuncioOferta->titulo}}</div>
                                <div class="col border py-2">{{$oferta->created_at}}</div>
                                <div class="col border py-2">{{$oferta->updated_at}}</div>
                                <div class="col border text-center">
                                    <form method="post" action="{{ route('admin.anuncios.update', ['anuncio' => $oferta->id, 'admin' => Auth::user()->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="blocked">
                                        <input type="hidden" name="razon" value="desactivado - admin {{Auth::user()->id}}">
                                        <button type="submit" class="boton_bloq border bg-success text-white px-2 py-1 my-1 rounded w-75">desactivar</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                        <!--Demandas activadas -->
                        <div id="ofertas_noactivas" class="p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Demandas activadas</h2>
                            @if($demandasAct == null || $demandasAct->count()==0 )
                            <p class="text-center">No encontrado demandas activas.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border text-uppercase">ID anuncio</div>
                                <div class="col border text-uppercase">ID autor</div>
                                <div class="col border text-uppercase">Estado</div>
                                <div class="col border text-uppercase">Titulo</div>
                                <div class="col border text-uppercase">Publicado</div>
                                <div class="col border text-uppercase">Ultima modificación</div>
                                <div class="col border text-uppercase text-center">Acción</div>
                            </div>
                            @foreach($demandasAct as $demanda)
                            <div class="row">
                                <div class="col border py-2 text-center" data-title="ver detalles"><a href="/admin/{{Auth::user()->id}}/anuncios/{{$demanda->id}}" class="border bg-success text-white p-2 rounded" style="width:50px;">{{$demanda->id}}</a></div>
                                <div class="col border py-2">{{$demanda->user_id}}</div>
                                <div class="col border py-2">{{$demanda->estado}}</div>
                                <div class="col border py-2">{{$demanda->anuncioDemanda->titulo}}</div>
                                <div class="col border py-2">{{$demanda->created_at}}</div>
                                <div class="col border py-2">{{$demanda->updated_at}}</div>
                                <div class="col border text-center">
                                    <form method="post" action="{{ route('admin.anuncios.update', ['anuncio' => $demanda->id, 'admin' => Auth::user()->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="blocked">
                                        <input type="hidden" name="razon" value="desactivado - admin {{Auth::user()->id}}">
                                        <button type="submit" class="boton_bloq border bg-success text-white px-2 py-1 my-1 rounded w-75">desactivar</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <!-- Ofertas desactivadas -->
                        <div id="ofertas_noactivas" class="p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Ofertas desactivadas</h2>
                            @if($ofertasDesact ==null || $ofertasDesact->count()==0 )
                            <p class="text-center">No encontrado ofertas desactivadas.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border text-uppercase">ID anuncio</div>
                                <div class="col border text-uppercase">ID autor</div>
                                <div class="col border text-uppercase">Estado</div>
                                <div class="col border text-uppercase">Titulo</div>
                                <div class="col border text-uppercase">Publicado</div>
                                <div class="col border text-uppercase">Ultima modificación</div>
                                <div class="col border text-uppercase text-center">Acción</div>
                            </div>
                            @foreach($ofertasDesact as $oferta)
                            <div class="row">
                                <div class="col border py-2 text-center" data-title="ver detalles"><a href="/admin/{{Auth::user()->id}}/anuncios/{{$oferta->id}}" class="border bg-success text-white p-2 rounded" style="width:50px;">{{$oferta->id}}</a></div>
                                <div class="col border py-2 ">{{$oferta->user_id}}</div>
                                <div class="col border py-2">{{$oferta->estado}}</div>
                                <div class="col border py-2">{{$oferta->anuncioOferta->titulo}}</div>
                                <div class="col border py-2">{{$oferta->created_at}}</div>
                                <div class="col border py-2">{{$oferta->updated_at}}</div>
                                <div class="col border text-center">
                                    <form method="post" action="{{ route('admin.anuncios.update', ['anuncio' => $oferta->id, 'admin' => Auth::user()->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="active">
                                        <input type="hidden" name="razon" value="activado - admin {{Auth::user()->id}}">
                                        <button type="submit" class="boton_desbloq border bg-success text-white px-2 py-1 my-1 rounded w-75">activar</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <!-- Demandas desactivadas -->
                        <div id="ofertas_noactivas" class="p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Demandas desactivadas</h2>
                            @if($demandasDesact ==null || $demandasDesact->count()==0 )
                            <p class="text-center">No encontrado demandas desactivadas.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border text-uppercase">ID anuncio</div>
                                <div class="col border text-uppercase">ID autor</div>
                                <div class="col border text-uppercase">Estado</div>
                                <div class="col border text-uppercase">Titulo</div>
                                <div class="col border text-uppercase">Publicado</div>
                                <div class="col border text-uppercase">Ultima modificación</div>
                                <div class="col border text-uppercase text-center">Acción</div>
                            </div>
                            @foreach($demandasDesact as $demanda)
                            <div class="row">
                                <div class="col border py-2 text-center" data-title="ver detalles"><a href="/admin/{{Auth::user()->id}}/anuncios/{{$demanda->id}}" class="border bg-success text-white p-2 rounded" style="width:50px;">{{$demanda->id}}</a></div>
                                <div class="col border py-2">{{$demanda->user_id}}</div>
                                <div class="col border py-2">{{$demanda->estado}}</div>
                                <div class="col border py-2">{{$demanda->anuncioDemanda->titulo}}</div>
                                <div class="col border py-2">{{$demanda->created_at}}</div>
                                <div class="col border py-2">{{$demanda->updated_at}}</div>
                                <div class="col border py-2 text-center">
                                    <form method="post" action="{{ route('admin.anuncios.update', ['anuncio' => $demanda->id, 'admin' => Auth::user()->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="active">
                                        <input type="hidden" name="razon" value="activado - admin {{Auth::user()->id}}">
                                        <button type="submit" class="boton_desbloq border bg-success text-white px-2 py-1 my-1 rounded w-75">activar</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @else
    <div>
        <h2>AREA DE ADMINISTRADOR</h2>
        <p>Accesso denegado.</p>
    </div>
    @endif
    <script src="{{asset('storage/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('storage/js/sweetalert2.all.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.boton_bloq').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estas seguro?',
                    icon: 'warning',
                    iconColor: '#FC4B3B',
                    showCancelButton: true,
                    confirmButtonColor: '#76A728',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, bloquear!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // se envia la peticion si usuario ha confirmado
                        $(event.target).closest('form').submit();
                    }
                });
            });
            $('.boton_desbloq').on('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estas seguro?',
                    icon: 'warning',
                    iconColor: '#FC4B3B',
                    showCancelButton: true,
                    confirmButtonColor: '#76A728',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, desbloquear!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // se envia la peticion si usuario ha confirmado
                        $(event.target).closest('form').submit();
                    }
                });
            });
        });
    </script>
</body>