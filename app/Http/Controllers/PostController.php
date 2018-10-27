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

            try {
                // Get all post and create pagination
                $items = Post::paginate(9);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }
            
            
            return view('post.posts',['items' => $items]);

        }

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

            /*
            * Trying to find the post by id with the comments
            */
            try {

                $post = Post::with('user.comments')->findOrFail($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            return view('post.post',['post' => $post]);
        }

        return redirect()->route('home');
    }
}
