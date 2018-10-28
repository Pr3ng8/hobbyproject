<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate,Auth,DB};
use App\{User,Role,Comment};
use App\Http\Requests\CommentRequest;
class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\CommentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('comment.create') ) {

            //get the validated data from request
            $comment = $request->validated();

            //Add the user id to the array
            $comment['user_id'] = Auth::id();

            //Creating new comment for the post
            $newcomment = new Comment($comment);

            //Insert new comment into database
            try {
            
                $newcomment->save();    
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

                // if it was succes redirect back the user to the post
                Session::flash('message', 'Thanks for sharing your thoughts!');
                Session::flash('class', 'alert-success');
            return redirect()->back();
        } else {

            /*
            * If the user doesn't have permission redirect to homepage
            */

            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('comment.view') ) {
            
        } else {

            /*
            * If the user doesn't have permission redirect to homepage
            */

            return redirect()->route('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('comment.view') ) {
            
        } else {

            /*
            * If the user doesn't have permission redirect to homepage
            */

            return redirect()->route('home');
        }
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
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('comment.view') ) {
            
        } else {

            /*
            * If the user doesn't have permission redirect to homepage
            */

            return redirect()->route('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('comment.view') ) {
            
        } else {

            /*
            * If the user doesn't have permission redirect to homepage
            */

            return redirect()->route('home');
        }
    }
}
