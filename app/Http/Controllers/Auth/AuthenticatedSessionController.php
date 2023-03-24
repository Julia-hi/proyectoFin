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
            session('user_id')->put('user_id',Auth::user()->id);
            $stat='ok';
            if (Auth::user()->rol =="admin") {
                
              return redirect()->route('admin');
            } elseif(Auth::user()->rol =="user") {
                
             // return redirect()->back()->with(['stat'=>$stat]);
             // return redirect()->route('/dashboard',['stat'=>$stat]);
             // return redirect()->route('user.anuncios.index',['user' =>Auth::user()->id, 'stat'=>$stat ]);
             return redirect('/dashboard');
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
