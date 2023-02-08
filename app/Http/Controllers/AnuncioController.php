<?php

/**
 * Anuncios controller
 * 
 * todos anuncios
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AnuncioOferta;
use App\Models\AnuncioDemanda;


class AnuncioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($area)
    {
        return view('of-lista', ['area'=>$area]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('anuncio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
        ]); */

        $entrada = $request->validate([
            /* 'user_id'=>'numeric|min:1',
            'cine_id'=> 'numeric|min:1',
            'fecha_id'=> 'min:1',
            'entradas'=>'required|numeric|max:10|min:1', */
            
        ]);
       
        AnuncioDemanda::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'id_usuario' => $request->id_usuario,
            'fecha' => date("H:i:s"),
            'tipo' => 'tipo-anuncio',
        ]);
        return redirect()->route('/dashboard'); // return redirect()->route('item.index');
        
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
        return view('anuncios.edit', ['anuncio'=>$id]);
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
        // aqui update db and redirect to usuarios area
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
