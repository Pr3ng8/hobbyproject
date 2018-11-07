<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate,Auth,DB};
use App\{User,Role,Comment};
use App\Http\Requests\CommentRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
        *Check if the user has permission to this method
        */

        try {

            $user = User::findOrFail(Auth::id());

        } catch ( \Exception $e) {

            return $e->getMessage();

        }

        if ( Gate::forUser(Auth::user())->allows('user.view', $user) ) {

            try {

                $comments = Comment::all()->where('user_id',Auth::id());
                
            } catch ( \Exception $e) {

                return $e->getMessage();

            }

            return view('user.profile',['user' => $user,'comments' => $comments]);

        } else {

            /*
            * If the user doesn't have permission redirect to homepage
            */

            return redirect()->route('login');
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $user = User::findOrFail(Auth::id());

        } catch ( \Exception $e) {

            return $e->getMessage();

        }

        return view('user.edit',['user' => $user]);
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

}
