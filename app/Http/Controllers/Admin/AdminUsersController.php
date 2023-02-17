<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::where('id', $id)->get();
        try {
            $user = User::where('id', $id)->get();
        } catch (Exception $ex) {
            //error se no hay conexion con la BD
            $status = "error";
            return view('welcome', ['demandas' => null, 'ofertas' => null, 'status' => $status]);
        }
        if ($user->rol == "admin") {
            $users = User::all();
            $status = "ok";
            return view('admin.admin_users', ['admin_id' => $id, 'users' => $users, 'status' => $status]);
        } else {
            //return to welcome with status ok
            $demandas = AnuncioDemanda::limit(12)->get();
            $ofertas = AnuncioOferta::limit(12)->get();
            $status = "ok";
             return view('welcome', ['demandas' => $demandas, 'ofertas' => $ofertas,'status' => $status]);
            //return Redirect::route('/');
        }
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
}
