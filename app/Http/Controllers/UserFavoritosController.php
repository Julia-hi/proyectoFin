<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;
use App\Models\AnuncioOferta;

class UserFavoritosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $favoritos = Favorito::where('id_usuario', $user_id)->get();
        // $count = DB::table('anuncios')->where('id_usuario',$user_id)->count();
        //$count = count($anuncios);
        $count = Favorito::where('id_usuario', $user_id)->count();
        if ($count > 0) {
            $favoritos = Favorito::where('id_usuario', $user_id)->get();
            /* foreach($favoritos as $fav){
                $fav->anuncio->titulo;
            } */
        } else {
            $favoritos = "favoritos no encontrados";
        }
        $user = Auth::user()->name;
        return view('user.favoritos', ['user' => $user, 'anuncios' => $favoritos]);
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
        $entrada['id_usuario'] = Auth::user();
        $entrada['id_anuncio'] = $request->id_anuncio;
        //consultar la base de datos si existe anuncio
        $anuncio = AnuncioOferta::where('id', $request->id_anuncio)->get();
        if ($anuncio != null) {
            Favorito::create($entrada); // insert to database - tabla "favoritos"
        }
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
    public function destroy($id)
    {
        $favorito=Favorito::find($id)->get();
        $favorito->forceDelete();
    }
}
