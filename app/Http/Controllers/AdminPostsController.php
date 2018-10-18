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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::user()->id;

        $post = new Post($data);

        try{

            $post->save();

        } catch(\Exception $e) {

            return $e->getMessage();
        }

        Session::flash('message', 'New post was created successfully!');
        Session::flash('class', 'alert-info');

        return redirect()->route('news');
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
        try{

            $post = Post::withTrashed()->findOrFail($id);

        } catch(\Exception $e) {

            return $e->getMessage();
        }

        if ( $post ) {

            return view('admin.posts.edit', ['post' => $post]);
            
        } else {
            // redirect to list of posts with errormessage
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
        return $request->all();
        try{

            $post = Post::findOrFail($id)->withTrashed();

        } catch(\Exception $e) {

            return $e->getMessage();
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

    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id) 
    {
        try {

            $post = Post::onlyTrashed()->find($id)->restore();

        } catch(\Exception $e) {

            return abort(404);
        }

        if ( $post ) {

            Session::flash('message', 'We have restored the post successfully!');
            Session::flash('class', 'alert-success');

            return redirect()->back();
        }

        Session::flash('message', 'We couldn\'t restore the post!');
        Session::flash('class', 'alert-warning');

        return redirect()->back();
    }
}
