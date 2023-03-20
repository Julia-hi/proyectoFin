<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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
        @include('layouts.navigation-admin')
        @endauth
        <!-- Page Content -->
        <main>
            <div class="container">
                <div class="justify-center px-6">
                    <div class="mt-4 p-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg" style="min-height:400px;">
                        <!-- data del usuario -->
                        <div id="usuar_act" class="p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Usuario ID: {{$user->id}}</h2>
                            <div class="row">
                                <!-- Información del registro -->
                                <div class="col-lg-4 col-md-6">
                                    <ul>
                                        <li><b>Nombre</b>: {{$user->name}}</li>
                                        <li><b>Email</b>: {{$user->email}}</li>
                                        <li><b>Telefono</b>: {{$user->telefono}}</li>
                                        <li><b>Estado de cuenta</b>: {{$user->estado}}</li>
                                        <li><b>Registrado</b>: {{$user->created_at}}</li>
                                        @if($user->created_at != $user->updated_at)
                                        <li> <b>Modificado</b>: {{$user->updated_at}} </li>
                                        @else
                                        <li>Cuenta aún sin cambios.</li>
                                        @endif
                                    </ul>
                                </div>
                                <!-- Información sobre anuncios -->
                                <div class="col">
                                    <div>
                                        @if($anuncios==null || $anuncios->count()==0)
                                        <p>No tiene anuncios publicados</p>
                                        @else
                                        <h3 class="text-success mt-2">Anuncios publicados:</h3>
                                        <ul>
                                            @foreach($anuncios as $anuncio)
                                            <li><b>{{$anuncio->id}}</b>: Anuncio {{$anuncio->tipo}}, <b>estado:</b> {{$anuncio->estado}}, <b>estado:</b> {{$anuncio->estado}},<b>publicado:</b> {{$anuncio->created_at}}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div>
                                        @if($mensajes==null || $mensajes->count()==0)
                                        <p>No tiene mensajes enviados</p>
                                        @else
                                        <h3 class="text-success mt-2">Mensajes enviados por usuario:</h3>
                                        <ol>
                                            @foreach($mensajes as $ind=>$mensaje)
                                            <li class="border"><b>{{$ind+1}}. ID</b>: {{$mensaje->id}}, <b>Enviado a</b>: {{$mensaje->recipiente_id}} {{$mensaje->created_at}}
                                                <br><span class="mx-4"><b>Texto</b>: {{$mensaje->texto}}</span>
                                            </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-4">
                                            <div class="border border-3 border-success text-success px-2 py-1 my-1 rounded w-75 text-center text-uppercase"><a href="{{route('admin.users.index',$user->id)}}"><b>volver</b></a></div>
                                        </div>
                                        <div class="col-4">
                                            @if($user->estado=='blocked')
                                            <form method="post" action="{{ route('admin.users.update', ['user' => $user->id, 'admin' => Auth::user()->id]) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="estado" value="active">
                                                <input type="hidden" name="razon" value="desbloquado - admin {{Auth::user()->id}}">
                                                <button class="boton_desbloq border bg-success text-white px-2 py-1 my-1 rounded w-75 text-uppercase" type="submit">desbloquear</button>
                                            </form>
                                            @else
                                            <form method="post" action="{{ route('admin.users.update', ['user' => $user->id, 'admin' => Auth::user()->id]) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="estado" value="blocked">
                                                <input type="hidden" name="razon" value="desbloquado - admin {{Auth::user()->id}}">
                                                <button class="boton_bloq border bg-success text-white px-2 py-1 my-1 rounded w-75 text-uppercase" type="submit">bloquear</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
            //evento para confirmar bloqueo al pulsar boton bloquear
            $('.boton_bloq').on('click', function(event) {
                event.preventDefault(); 
                Swal.fire({
                    title: '¿Estas seguro?',
                    icon: 'warning',
                    iconColor:'#FC4B3B' ,
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
            //evento para confirmar desbloqueo al pulsar boton desbloquear
            $('.boton_desbloq').on('click', function(event) {
                event.preventDefault(); 
                Swal.fire({
                    title: '¿Estas seguro?',
                    icon: 'warning',
                    iconColor:'#FC4B3B' ,
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

</html>