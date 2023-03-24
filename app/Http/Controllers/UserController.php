<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::find($user_id);
        if ($user->rol == "user") {
            return redirect()->route('dashboard',['user_id'=>$user->id]);
        }elseif($user->rol == "admin"){
            return view('admin.dashboard');
        } else {
            return redirect()->back()->with('Ha producido un error.');
        }
    }
}
