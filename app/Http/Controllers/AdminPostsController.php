<?php

namespace App\Http\Controllers;

use Session;
use App\{Post,Photo};
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
        //return $request->file('file')->getClientMimeType();
        if ( Gate::forUser(Auth::user())->allows('post.create') ) {

            $data = $request->validated();

            unset($data['file']);

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

                return redirect()->route('admin.posts.create');
            }

            //uploading photo 
            if ( $request->hasFile('file') && $request->file('file')->isValid() ) {

                $errors = [];

                //Set default file extension whitelist
                $whitelist_ext = [
                    'jpeg',
                    'jpg',
                    'png',
                    'bmp'
                ];

                //Set default file type whitelist
                $whitelist_type = [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/bmp'
                ];

                //Check file has the right extension           
                if ( !in_array( $request->file('file')->getClientMimeType(), $whitelist_ext )) {
                    Session::flash('extension', 'Invalid file Extension!');
                }
                
                //Check that the file is of the right type
                if ( !in_array( $request->file('file')->getClientMimeType(), $whitelist_type )) {
                    Session::flash('type', 'Invalid file Type!');
                }

                //Check that the file is not too big, max 16mb
                if ( $request->file('file')->getClientSize() < 16000000) {
                    Session::flash('size', 'File is too big!');
                }

                //creating new unique name for photo
                $tmp = str_replace(array('.',' '), array('',''), microtime());

                $tmp_name = explode('.', strtolower( $request->file('file')->getClientOriginalName() ) );

                $newname = uniqid($tmp).'_'.Auth::id().'_'.$tmp_name[0].'.'.$request->file('file')->getClientOriginalExtension();

                $check = Photo::where('file','=',$newname);

                //Check if file already exists on server
                if (file_exists('images/'.$newname) && $check && Session::has('type') && Session::has('size') && Session::has('extension')) {
                    return "aa";
                    return redirect()->route('admin.posts.create');
                }

                //Upload file
                try {
                    $request->file('file')->move(
                        'images/', $newname
                    );
                } catch(\Exception $e) {

                    return $e->getMessage();
                }

                
                try{

                    $post->photos()->save(new Photo(['file' => $newname]));
    
                } catch(\Exception $e) {
    
                    return $e->getMessage();
                }
            }


            Session::flash('message', 'New post was created successfully!');
            Session::flash('class', 'alert-info');

            return redirect()->route('posts');

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
