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

            try {
                // Trying to find the post by id
                $post = Post::findOrFail($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            //If we found the post we want to find the comments that are belongs to it
            if ( $post ) {
                try {
                    // Trying to find the post's comments by id
                    $coments = $post->comments();
        
                } catch(\Exception $e) {
        
                    return $e->getMessage();
                }
            }


            return view('post.post')->with('post',$post);
        }

        return redirect()->route('home');
    }
}
