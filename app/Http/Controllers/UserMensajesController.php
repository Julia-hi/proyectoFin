<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mensaje;
use App\Models\User;
use App\Models\Anuncio;

class UserMensajesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $dialogos_autor = [];
        $dialogos = [];
        $dialogo_autor = [];
        $mensajes = null;
        $recibidos = null;
        $enviados = null;
        $grouped_messages1 = [];
        $mensajes1 = null;
        $user = User::find($user_id);
        if (Auth::user()->rol == "admin") {
            return redirect()->route('admin');
        }
        if (Auth::user()->rol == "user") {
            $anuncios = Mensaje::distinct('anuncio_id')->pluck('anuncio_id');
            foreach ($anuncios as $id) {
                $autor = Anuncio::find($id)->user_id; //autor del anuncio

                if ($autor == $user_id) {

                    //select mensajes recibidos por autor
                    $mensajes = Mensaje::where('anuncio_id', $id)->where('remitente_id', $autor)->orWhere('recipiente_id', $user_id)->get();

                    if ($mensajes->count() > 0) {
                        $remitentesId = Mensaje::where('anuncio_id', $id)->distinct('remitente_id')->pluck('remitente_id');
                        foreach ($remitentesId as $id_rem) {
                            $dialogo_autor = [];
                            if ($id_rem != $autor) {
                                $recibidos = Mensaje::where('anuncio_id', $id)->where('remitente_id', $id_rem)->where('recipiente_id', $autor)->get();
                                $enviados = Mensaje::where('anuncio_id', $id)->where('remitente_id', $autor)->where('recipiente_id', $id_rem)->get();
                                foreach ($recibidos as $recibido) {
                                    $dialogo_autor[] = $recibido;
                                }
                                foreach ($enviados as $enviado) {
                                    $dialogo_autor[] = $enviado;
                                }
                                //sort
                                $dialogo_autor = collect($dialogo_autor)->sortBy('created_at')->values()->all();
                                $dialogos_autor[] = $dialogo_autor;
                            }
                        }
                    }
                } elseif ($autor != $user_id) {

                    //todoa mensajes del usuario actual
                    $mensajes1 = Mensaje::where('remitente_id', '=', $user_id)->orWhere('recipiente_id', '=', $user_id)->get();
                    if ($mensajes1->count() > 0) {
                        //todos mensajes del usuario actual agrupados por anuncio
                        $grouped_messages1 = $mensajes1->groupBy('anuncio_id');
                    }
                }
            }
            if (count($grouped_messages1) > 0) {
                foreach ($grouped_messages1 as $dialogo) {
                    //seleccionamos solo dialogos iniciados por usuario actual (no es autor)
                    if ($dialogo[0]->remitente_id == $user_id) {
                        $dialogos[] = $dialogo;
                    }
                }
            }
        }
        return view('user.mensajes', ['user' =>$user_id, 'dialogos' => $dialogos, 'dialogos_autor' => $dialogos_autor]);
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
        $entrada['recipiente_id'] = $request->recipiente_id;
        $entrada['chat_id'] = $request->chat_id;
        $message = Mensaje::create($entrada); // insertar mensaje a database
        $hash = $request->id_chat;
        //   manda a la pagina con chat actual abierto
        return redirect()->to(url()->previous() . '#' . $hash);
    }
    /**
     * Insert nuevo mensaje via Ajax (desde zona privada del usuario)
     */
    public function sendMessage(Request $request)
    {
        $entrada = $request->validate(
            [
                'texto' => 'required|min:5|max:300',
                'remitente_id' => 'required'
            ]
        );
        // $entrada['user_id'] = $request->remitente_id;
        $entrada['anuncio_id'] = $request->anuncio_id;
        $entrada['remitente_id'] = $request->remitente_id;
        $entrada['recipiente_id'] = $request->recipiente_id;
        $entrada['chat_id'] = $request->chat_id;
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
