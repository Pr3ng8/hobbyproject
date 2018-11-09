<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate,DB,Auth};

class PostController extends Controller
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

        if ( Gate::forUser(Auth::user())->allows('post.view') ) {

            //Trying to get all the psot from database
            try {
                // Get all post and create pagination
                $posts = Post::simplePaginate(6);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }
            
            //Return view posts view with the post we got from the database
            return view('post.posts',['posts' => $posts]);

        }

        /*
        * If the user doesn't have permission redirect back
        */
        return redirect()->route('home');
        
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

        if ( Gate::forUser(Auth::user())->allows('post.view') ) {

            //Checking if the $id is numeric
            if ( !is_numeric($id) ) {

                //If the id is not numreic send back empty post var to the user and arning message
                Session::flash('message', 'We have successfully updated the boat\'s data');
                Session::flash('class', 'alert-success');

                return view('post.post',['post' => $post]);
            }

            /*
            * Trying to find the post by id with the comments
            */
            try {
                //Trying to get the post data with the comments
                $post = Post::with('user.comments')->findOrFail($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            //If we found the post return post view with the $post we found
            //On frontend we check if we found the post
            return view('post.post',['post' => $post]);
        }
        
         /*
        * If the user doesn't have permission redirect back
        */
        return redirect()->route('home');
    }
}
