<?php

namespace App\Http\Controllers\UserAnuncios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Anuncio;
use App\Models\AnuncioDemanda;
use App\Models\AnuncioOferta;
use App\Models\User;

class UserAnunciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::find($id);
        if ($user->rol == "admin") {
            return redirect()->route('admin');
        } else {
            $usersDemandas = AnuncioDemanda::where('user_id', $id)->get();
            $usersOfertas = AnuncioOferta::where('user_id', $id)->get();
            return view('user.user-anuncios', ['user' => $user->name, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas]);
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
