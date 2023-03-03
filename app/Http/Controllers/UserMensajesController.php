<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mensaje;
use Exception;
use Illuminate\Support\Facades\DB;

class UserMensajesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user)
    {
        // $dialogos = DB::table('mensajes')->where('user_id', $user)->groupBy('anuncio_id')->get();
        $dialogos = DB::table('mensajes')
            ->select('anuncio_id')
            ->where('user_id', '=', $user)
            ->groupBy('anuncio_id')
            ->get();

        foreach ($dialogos as $key => $dialogo) {
            $anunc_id = $dialogo->anuncio_id;
            $mensajesEnviados[$anunc_id] = Mensaje::where('anuncio_id', $anunc_id)->where('user_id', $user)->get();
            //$mensajesEnviados[$anunc_id] = DB::table('mensajes')->where('anuncio_id',$anunc_id)->where('user_id',$user)->get();
        }
       
        return view('user.mensajes', ['user' => $user, 'dialogos' => $mensajesEnviados, 'status' => 'ok']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.mensaje-create', ['user' => Auth::user()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entrada = $request->validate(
            [
                'texto' => 'required|min:10|max:300'
            ]
        );
        $entrada['anuncio_id'] = $request->anuncio_id;
        $entrada['user_id'] = $request->user_id;
        $message = Mensaje::create($entrada); // insert a database
          return Redirect::route('user.anuncios.index', ['user' => $user->name, 'demandas' => $usersDemandas, 'ofertas' => $usersOfertas, 'status' => 'ok', 'mensaje'=>$message]); 
       // return back()->with('visible', $entrada['anuncio_id']);
    }
    /**
     * Insert nuevo mensaje via Ajax (desde zona provada del usuario)
     */
    public function sendMessage(Request $request)
    {
       
        $entrada = $request->validate(
            [
                'texto' => 'required|min:10|max:300',
                'anuncio_id'=>'required',
                'user_id'=>'required'
            ]
        );
        $entrada['anuncio_id'] = $request->anuncio_id;
        $entrada['user_id'] = $request->user_id;
        Mensaje::create($entrada); // insert a database

        return response()->json([
            'success' => true,
            'message' => $entrada
        ])->header('Content-Type', 'application/json');
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
