<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mensaje;
use App\Models\User;
use App\Models\Anuncio;

use Illuminate\Support\Facades\DB;

class UserMensajesController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {

        /*  $user = User::find($user_id);
        echo $user->name."<br>";
        $mensajes = $user->mensajes; // array de id de mensajes
        foreach ($mensajes as $mens_id) {
           // $mensaje = Mensaje::get($mens_id);
            echo $mens_id;
        }
        $anuncios = $user->anuncios;
        foreach ($anuncios as $anuncio) {
         //   echo $anuncio;
        } */

        // $dialogos = DB::table('mensajes')->where('user_id', $user)->groupBy('anuncio_id')->get();

        $user = User::find($user_id);
        //obtener id de todos anuncios a quales usuario ha enviado mensajes
        $anuncios_id = DB::table('mensajes')
            ->select('anuncio_id')
            //  ->where('remitente_id', '=', $user_id)
            ->groupBy('anuncio_id')
            ->get();

        foreach ($anuncios_id as $id) {
            $anuncio = Anuncio::find($id->anuncio_id); //anuncio
            $autor = $anuncio->autor; //autor del anuncio
            if ($user->id == $autor->id) {
                $remitentes = DB::table('mensajes')
                    ->select('remitente_id')
                    ->where('anuncio_id', '=', $anuncio->id)
                    ->groupBy('remitente_id')
                    ->get();
                foreach ($remitentes as $rem) {
                    //mensajes propios del user actual pertenecentes al anuncio concreto
                    $mensajes = Mensaje::where('anuncio_id', $id->anuncio_id)->where('remitente_id', $rem->remitente_id)->get();
                    foreach ($mensajes as $mensaje) {
                        $dialogo[] = $mensaje;
                    }
                    $dialogos[] = $dialogo; // añadir dialogo al array
                }
            } else {
                //mensajes propios del user actual pertenecentes al anuncio concreto
                $mensajesEnviados = Mensaje::where('anuncio_id', $id->anuncio_id)->where('remitente_id', $user->id)->where('recipiente_id', $autor->id)->get();
                foreach ($mensajesEnviados as $mensaje) {
                    $dialogo[] = $mensaje;
                }
                //mensajes recibidos
                $mensajesRecibidos = Mensaje::where('anuncio_id', $id->anuncio_id)->where('remitente_id', $autor->id)->where('recipiente_id', $user->id)->get();
                foreach ($mensajesRecibidos as $mensaje) {
                    $dialogo[] = $mensaje;
                }
                $dialogos[] = $dialogo; // añadir dialogo al array
            }
        }
        return view('user.mensajes', ['user' => $user, 'dialogos' => $dialogos, 'status' => 'ok']);
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
                'texto' => 'required|min:5|max:300',
            ]
        );
        $entrada['anuncio_id'] = $request->anuncio_id;
        $entrada['remitente_id'] = $request->remitente_id;
        $entrada['recipiente_id'] = Anuncio::find($request->anuncio_id)->autor->id;
        $message = Mensaje::create($entrada); // insertar mensaje a database

        return back();
    }
    /**
     * Insert nuevo mensaje via Ajax (desde zona privada del usuario)
     */
    public function sendMessage(Request $request)
    {
        $entrada = $request->validate(
            [
                'texto' => 'required|min:5|max:300',
                'remitente_id'=>'required'
            ]
        );
        $entrada['user_id'] = $request->remitente_id;
        $entrada['anuncio_id'] = $request->anuncio_id;
        $entrada['remitente_id'] = $request->remitente_id;
        $entrada['recipiente_id'] = $request->recipiente_id;
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
