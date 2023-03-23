<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Anuncio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Redirect;

class AdminAnunciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($admin_id)
    {
        //todos anuncios de oferta activos
        $ofertasActive = Anuncio::where('tipo', 'oferta')->where('estado', 'active')->get();
        //todos anuncios de oferta desactivados
        $ofertasNoActive = Anuncio::where('tipo', 'oferta')->where('estado', 'blocked')->get();

        //anuncios de demanda activos
        $demandasActive = Anuncio::where('tipo', 'demanda')->where('estado', 'active')->get();
        //todos anuncios de demanda desactivados
        $demandasNoActive = Anuncio::where('tipo', 'demanda')->where('estado', 'blocked')->get();

        if (User::find($admin_id)->rol == "admin") {
            $status = 'ok';
        } else {
            $status = 'error';
        }
        echo "Admin id: ".$admin_id;
        return view('admin/admin_anuncios', ['stat' => $status, 'ofertasAct' => $ofertasActive, 'ofertasDesact' => $ofertasNoActive, 'demandasAct' => $demandasActive, 'demandasDesact' => $demandasNoActive]);
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
    public function show($id_admin, $id_anunc)
    {
        try {
            $anuncio = Anuncio::find($id_anunc);
            $status = 'ok';
        } catch (Exception $e) {
            $status = 'error';
            $anuncio = null;
        }
        return view('/admin/anuncio_data', ['stat' => $status, 'anuncio' => $anuncio]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$anunc_id)
    {
        try {
            $anuncio = Anuncio::findOrFail($anunc_id);
            $anuncio->estado = $request->estado;
            $anuncio->save();
            $status = 'ok';
        } catch (Exception $e) {
            $anuncio = null;
            $status = 'error';
        }
     
      return Redirect::back()->with(['stat'=>$status, 'anuncio' => $anuncio,'admin'=>Auth::user()->id]);
    }


}