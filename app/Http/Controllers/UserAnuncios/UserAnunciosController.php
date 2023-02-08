<?php

namespace App\Http\Controllers\UserAnuncios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Anuncio;
use Illuminate\Support\Facades\DB;

class UserAnunciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user)
    {
        $user_id = Auth::user()->id;
        $anuncios = Anuncio::where('id_usuario', $user_id)->get();
       // $count = DB::table('anuncios')->where('id_usuario',$user_id)->count();
       //$count = count($anuncios);
       $count=Anuncio::where('id_usuario', $user_id)->count();
        if ($count > 0) {
                $anuncios = DB::table('anuncios')->where('id_usuario',$user_id);
            } else {
            $anuncios = "anuncios no encontrados";
        }
        $user = Auth::user()->name;
        return view('user.anuncios', ['user' => $user, 'anuncios'=>$anuncios]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoAnunc = 'oferta';
        $user = Auth::user()->name;
        return view('user.anuncCreate', ['user' => $user,'tipoAnunc'=>$tipoAnunc]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
