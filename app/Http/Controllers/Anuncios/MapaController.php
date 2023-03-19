<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Controller;
use App\Models\AnuncioOferta;
use Illuminate\Http\Request;

class MapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $comunidad = $request->filled('comunidad') && $request->input('comunidad') !== 'todo' ? $request->input('comunidad') : null;
            $provincia = $request->filled('provincia') && $request->input('provincia') !== 'todo' ? $request->input('provincia') : null;
            $poblacion = $request->filled('poblacion') && $request->input('poblacion') !== 'todo' ? $request->input('poblacion') : null;
            $raza = $request->filled('raza') && $request->input('raza') !== 'todo' ? $request->input('raza') : null;
            $genero = $request->filled('genero') && $request->input('genero') !== 'todo' ? $request->input('genero') : null;

            $ofertas = AnuncioOferta::where(function ($query) use ($comunidad, $provincia, $poblacion, $raza, $genero) {
                if ($comunidad !== null) {
                    $query->where('comunidad', $comunidad);
                }
                if ($provincia !== null) {
                    $query->where('provincia', $provincia);
                }
                if ($poblacion !== null) {
                    $query->where('poblacion', $poblacion);
                }
                if ($raza !== null) {
                    $query->where('raza', $raza);
                }
                if ($genero !== null) {
                    $query->where('genero', $genero);
                }
            })
            ->whereHas('anuncio', function ($query) {
                $query->where('estado', 'active')
                      ->whereHas('autor', function ($query) {
                          $query->where('estado', 'active');
                      });
            })
            ->get();
            $status = "ok";
        } catch (Exeption $ex) {
            $ofertas = "ofertas not found";
            $status = "error";
        }
        return view('mapa', ['ofertas' => $ofertas, 'status' => $status]);
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
