<?php

use Illuminate\Support\Facades\Storage;
?>
<div class="bg-white shadow" style="background-image: url('<?php $fondo =Storage::url('images/hojas-fondo.svg'); echo($fondo); ?>'); ">
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
                   
                </div>


            </div>
        </div>
    </div>
</div>