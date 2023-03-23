<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login')->with(['stat'=>'ok']);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        
            $request->authenticate();
            $request->session()->regenerate();
            if (Auth::user()->rol =="admin") {
                $stat = 'ok';
              return redirect()->route('admin',['stat'=>$stat]);
            } elseif(Auth::user()->rol =="user") {
                $stat = 'ok';
              return redirect()->back()->with(['stat'=>$stat]);
              //return redirect()->route('dashboard',['stat'=>$stat]);
             // return redirect()->route('user.anuncios.index',['user' =>Auth::user()->id, 'stat'=>$stat ]);
            }else{
                $stat = 'error';
                return redirect('/')->with(['stat'=>$stat]);
            }  
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
