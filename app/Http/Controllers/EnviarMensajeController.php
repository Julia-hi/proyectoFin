<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;

class EnviarMensajeController extends Controller
{
    /**
     * Insert nuevo mensaje via Ajax (desde zona provada del usuario)
     */
    public function sendMessage(Request $request)
    {

        $entrada = $request->validate(
            [
                'texto' => 'required|min:10|max:300',
                'anuncio_id' => 'required',
                'user_id' => 'required'
            ]
        );
       // $entrada['anuncio_id'] = $request->anuncio_id;
       // $entrada['user_id'] = $request->user_id;
        Mensaje::create($entrada); // insert a database

        return response()->json([
            'success' => true,
            'message' => $entrada
        ])->header('Content-Type', 'application/json');
    }
}
