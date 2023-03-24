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
    { //echo "user id ".$id;
        //echo "<br>Autenticated user: ".Auth::user()->id;
        if (Auth::user()->rol == "admin") {
            return redirect()->route('admin');
        } else {
            $usersDemandas = AnuncioDemanda::where('user_id', Auth::user()->id)->get();
            $usersOfertas = AnuncioOferta::where('user_id', Auth::user()->id)->get();
            return view('user.user-anuncios', ['user' => Auth::user()->id, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anuncio = Anuncio::where('id', $id);
        if ($anuncio->tipo == "oferta") {
            return view('user.anuncUpdateOferta', ['user' => $id, 'tipoAnunc' => 'oferta']);
        } elseif ($anuncio->tipo == "demanda") {
            return view('user.anuncUpdateDemanda', ['user' => $id, 'tipoAnunc' => 'demanda']);
        }
    }

}
