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
        $user = Auth::user();

        if ($request->tipo_anuncio == 'demanda') {
            $entrada = $request->validate(
                [
                    'titulo' => 'required|min:10|max:100',
                    'descripcion' => 'required|min:10|max:300'
                ]
            );
            $entrada['user_id'] = $user->id;
            $entrada['estado'] = 'active';
            $entrada['tipo'] = 'demanda';
            Anuncio::create($entrada); // insertar anuncio en la tabla 'anuncios'
            $ult_anuncio = DB::table('anuncios')->latest()->first();
            $entrada['id'] = $ult_anuncio->id;

            AnuncioDemanda::create($entrada); // insert to database - tabla "anuncios_odemanda"
            
            $usersDemandas = AnuncioDemanda::where('user_id', $user->id);
            $usersOfertas = AnuncioOferta::where('user_id', $user->id);
            return Redirect::route('user.anuncios.index', ['user' => $user->name, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas, 'status' => 'ok']);
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
     * @param  int  $id_anuncio
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $id_anuncio)
    {
        $anuncio = AnuncioDemanda::find($id_anuncio);

        return view('user.anuncEditDemanda', ['user' => Auth::user()->id, 'anuncios_demanda' => $id, 'anuncio' => $anuncio]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $id_anuncio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id_anuncio)
    {
        $demanda = AnuncioDemanda::find($id_anuncio);
        if ($request->tipo_anuncio == 'demanda') {
            $entrada = $request->validate(
                [
                    'titulo' => 'required|min:10|max:100',
                    'descripcion' => 'required|min:10|max:300'
                ]
            );
            $demanda->titulo = $request->titulo;
            $demanda->descripcion = $request->descripcion;
            $demanda->save();

            return Redirect::route('user.anuncios.index', ['user' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  int  $id_anuncio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id_anuncio)
    {
        $demanda = AnuncioDemanda::find($id_anuncio);
        $demanda->delete();
        return Redirect::route('user.anuncios.index', ['user' => $id]);
    }
}
