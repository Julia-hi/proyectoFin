<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user)
    {
        if ($user->rol == "user") {
            return view('user.dashboard');
        }elseif($user->rol == "admin"){
            return view('admin.dashboard');
        } else {
            return redirect()->back()->with('Ha producido un error.');
        }
    }
}
