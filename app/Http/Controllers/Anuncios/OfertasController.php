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
use App\Models\Anuncio;
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
            //obtener anuncios oferta demanda no bloqueados
            $anuncOfertas = Anuncio::where('tipo', 'oferta')->where('estado', 'active')
                ->whereHas('autor', function ($query) {
                    $query->where('estado', 'active');
                })->limit(12)->get();
            $ofertas = collect([]);
            foreach ($anuncOfertas as $anuncio) {
                if ($anuncio->anuncioOferta) {
                    $ofertas->push($anuncio->anuncioOferta);
                }
            }
            if ($ofertas->count < 10) {
                $ofertas = "ofertas not found";
            }
            $status = "ok";
        } catch (Exception $ex) {
            $status = "error";
        }
        return view('ofertas-lista', ['ofertas' => $ofertas, 'stat' => $status]);
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
        return view('anuncio.anunc-oferta', ['oferta' => $oferta, 'autor' => $autor, 'fotos' => $fotos, 'stat' => 'ok']);
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
