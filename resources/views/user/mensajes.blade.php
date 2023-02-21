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
            {{ __('Mis mensajes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Mis mensajes') }}
                    </h2>
                    <div class="pt-3">
                        @if($dialogos == null)
                        <div class="text-center">todavia no tienes mensajes</div>
                        @else
                        <div>Tienes {{ count($dialogos) }} conversaciones</div>
                        @foreach($dialogos as $key=>$dialogo)
                        <div>
                            <!-- grupo de mensajes pertenecentes a un anuncio -->
                            <h1>anuncio id: {{ $key }}</h1>
                            @foreach($dialogo as $mensaje)
                            <p>{{ $mensaje->texto}}</p>
                            @endforeach
                        </div>
                        @endforeach
                        <div>
                            <?php $autor = Auth::user(); ?>
                            
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
@endauth