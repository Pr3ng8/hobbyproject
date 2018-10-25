<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate,Auth,DB};
use App\Http\Requests\AdminBoatRequest;
use App\Boat;

class AdminBoatsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('boat.view') ) {

            if( $request->get('status') === "all" || count($request->all()) === 0 ) {

                $boats = Boat::
                withTrashed()
                ->paginate(10);;

            } else {

                $boats = new Boat();

                switch ( $request->get('status') ) {

                    case "active" :
                        $boats = $boats->all();
                        break;

                    case "trashed" :
                        $boats = $boats->onlyTrashed();
                        break;

                    default :
                        $boats = $boats->withTrashed();
                        break;
                }
            }

            return view( 'admin.boats.boats', ['boats' => $boats] );

        } else {

        /*
        * If the user doesn't have permission redirect to home page
        */
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

        if ( Gate::forUser(Auth::user())->allows('boat.create') ) {

            return view('admin.boats.create');

        } else {

            /*
            * If the user doesn't have permission redirect to home page
            */
            return redirect()->route('home');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdminBoatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminBoatRequest $request)
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('boat.create') ) {

            $data = $request->validated();


            $boat = new Boat($data);

            try{

                $boat->save();

            } catch(\Exception $e) {

                return $e->getMessage();
            }

            Session::flash('message', 'New boat was created successfully!');
            Session::flash('class', 'alert-info');

            return redirect()->route('admin.boats.index');
            

        } else {

            /*
            * If the user doesn't have permission redirect to home page
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
        if ( Gate::forUser(Auth::user())->allows('boat.view') ) {

            if (!is_numeric($id)) {

                $boat = NULL;

                return view( 'admin.boats.boat', ['boat' => $boat] );
            }

            $boat = Boat::withTrashed()->findOrFail($id);

            if ( !$boat) {

                Session::flash('message', 'We could not find the post you were looking for!');
                Session::flash('class', 'alert-danger');

                return view( 'admin.boats.boat', ['boat' => $boat] );
            }

            return view( 'admin.boats.boat', ['boat' => $boat] );

        } else {
            /*
            * If the user doesn't have permission redirect back
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
        if ( Gate::forUser(Auth::user())->allows('boat.view') ) {

            if (!is_numeric($id)) {

                $boat = NULL;

                return view( 'admin.boats.edit', ['boat' => $boat] );
            }

            $boat = Boat::withTrashed()->findOrFail($id);

            if ( !$boat) {

                Session::flash('message', 'We could not find the post you were looking for!');
                Session::flash('class', 'alert-danger');

                return view( 'admin.boats.edit', ['boat' => $boat] );
            }

            return view( 'admin.boats.edit', ['boat' => $boat] );

        } else {
            /*
            * If the user doesn't have permission redirect back
            */

            return redirect()->route('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdminBoatRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminBoatRequest $request, $id)
    {        
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('boat.update') ) {

            if ( !is_numeric($id) ) {

                Session::flash('message', 'We could not update the boat\'s data, sorry!');
                Session::flash('class', 'alert-danger');

                return redirect()->back();
            }

            $boat = Boat::withTrashed()->findOrFail($id);

            if ( !$boat ) {
                Session::flash('message', 'We could not find the boat, sorry!');
                Session::flash('class', 'alert-danger');

                return redirect()->back();
            }

            // Get the validated data from $request
            $data = $request->validated();

            try {
                // Updating the boat\'s data
                $boat->update($data);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            Session::flash('message', 'We have successfully updated the boat\'s data');
            Session::flash('class', 'alert-success');

            return redirect()->route('admin.boats.index');
        } else {
            /*
            * If the user doesn't have permission redirect back
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

        if ( Gate::forUser(Auth::user())->allows('boat.delete') ) {

            if ( !is_numeric($id) ) {

                Session::flash('message', 'We could not find the boat, sorry!');
                Session::flash('class', 'alert-danger');

                return redirect()->back();
            }

            $boat = Boat::findOrFail($id);

            if ( !$boat ) {

                Session::flash('message', 'We could not find the boat, sorry!');
                Session::flash('class', 'alert-danger');

                return redirect()->back();
            }

            try {

                $boat->delete();
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            if( $boat->trashed() ) {

                Session::flash('message', 'We successfully deleted the boat!');
                Session::flash('class', 'alert-success');

                return redirect()->route('admin.boats.index');
            }

            Session::flash('message', 'Sorry ,We couldn\'t delete the boat!');
            Session::flash('class', 'alert-warning');

            return redirect()->route('admin.boats.index');

        } else {

            /*
            * If the user doesn't have permission redirect to home page
            */
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
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('boat.create') ) {

            if ( !is_numeric($id) ) {

                Session::flash('message', 'We could not find the boat, sorry!');
                Session::flash('class', 'alert-danger');

                return redirect()->back();
            }

            $boat = Boat::onlyTrashed()->findOrFail($id);

            if ( !$boat ) {

                Session::flash('message', 'We could not find the boat, sorry!');
                Session::flash('class', 'alert-danger');

                return redirect()->back();
            }

            try {

                $boat->restore();
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            if( !$boat->trashed() ) {

                Session::flash('message', 'We successfully restored the boat!');
                Session::flash('class', 'alert-success');

                return redirect()->route('admin.boats.index');
            }

            Session::flash('message', 'Sorry ,We couldn\'t restore the boat!');
            Session::flash('class', 'alert-warning');

            return redirect()->route('admin.boats.index');

        } else {

            /*
            * If the user doesn't have permission redirect to home page
            */
            return redirect()->route('home');

        }
    }
}
