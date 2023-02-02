<?php 
use \Illuminate\Http\RedirectResponse; ?>
//@extends('layouts.app')
@auth
    @if(Auth::user()->rol=="admin")
       <!--  <a class="nav-link" href="{{ url('/home') }}">Panel de admin</a> -->
        <?php echo "I am admin"; 
         ?>
                     
    @endif
@endauth


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <p>panel de admin</p>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->

                </div>
            </div>
        </div>
    </div>
</div>
