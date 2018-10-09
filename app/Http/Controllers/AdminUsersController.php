<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate,Auth,DB};
use Illuminate\Routing\UrlGenerator;
use App\User;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($listmode = "active")
    {
        return Auth::user()->hasPermission();
        if ( Gate::forUser(Auth::user())->allows('user.view') ) {

            switch ($listmode) {

                case "active":
                try {

                    $users = User::paginate(10);
        
                } catch(\Exception $e) {
        
                    return $e->getMessage();
                }
                break;

                case "trased":
                try {

                    $users = User::onlyTrashed()->paginate(10);
        
                } catch(\Exception $e) {
        
                    return $e->getMessage();
                }
                break;
                
                default:
                try {

                    $users = User::paginate(10);
        
                } catch(\Exception $e) {
        
                    return $e->getMessage();
                }
            }

            return view('admin.users.users',['users' => $users]);

        } else {
            return "nope";
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

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        //
    }
}
