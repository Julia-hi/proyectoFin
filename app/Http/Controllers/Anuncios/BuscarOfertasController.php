<?php

namespace App\Http\Controllers\Anuncios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnuncioOferta;

class BuscarOfertasController extends Controller
{
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

        return view('ofertas-filter', ['ofertas' => $ofertas, 'stat' => $status]);
    }
}
