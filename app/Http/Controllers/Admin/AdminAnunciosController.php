<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Anuncio;
use Illuminate\Support\Facades\Auth;
use App\Models\AnuncioOferta;
use App\Models\AnuncioDemanda;

class AdminAnunciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //todos anuncios de oferta activos
        $ofertasActive = Anuncio::where('tipo','oferta')->where('estado','active')->get();
        //todos anuncios de oferta desactivados
        $ofertasNoActive = Anuncio::where('tipo','oferta')->where('estado','inactive')->get();

        //anuncios de demanda activos
        $demandasActive = Anuncio::where('tipo','demanda')->where('estado','active')->get();
        //todos anuncios de demanda desactivados
        $ofertasNoActive = Anuncio::where('tipo','demanda')->where('estado','inactive')->get();

        if (Auth::check() && Auth::user()->rol=="admin") {
            $status = 'ok';
        } else {
            $status = 'error';
        } 
        return view('admin/admin_anuncios', ['status'=>$status,'ofertasAct'=>$ofertasActive, 'ofertasDesact'=>$ofertasNoActive, 'demandasAct'=> $demandasActive,'demandasDesact'=>$ofertasNoActive]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
