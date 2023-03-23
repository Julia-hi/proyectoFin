<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mensaje;
use Exception;
use Illuminate\Support\Facades\Redirect;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $usersActive = User::where('rol', 'user')->where('estado', 'active')->get();
        $usersBloqueados = User::where('rol', 'user')->where('estado', 'blocked')->get();
        if (Auth::user()->rol == "admin") {
            $status = 'ok';
        } else {
            $status = 'error';
        }
        return view('admin/admin_users', ['stat' => $status, 'usAct' => $usersActive, 'usBloq' => $usersBloqueados,'admin'=>$id]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_admin, $id_user)
    {
        try {
            $user = User::findOrFail($id_user);
            $anuncios = $user->anuncios;
            $mensajes = Mensaje::where('remitente_id', $id_user)->get();
            $status = 'ok';
        } catch (Exception $e) {
            $status = 'error';
            $anuncios=null;
            $user = null;
            $mensajes = null;
        }

        return view('/admin/user_data', ['stat' => $status, 'user' => $id_user, 'anuncios' => $anuncios, 'mensajes' => $mensajes,'admin'=>$id_admin]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id_user)
    {
        $user = User::findOrFail($id_user);
        if ($user->rol != 'admin') {
            $user->estado = $request->estado;
            $user->save();
        }
        return Redirect::route('admin.users.index', ['admin' => $id,'user' => $id_user]);
    }
}
