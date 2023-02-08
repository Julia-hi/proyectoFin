
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
                        if ($anuncios == "anuncios no encontrados") {
                            echo "todavia no tienes anuncios publicados";
                        } else {
                            echo "tienes " . count($anuncios) . " anuncios publicados";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
@endauth