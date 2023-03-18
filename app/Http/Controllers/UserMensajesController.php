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
        $dialogos=[];
        $user = User::find($user_id);
        if ($user->rol == "admin") {
            return redirect()->route('/admin-dashboard');
        } else {
            $messages = Mensaje::where('remitente_id', '=', $user_id)->orWhere('recipiente_id', '=', $user_id)->get();
            if ($messages->count() == 0) {
               
            } else {
                $grouped_messages = $messages->groupBy('anuncio_id');
                foreach ($grouped_messages as $dialogo) {
                    $dialogos[] = $dialogo;
                }
            }
            return view('user.mensajes', ['user' => $user, 'dialogos' => $dialogos, 'status' => 'ok']);
        }
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
