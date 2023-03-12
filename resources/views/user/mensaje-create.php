<?php ?>

<h3>Enviar mensaje a {{ $autor->name }}</h3>
<form method="POST" action="{{ route('user.mensajes.store',$autor->id) }}">
    @csrf
    <x-input-label for="mensaje" :value="__('Texto')" />
    <textarea class="form-control" id="mensaje" rows="10" name="texto"></textarea>
    <x-input-error :messages="$errors->get('texto')" class="mt-2" />
    <input hidden name="anuncio_id" type="text" value="{{ $oferta->id }}" />
    <input hidden name="remitente_id" type="text" value="{{ Auth::user()->id }}" />
    <div class="d-flex items-center justify-content-between my-4">
        <x-primary-button class="ml-3">
            {{ __('Enviar') }}
        </x-primary-button>
    </div>
</form>