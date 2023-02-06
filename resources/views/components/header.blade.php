<?php

use Illuminate\Support\Facades\Storage;
?>
<div class="bg-white shadow" style="background-image: url('<?php $fondo =Storage::url('images/johas-fondo.svg'); echo($fondo); ?>'); ">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="/">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    @auth
                    <!-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Mis anuncios') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Mis favoritos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Mensajes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('anuncio.create')" :active="request()->routeIs('dashboard')">
                        {{ __('Publicar anuncio') }}
                    </x-nav-link>
                </div> -->
                    @endauth
                </div>


            </div>
        </div>
    </div>
</div>