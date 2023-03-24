<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;
use App\Models\Anuncio;
use App\Models\User;


class UserFavoritosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::find($user_id);
        if (Auth::user()->rol == "admin") {
            return redirect()->route('admin');
        } else {
            $favoritos = Favorito::where('user_id', $user_id)->get();
            if ($favoritos->count() < 1) {
                $favoritos = null; // no encontrado favoritos
            }
           // $user = Auth::user()->name;
            return view('user.favoritos', ['user' => $user, 'favoritos' => $favoritos,'user_id'=>$user_id]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $entrada['user_id'] = Auth::user()->id;
        $entrada['anuncio_id'] = $request->anuncio_id;
        //consultar la base de datos si existe anuncio
        $anuncio = Anuncio::where('id', $request->anuncio_id)->get();
        if ($anuncio->count() > 0) {
            Favorito::create($entrada); // insert to database - tabla "favoritos"  
        }
        return back()->with(['user' => $user, 'user_id'=>$user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Favorito $favorito)
    {
        
        $favorito->delete();
        return back()->with(['user_id'=>$user->id]);
    }
}
