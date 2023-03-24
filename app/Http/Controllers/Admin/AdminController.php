<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Anuncio;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Mostrar estadistica en area privada del administrador
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anunciosData=[];
        $ofertasTotal = Anuncio::where('tipo','oferta');
        if($ofertasTotal!=null){
            $anunciosData['ofTotal'] = $ofertasTotal->count();
        }else{
            $anunciosData['ofTotal']=0;
        }
        
        $ofertas30dias = Anuncio::where('tipo','oferta')->whereBetween('created_at', [
            Carbon::now()->subDays(30)->startOfDay(),
            Carbon::now()->endOfDay()
        ]);
        if($ofertas30dias!=null){
            $anunciosData['of30dias'] = $ofertas30dias->count();
        }else{
            $anunciosData['of30dias'] =0;
        }
        
        $ofertas365dias = Anuncio::where('tipo','oferta')->whereBetween('created_at', [
            Carbon::now()->subDays(365)->startOfDay(),
            Carbon::now()->endOfDay()
        ]);
        if($ofertas365dias!=null){
            $anunciosData['of365dias'] = $ofertas365dias->count();
        }else{
            $anunciosData['of365dias'] = 0;
        }
        
        $demandasTotal = Anuncio::where('tipo','demanda');
        if($demandasTotal!=null){
            $anunciosData['demTotal'] = $demandasTotal->count();
        }else{
            $anunciosData['demTotal'] =0;
        }
        
        $demandas30dias = Anuncio::where('tipo','demanda')->whereBetween('created_at', [
            Carbon::now()->subDays(30)->startOfDay(),
            Carbon::now()->endOfDay()
        ]);
        if($demandas30dias!=null){
            $anunciosData['dem30dias'] = $demandas30dias->count();
        }else{
            $anunciosData['dem30dias'] =0;
        }
        
        $demandas365dias = Anuncio::where('tipo','demanda')->whereBetween('created_at', [
            Carbon::now()->subDays(365)->startOfDay(),
            Carbon::now()->endOfDay()
        ]);
        if($ofertas365dias!=null){
            $anunciosData['dem365dias'] = $demandas365dias->count();
        }else{
            $anunciosData['dem365dias'] = 0;
        }
        
        $usuariosData=[];
        $activeUsTotal = User::where('rol','user')->where('estado','active');
        if($activeUsTotal!=null){
            $usuariosData['activeTotal'] = $activeUsTotal->count();
        }else{
            $usuariosData['activeTotal'] = 0;
        }
        
        $activeUs30dias = User::where('rol','user')->where('estado','active')->whereBetween('created_at', [
            Carbon::now()->subDays(30)->startOfDay(),
            Carbon::now()->endOfDay()
        ]);
        if( $activeUs30dias!=null){
            $usuariosData['active30dias'] = $activeUs30dias->count();
        }else{
            $usuariosData['active30dias']=0;
        }
        
        $activeUs365dias = User::where('rol','user')->where('estado','active')->whereBetween('created_at', [
            Carbon::now()->subDays(365)->startOfDay(),
            Carbon::now()->endOfDay()
        ]);
        if($activeUs365dias!=null){
            $usuariosData['active365dias'] = $activeUs365dias->count();
        }else{
            $usuariosData['active365dias']=0;
        }

        $bloqueadosUsTotal = User::where('rol','user')->where('estado','blocked');
        if($bloqueadosUsTotal!=null){
            $usuariosData['bloqueadosTotal'] = $bloqueadosUsTotal->count();
        }else{
            $usuariosData['bloqueadosTotal'] = 0;
        }
        
        $bloqueadosUs30dias = User::where('rol','user')->where('estado','blocked')->whereBetween('created_at', [
            Carbon::now()->subDays(30)->startOfDay(),
            Carbon::now()->endOfDay()
        ]);
        if($bloqueadosUs30dias!=null){
            $usuariosData['bloqueados30dias'] = $bloqueadosUs30dias->count();
        }else{
            $usuariosData['bloqueados30dias'] = 0;
        }

        $bloqueadosUs365dias = User::where('rol','user')->where('estado','blocked')->whereBetween('created_at', [
            Carbon::now()->subDays(365)->startOfDay(),
            Carbon::now()->endOfDay()
        ]);
        if($bloqueadosUs365dias!=null){
            $usuariosData['bloquados365dias'] = $bloqueadosUs365dias->count();
        }else{
            $usuariosData['bloquados365dias'] = 0;
        }
        
        
        return view('admin.dashboard', ['anunciosData'=>$anunciosData, 'usuariosData'=>$usuariosData, 'user'=>Auth::user(), 'user_id'=>Auth::user()->id]);
    }
}
