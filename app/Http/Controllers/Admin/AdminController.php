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
        $numOfertasTotal = Anuncio::where('tipo','oferta')->count();
        $anunciosData['ofTotal'] = $numOfertasTotal;
        $numOfertas30dias = Anuncio::where('tipo','oferta')->whereBetween('created_at', [
            Carbon::now()->subDays(30)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();
        $anunciosData['of30dias'] = $numOfertas30dias;
        $numOfertas365dias = Anuncio::where('tipo','oferta')->whereBetween('created_at', [
            Carbon::now()->subDays(365)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();
        $anunciosData['of365dias'] = $numOfertas365dias;

        $numDemandasTotal = Anuncio::where('tipo','demanda')->count();
        $anunciosData['demTotal'] = $numDemandasTotal;
        $numDemandas30dias = Anuncio::where('tipo','demanda')->whereBetween('created_at', [
            Carbon::now()->subDays(30)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();
        $anunciosData['dem30dias'] = $numDemandas30dias;
        $numOfertas365dias = Anuncio::where('tipo','demanda')->whereBetween('created_at', [
            Carbon::now()->subDays(365)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();
        $anunciosData['dem365dias'] = $numOfertas365dias;

        $usuariosData=[];
        $numActiveTotal = User::where('rol','user')->where('estado','active')->count();
        $usuariosData['activeTotal'] = $numActiveTotal;

        $numActive30dias = User::where('rol','user')->where('estado','active')->whereBetween('created_at', [
            Carbon::now()->subDays(30)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();
        $usuariosData['active30dias'] = $numActive30dias;

        $numActive365dias = User::where('rol','user')->where('estado','active')->whereBetween('created_at', [
            Carbon::now()->subDays(365)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();
        $usuariosData['active365dias'] = $numActive365dias;

        $numBloqueadosTotal = User::where('rol','user')->where('estado','blocked')->count();
        $usuariosData['bloqueadosTotal'] = $numBloqueadosTotal;

        $numBloqueados30dias = User::where('rol','user')->where('estado','blocked')->whereBetween('created_at', [
            Carbon::now()->subDays(30)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();
        $usuariosData['bloqueados30dias'] = $numBloqueados30dias;

        $numBloqueados365dias = User::where('rol','user')->where('estado','blocked')->whereBetween('created_at', [
            Carbon::now()->subDays(365)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();
        $usuariosData['bloquados365dias'] = $numBloqueados365dias;

        if (Auth::check() && Auth::user()->rol=="admin") {
            $stat = 'ok';
        } else {
            $stat = 'error';
        } 
        return view('admin.dashboard', ['stat'=>$stat, 'anunciosData'=>$anunciosData, 'usuariosData'=>$usuariosData]);
    }
}
