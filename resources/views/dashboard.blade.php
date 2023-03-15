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
            {{ __('Area personal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-center">Hola, {{ Auth::user()->name }}!</p>
                    <p>Aqui puedes publicar nuevos anuncios gestionar tus anuncios, ver lista de tus favoritos,
                         enviar mensajes y gestionar tu perfil.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
@endauth