<?php

namespace App\Http\Controllers\UserAnuncios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnuncioDemanda;
use App\Models\AnuncioOferta;
use App\Models\Anuncio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserAnuncioDemandaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // no tiene
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $tipoAnunc = 'demanda';
        return view('user.anuncCreateDemanda', ['user' => $user_id, 'tipoAnunc' => $tipoAnunc]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->user_id;
        //insert validation of request
        $validar = $request->validate(
            [
                'titulo' => 'required|min:10|max:100',
                'descripcion' => 'required|min:10|max:300'
            ]
        );
        if ($validar && $request->tipo_anuncio == 'demanda') {
            DB::transaction(function () use ($request) {
                $anuncio = new Anuncio;
                $anuncio->id_usuario = $request->user_id;
                $anuncio->estado = 'active';
                $anuncio->tipo = 'demanda';
                $anuncio->save();
                //insert to table anuncio_demanda
                $anuncioDemanda = new AnuncioDemanda;
                $anuncioDemanda->id_anuncio = $anuncio->id;
                $anuncioDemanda->titulo = $request->input('titulo');
                $anuncioDemanda->descripcion = $request->input('descripcion');
                $anuncioDemanda->id_usuario = $request->user_id;
                $anuncioDemanda->save();
            });
            $user = Auth::user()->name;
            $user_id = Auth::user()->id;
            // $anuncios = Anuncios::where('id_usuario', $user_id);
            $usersDemandas = AnuncioDemanda::where('id_usuario', $user_id);
            $usersOfertas = AnuncioOferta::where('id_usuario', $user_id);
            return Redirect::route('user.anuncios.index', ['user' => $user, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas, 'status' => 'ok']);   
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
        //
    }
}
