<?php

namespace App\Http\Controllers\UserAnuncios;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnuncioDemanda;
use App\Models\AnuncioOferta;
use App\Models\Anuncio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserAnuncioOfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // no tiene index
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user_id = Auth::user()->id;
        $tipoAnunc = 'oferta';
        return view('user.anuncCreateOferta', ['user' => $user_id, 'tipoAnunc' => $tipoAnunc]);
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
                'descripcion' => 'required|min:10|max:300',
                'rasa' => 'required',
                'genero' => 'required',
                'fecha_nac' => 'required|date',
                'comunidad' => 'required|not_regex:/^todo$/',
                'provincia' => 'required|not_regex:/^todo$/',
                'poblacion' => 'required|not_regex:/^todo$/',
                'lat' => 'required',
                'lon' => 'required',
                'foto1' => 'required|image',
                'foto2' => 'image',
                'foto3' => 'image',
                'foto4' => 'image',
                'foto5' => 'image'
            ]
        );
        $comunidades = ['andalucia', 'aragon','asturias','canarias','cantabria','castilla-la-mancha','castila-leon'];
        
       
        if ($validar && $request->tipo_anuncio == 'oferta') {
            DB::transaction(function () use ($request) {
                $anuncio = new Anuncio;
                $anuncio->id_usuario = $request->user_id;
                $anuncio->estado = 'active';
                $anuncio->tipo = 'demanda';
                $anuncio->save();
                //insert to table anuncio_demanda
                $anuncioOferta = new AnuncioOferta;
                $anuncioOferta->id_anuncio = $anuncio->id;
                $anuncioOferta->titulo = $request->input('titulo');
                $anuncioOferta->descripcion = $request->input('descripcion');
                $anuncioOferta->id_usuario = $request->user_id;
                $anuncioOferta->save();
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
