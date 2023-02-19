<?php

namespace App\Http\Controllers\UserAnuncios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Anuncio;
use App\Models\AnuncioDemanda;
use App\Models\AnuncioOferta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserAnunciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $usersDemandas = AnuncioDemanda::where('user_id', Auth::user()->id)->get();
        $usersOfertas= AnuncioOferta::where('user_id', Auth::user()->id)->get();
    
        return view('user.user-anuncios', ['user' => Auth::user()->name, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //anuncios se crean por separado 

       /*  if (!isset($tipoAnunc)) {
            $tipoAnunc = 'oferta';
        }else{
            $tipoAnunc = 'demanda';
        }

        $user_id = Auth::user()->id;
        return view('user.anuncCreate', ['user' => $user_id, 'tipoAnunc' => $tipoAnunc]); */
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
