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
        $usersDemandas = AnuncioDemanda::where('id_usuario', $id)->get();
        $usersOfertas= AnuncioOferta::where('id_usuario', $id)->get();
      //  $usersOfertas = AnuncioOferta::where('id_usuario', $user_id)->get();
      //$usersOfertas = Auth::user()->anunciosOferta();
     // $usersOfertas = Auth::user()->anunciosOferta();
      //  $usersOfertas = DB::table('anuncios_oferta')->where('id_usuario',$id)->get();
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
        /* $message = "Ha producido un error, anuncio de demanda no creado";
        $user_id = $request->user_id;
        //insert validation of request
        $validarBase = $request->validate(
            [
                'titulo' => 'required|string|min:10|max:100',
                'descripcion' => 'required|min:10|max:300'
            ]

        );

        if ($validarBase && $request->tipo_anuncio == 'demanda') {
           
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

            $message = 'Anuncio de demanda se ha publicado!';
            $user = Auth::user()->name;
            $anuncios = Anuncios::where('id_usuario', $user_id);
            $usersDemandas = AnuncioDemanda::where('id_usuario', $user_id);
            $usersOfertas = AnuncioOferta::where('id_usuario', $user_id);
            return Redirect::route('user.anuncios.index', ['user' => $user, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas, 'status' => $message]);
        } else {
            $message = "Ha producido un error, anuncio de demanda no creado";
            return view('user.anuncCreate', ['user' => $user_id, 'tipoAnunc' => 'demanda']);
        } */
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
