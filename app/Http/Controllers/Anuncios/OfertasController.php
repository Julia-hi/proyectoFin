<?php

/**
 * Ofertas controller
 * 
 * anuncios de oferta
 */

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnuncioOferta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OfertasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if ($ofertas = AnuncioOferta::get()) {
            } else {
                $ofertas = "ofertas not found";
            }
            $status = "ok";
        } catch (Exeption $ex) {
            $status = "error";
        }
        return view('ofertas-lista', ['ofertas' => $ofertas, 'status' => $status]);
    }

    public function filter(Request $request)
    {
        // var_dump($request->input('comunidad'));
        //ofertas?comunidad=andalucia&provincia=todo&raza=todos&sexo=todos
        $valores = $request;
        // $valores = $this->getParametrosQuery();
        $ofertas = AnuncioOferta::get();
        $count =  $ofertas->count();
        if ($count > 0) {
            if ($request->input('comunidad') != "todo") {
                if ($valores['provincia'] != "todo") {
                    if ($request->input('poblacion') != "todo") {
                        $ofertas = AnuncioOferta::where('comunidad', $request->input('comunidad'))->where('provincia', $valores['provincia'])
                            ->where('poblacion', $valores['poblacion']);
                    }
                    $ofertas = AnuncioOferta::where('comunidad', $valores['comunidad'])->where('provincia', $valores['provincia']);
                }
                $ofertas = AnuncioOferta::where('comunidad', $request->input('comunidad'))->get();
            } else {
                $ofertas = AnuncioOferta::where('raza', $request->input('raza'))->where('genero', $request->input('sexo'))->get();
            }
        } else {
            $ofertas = "ofertas not found";
        }

        return view('ofertas-lista', ['count' => $count, 'ofertas' => $ofertas, 'status' => "ok"]);
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
        if ($oferta = AnuncioOferta::find($id)) {
            $fotos = $oferta->fotos;
            $autor = $oferta->autor;
        } else {
            $oferta = null;
            $fotos = null;
        }


        // $oferta['autor'] =  $autor->name;

        return view('anuncio.anunc-oferta', ['oferta' => $oferta, 'autor' => $autor, 'fotos' => $fotos, 'status' => 'ok']);
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
            $valores['provincia'] = $_POST['provincia'];
        } else {
            $valore['provincia'] = "todo";
        }
        if (isset($_POST['poblacion'])) {
            $valores['poblacion'] = $_POST['poblacion'];
        } else {
            $valores['poblacion'] = "todo";
        }
        return $valores;
    }
}
