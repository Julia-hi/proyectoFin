<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;
use Exception;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        try {
            DB::connection()->getPDO();
            // obtener anuncios demanda no bloqueados
            $anuncDemandas = Anuncio::where('tipo', 'demanda')->where('estado', 'active')
            ->whereHas('autor', function ($query) {
                $query->where('estado', 'active');
            })->limit(12)->get();
            $demandas = collect([]);
            foreach ($anuncDemandas as $anuncio) {
                if ($anuncio->anuncioDemanda) {
                    $demandas->push($anuncio->anuncioDemanda);
                }
            }
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
            $stat = 'ok';
        } catch (Exception $er) {
            // throw new Exception('error de la base de datos');
            $demandas = null;
            $ofertas = null;
            $stat = 'error';
        }
        return view('welcome', ['demandas' => $demandas, 'ofertas' => $ofertas, 'stat' => $stat]);
    }


    /**
     * Comprobar conexion con database 
     * 
     * @return bool
     */
    public function checkConnectionDB()
    {
        /*  try {
            $dbconnect = DB::connection()->getPDO();
            //$dbname = DB::connection()->getDatabaseName();
            return true;
        } catch (Exception $e) {
            throw new Exception('Connección to database fallida');
            return false;
        } */

        /* if((PDO::errorCode())!==null){
            return false;
        }else{
            return true;
        } */
    }
}
