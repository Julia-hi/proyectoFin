<?php

/**
 * Ofertas controller
 * 
 * anuncios de oferta
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnuncioOferta;
use Illuminate\Support\Facades\DB;

class OfertasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $valores = $this->getParametrosQuery();
        $count = DB::table('anuncio_ofertas')->count();
        if (DB::table('anuncio_ofertas')->count() > 0) {
            if ($valores['comunidad'] != "todo") {
                $ofertas = DB::table('anuncio_ofertas')->where('comunidad', $valores['comunidad']);
            } else {
                $ofertas = DB::table('anuncio_ofertas')->simplePaginate(2);
            }
        } else {
            $ofertas = "ofertas not found";
        }
        // $ofertas=AnuncioOferta::all();
        return view('ofertas-lista', ['count' => $count, 'ofertas' => $ofertas]); //),$ofertas); //return view('ofertas-lista', $ofertas);
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

    function getParametrosQuery()
    {
        if (isset($_POST['comunidad'])) {
            $valores['comunidad'] = $_POST['comunidad'];
        } else {
            $valores['comunidad'] = "todo";
        }
        if (isset($_POST['provincia'])) {
            $provincia = $_POST['provincia'];
        } else {
            $provincia = "todo";
        }
        if (isset($_POST['poblacion'])) {
            $poblacion = $_POST['poblacion'];
        } else {
            $poblacion = "todo";
        }
        return $valores;
    }
}