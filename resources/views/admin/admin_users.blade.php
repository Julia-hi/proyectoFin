<?php
if(Auth::user()->rol =='admin'){
    $stat='ok';
}else{
    $stat = 'error';
} ?>

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
    @if($stat == 'ok')

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
                        <!-- Usuarios activos -->
                        <div id="usuar_act" class="p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Usuarios activados</h2>
                            @if($usAct ==null || $usAct->count()==0 )
                            <p class="text-center">No encontrado usuarios activados.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border text-uppercase">ID usuario</div>
                                <div class="col border text-uppercase">Nombre</div>
                                <div class="col border text-uppercase">Email</div>
                                <div class="col border text-uppercase">Telefono</div>
                                <div class="col border text-uppercase">Registrado</div>
                                <div class="col border text-uppercase">Ultima modificación</div>
                                <div class="col border text-uppercase text-center">Acción</div>
                            </div>
                            @foreach($usAct as $user)
                            <div class="row">
                                <div class="col border py-2 text-center" data-title="ver detalles"><a href="/admin/{{Auth::user()->id}}/users/{{$user->id}}" class="border bg-success text-white p-2 rounded" style="width:50px;">{{$user->id}}</a></div>
                                <div class="col border py-2">{{$user->name}}</div>
                                <div class="col border py-2">{{$user->email}}</div>
                                <div class="col border py-2">{{$user->telefono}}</div>
                                <div class="col border py-2">{{$user->created_at}}</div>
                                <div class="col border py-2">{{$user->updated_at}}</div>
                                <div class="col border py-2 text-center">
                                    <form method="post" action="{{ route('admin.users.update', ['user' => $user->id, 'admin' => Auth::user()->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="blocked">
                                        <input type="hidden" name="razon" value="activado - admin {{Auth::user()->id}}">
                                        <button type="submit" class="boton_bloq border bg-success text-white px-2 py-1 my-1 rounded w-75">bloquear</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <!-- Usuarios bloqueados -->
                        <div id="usuar_act" class="p-3">
                            <h2 class="text-center py-2 text-uppercase fs-4">Usuarios bloqueados</h2>
                            @if($usBloq ==null || $usBloq->count()==0 )
                            <p class="text-center">No encontrado usuarios bloqueados.</p>
                            @else
                            <div class="row bg-success text-white">
                                <div class="col border text-uppercase">ID usuario</div>
                                <div class="col border text-uppercase">Nombre</div>
                                <div class="col border text-uppercase">Email</div>
                                <div class="col border text-uppercase">Telefono</div>
                                <div class="col border text-uppercase">Registrado</div>
                                <div class="col border text-uppercase">Ultima modificación</div>
                                <div class="col border text-uppercase text-center">Acción</div>
                            </div>
                            @foreach($usBloq as $user)
                            <div class="row">
                                <div class="col border py-2 text-center" data-title="ver detalles"><a href="/admin/{{Auth::user()->id}}/users/{{$user->id}}" class="border bg-success text-white p-2 rounded">{{$user->id}}</a></div>
                                <div class="col border py-2">{{$user->name}}</div>
                                <div class="col border py-2">{{$user->email}}</div>
                                <div class="col border py-2">{{$user->telefono}}</div>
                                <div class="col border py-2">{{$user->created_at}}</div>
                                <div class="col border py-2">{{$user->updated_at}}</div>
                                <div class="col border py-2 text-center">
                                    <form method="post" action="{{ route('admin.users.update', ['user' => $user->id, 'admin' => Auth::user()->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="active">
                                        <input type="hidden" name="razon" value="desbloquado - admin {{Auth::user()->id}}">
                                        <button class="boton_desbloq border bg-success text-white px-2 py-1 my-1 rounded w-75" type="submit">desbloquear</button>
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
            //evento para confirmar bloqueo al pulsar boton bloquear
            $('.boton_desbloq').on('click', function(event) {
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