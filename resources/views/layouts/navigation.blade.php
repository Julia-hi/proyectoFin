<?php $user_id = Auth::user()->id; ?>
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('user.anuncios.index',$user_id)" :active="request()->routeIs('user.anuncios.index',$user_id)">
                    <img src="<?php echo Storage::url('images/icons/receipt-solid.svg');?>" style="width:1em;" class="mr-2">
                    {{ __('Mis anuncios') }}
                    </x-nav-link>
                    <x-nav-link :href="route('user.favoritos.index', $user_id)" :active="request()->routeIs('user.favoritos.index',$user_id)">
                        <img src="<?php echo Storage::url('images/icons/heart-solid.svg');?>" style="width:1em;" class="mr-2">
                        {{ __('Mis favoritos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('user.mensajes.index', $user_id)" :active="request()->routeIs('user.mensajes.index',$user_id)">
                    <img src="<?php echo Storage::url('images/icons/comment-regular.svg');?>" style="width:1em;" class="mr-2">
                    {{ __('Mensajes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('user.anuncios-oferta.create', $user_id)" :active="request()->routeIs('user.anuncios-oferta.create', $user_id)">
                    <img src="<?php echo Storage::url('images/icons/bullhorn-solid.svg');?>" style="width:1em;" class="mr-2">
                    {{ __('Publicar anuncio') }}
                    </x-nav-link>
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    <img src="<?php echo Storage::url('images/icons/user-regular.svg');?>" style="width:1em;" class="mr-2">
                        {{ __('Perfil') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content" >
                        <x-dropdown-link :href="route('user.anuncios.index',$user_id)">
                            {{ __('Mis anuncios') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('user.favoritos.index', $user_id)">
                            {{ __('Mis favoritos') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('user.mensajes.index', $user_id)">
                            {{ __('Mis mensajes') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('user.anuncios-oferta.create', $user_id)">
                            {{ __('Publicar anuncio') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar sesion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Mi cuenta') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('user.anuncios.index',$user_id)">
                    {{ __('Mis anuncioso') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.favoritos.index', $user_id)">
                    {{ __('Mis favoritos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.mensajes.index', $user_id)">
                    {{ __('Mis mensajes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.anuncios-oferta.create', $user_id)">
                    {{ __('Publicar anuncio') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>