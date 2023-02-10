<?php

namespace App\Http\Controllers\UserAnuncios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Anuncios;
use App\Models\AnunciosDemanda;
use App\Models\AnunciosOferta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
        $anuncios = Anuncios::where('id_usuario', $user_id)->get();
        // $count = DB::table('anuncios')->where('id_usuario',$user_id)->count();
        //$count = count($anuncios);
    //$count = $anuncios->count();
       
        $user = Auth::user()->name;
        $usersDemandas = AnunciosDemanda::where('id_usuario', $user_id)->get();
        $usersOfertas = AnunciosOferta::where('id_usuario', $user_id)->get();
        return view('user.anuncios', ['user' => $user, 'demandas'=>$usersDemandas, 'ofertas'=>$usersOfertas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoAnunc = 'oferta';
        $user_id = Auth::user()->id;
        return view('user.anuncCreate', ['user' => $user_id, 'tipoAnunc' => $tipoAnunc]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = "Ha producido un error, anuncio de demanda no creado";
        $user_id = $request->user_id;
        //insert validation of request
        /* $validarBase = $request->validate(
            [
                'titulo' => 'required|max:100',
                'descripcion' => 'required|max:300',
                'id_usuario' => 'required'
            ]

        );
        if ($validarBase && $request->tipo_anuncio == 'oferta') {
            //validate oferta
            $validarOfertaForm='...';
            //insert to database
            $message = 'Anuncio de oferta se ha publicado!';
        }else{
            $message = "Ha producido un error, anuncio de oferta no creado";
        } */

        if ($request->tipo_anuncio == 'demanda') {
            //demanda ya valida
            //insert to database 
            /* DB::table('anuncios')->insert([
                'id_usuario'=>Auth::user()->id,
                'estado' => 'active',
                'tipo' => 'demanda',  
            ]); */
            
            /**
             * Insert to database
             * Anuncio y anuncio Demanda tienen relacion uno a uno
             * 
             * @param Request $request
             * */
            DB::transaction(function () use ($request) {
                $anuncio = new Anuncios;
                $anuncio->id_usuario =$request->user_id;
                $anuncio->estado = 'active';
                $anuncio->tipo = 'demanda';
                $anuncio->save();
        //insert to table anuncio_demanda
                $anuncioDemanda = new AnunciosDemanda;
                $anuncioDemanda->id_anuncio = $anuncio->id;
                $anuncioDemanda->titulo = $request->input('titulo');
                $anuncioDemanda->descripcion = $request->input('descripcion');
                $anuncioDemanda->id_usuario = $request->user_id;
                
                $anuncioDemanda->save();
            });
            
            $message = 'Anuncio de demanda se ha publicado!';
        } else {
            $message = "Ha producido un error, anuncio de demanda no creado";
        }
        $user = Auth::user()->name;
        $anuncios = Anuncios::where('id_usuario', $user_id);
        $usersDemandas = AnunciosDemanda::where('id_usuario', $user_id);
        $usersOfertas = AnunciosOferta::where('id_usuario', $user_id);
        return Redirect::route('user.anuncios.index', ['user' => $user, 'demandas'=>$usersDemandas, 'ofertas'=>$usersOfertas,'status'=>$message]);
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
