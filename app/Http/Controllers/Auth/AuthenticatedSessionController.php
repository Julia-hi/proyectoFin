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
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            session()->put('user_id',$user->id);
            if ($user->rol === 'admin') {
                return redirect()->route('admin');
            } elseif ($user->rol === 'user') {
                return redirect()->route('dashboard',['user_id'=>$user->id, 'user'=>$user]);
            }
        };
    
            /* $request->authenticate();
            
            $request->session()->regenerate();
            session()->put('user_id',Auth::user()->id);
            $stat='ok';
            if (Auth::user()->rol =="admin") {
                
              return redirect()->route('admin');
            } elseif(Auth::user()->rol =="user") {
                
             // return redirect()->back()->with(['stat'=>$stat]);
             // return redirect()->route('/dashboard',['stat'=>$stat]);
             // return redirect()->route('user.anuncios.index',['user' =>Auth::user()->id, 'stat'=>$stat ]);
             return redirect('/dashboard');
            }  */
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
