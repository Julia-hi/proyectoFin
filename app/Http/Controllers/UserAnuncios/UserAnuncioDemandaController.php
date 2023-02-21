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
        //insert validation of request
       
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
          //  $user = Auth::user()->name;
            
            // $anuncios = Anuncios::where('id_usuario', $user_id);
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
