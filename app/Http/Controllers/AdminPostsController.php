<?php

namespace App\Http\Controllers;

use Session;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate,Auth,DB};
use App\Http\Requests\PostRequest;
use Illuminate\Routing\UrlGenerator;
class AdminPostsController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('post.view') ) {

            $listmode = $request->get('postsstatus') ?? "all";

            switch ($listmode) {
                case "all":
                    $posts = Post::withTrashed()->paginate(15);
                break;
                case "active":
                    $posts = Post::paginate(15);
                break;
                case "trashed":
                    $posts = Post::onlyTrashed()->paginate(15);
                break;
                default:
                    $posts = Post::withTrashed()->paginate(15);    
            }

            return view('admin.posts.posts',['posts' => $posts]);

        } else {

            return redirect()->route('home');

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('post.view') ) {

            return view('admin.posts.create');

        } else {

            return redirect()->route('home');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('post.create') ) {

            $data = $request->validated();

            $data['user_id'] = Auth::user()->id;

            $post = new Post($data);

            try{

                $post->save();

            } catch(\Exception $e) {

                return $e->getMessage();
            }

            if ( !$post->id) {

                Session::flash('message', 'We could not save the new post,sorry!!');
                Session::flash('class', 'alert-danger');

                return redirect()->back();
            }

            Session::flash('message', 'New post was created successfully!');
            Session::flash('class', 'alert-info');

            return redirect()->route('news');

        } else {

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
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('post.view') ) {

            try{

                $post = Post::withTrashed()->findOrFail($id);

            } catch(\Exception $e) {

                return $e->getMessage();
            }

            return view('admin.posts.edit', ['post' => $post]);

        } else {

            return redirect()->route('home');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('post.view') ) {

            $data = $request->validated();

            try{

                $post = Post::withTrashed()->findOrFail($id);

            } catch(\Exception $e) {

                return $e->getMessage();
            }

            Session::flash('message', 'Post was updated successfully!');
            Session::flash('class', 'alert-info');

            return redirect()->route('admin.posts.index');

        } else {

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

        if ( Gate::forUser(Auth::user())->allows('post.view') ) {

            $post = Post::findOrFail($id);

            try{

                $post->delete();

            } catch(\Exception $e) {

                return $e->getMessage();
            }

            if ( $post->trashed() ) {

                Session::flash('message', 'Post Deleted Successfully!');
                Session::flash('class', 'alert-info');
        
                return redirect()->back();
            }

            Session::flash('message', 'We are sorry, we couldn\'t delete the post!');
            Session::flash('class', 'alert-warning');

            return redirect()->back();

        } else {
            
            return redirect()->route('home');

        }

    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id) 
    {

        if ( Gate::forUser(Auth::user())->allows('post.view') ) {
            try {

                $post = Post::onlyTrashed()->find($id)->restore();

            } catch(\Exception $e) {

                return $e->getMessage();
            }

            if ( $post ) {

                Session::flash('message', 'We have restored the post successfully!');
                Session::flash('class', 'alert-success');

                return redirect()->back();
            }

            Session::flash('message', 'We couldn\'t restore the post!');
            Session::flash('class', 'alert-warning');

            return redirect()->back();

        } else {

            return redirect()->route('home');

        }

    }
}
