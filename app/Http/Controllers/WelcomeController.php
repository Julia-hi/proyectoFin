<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnuncioDemanda;
use App\Models\AnuncioOferta;
use Exception;

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
            $demandas = AnuncioDemanda::limit(12)->get();
            $ofertas = AnuncioOferta::limit(12)->get();
            
            $status = 'ok';
        } catch (Exception $er) {
            // throw new Exception('conneción fallida');
            $demandas = null;
            $ofertas = null;
            $status = 'error';
            return view('welcome', ['demandas' => $demandas, 'ofertas' => $ofertas,'status' => $status]);
        }
        return view('welcome', ['demandas' => $demandas, 'ofertas' => $ofertas, 'status' => $status]);
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
