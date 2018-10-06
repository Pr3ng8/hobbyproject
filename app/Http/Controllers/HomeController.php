<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User,Reservation};
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
        //$reservation = Reservation::findOrFail(1);
        $user = DB::table('users')
        ->select('roles.name')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->where('users.id', '1')
        ->first();
       // $roles = $user;

       $roles = User::findOrFail(1)->userRole();


        return dd($roles);
    }
}
