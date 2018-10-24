<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Gate,Auth,DB};
use Illuminate\Routing\UrlGenerator;
use App\{User,Role,UserStatus};
use App\Http\Requests\AdminUserRequest;
class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
        *Check if the user has permission to this method
        */
        //return $request->get('name');
        if( $request->get('name') === "all" && $request->get('status') === "all" && $request->get('usersstatus') === "all" || count($request->all()) === 0 ) {

            $users = User::
            withTrashed() 
            ->where('id','!=',Auth::id())
            ->paginate(10);

        } else {

            $columns = [
                'roles' => 'name',
                'status' => 'status',
            ];

            $users = new User();

            switch ($request->get('usersstatus') ) {
                case "all" :
                    $users->withTrashed();
                    break;
                case "active" :
                    break;
                case "trashed" :
                    $users->onlyTrashed();
                    break;
            }

            foreach ($columns as $relationship => $columnname ) {

                if( $request->get($columnname) != "all" && $request->has($columnname) ) {

                    $users = $users->whereHas($relationship, function($q) use ($request,$columnname ){
                        $q->where($columnname, $request->get($columnname));
                    });

                }
            }
            
            $users->where('id','!=',Auth::id());

            $users = $users->paginate(10);
        }

        $roles = Role::all()->whereNotIn('id', [1]);

        return view('admin.users.users',['users' => $users, 'roles' => $roles]);
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

        if ( Gate::forUser(Auth::user())->allows('user.view') ) {
            try {

                $user = User::where('id','!=',Auth::id())->findOrFail($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            return view('admin.users.user',['user' => $user]);

        } else {

            /* If the user doesn't have
            * permission we redirect him to the home page
            */

            return redirect('home');

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

        if ( Gate::forUser(Auth::user())->allows('user.view') ) {
            try {

                $user = User::where('id','!=',Auth::id())->withTrashed()->findOrFail($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            try {

                $roles = Role::all();
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            return view('admin.users.edit',['user' => $user,'roles' => $roles]);

        } else {

            /* If the user doesn't have
            * permission we redirect him to the home page
            */

            return redirect('home');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdminUserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserRequest $request, $id)
    {
        /*
        *Check if the user has permission to this method
        */

        if ( Gate::forUser(Auth::user())->allows('user.update') ) {

            try {
                //Trying to find the user by the user's id
                $user = User::findOrFail($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }
            // Checking if we found the user

            if ( !$user ) {

                // If we didn't we redirect back the user with warning message
                Session::flash('message', 'We are sorry we could not found the user!!');
                Session::flash('class', 'alert-warning');

                return redirect()->back();

            }

            /*
            *Recieve the validated data 
            */

            $data = $request->validated();

            try {
                // Updating the user role in the pivot table
                $user->roles()->sync([1 => ['role_id' => $data['role_id']]]);

                //Updateing the user status in the users_status table
                $user->status->update($data);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            // Message to the usser if the update was succesfull
            Session::flash('message', 'We succesfully updated the user\' data!');
            Session::flash('class', 'alert-success');

            //Redirect back the user
            return redirect()->route('admin.users.index');

        } else {

            /* If the user doesn't have
            * permission we redirect him to the home page
            */

            return redirect('home');

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
        if ( Gate::forUser(Auth::user())->allows('user.delete') ) {

            try {

                $user = User::where('id','!=',Auth::id())->findOrFail($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            if ( $user->hasAccess(["administrator"]) ) {

                return redirect()->back();

            }

            try {

                $user->delete();
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            if( $user->trashed() ) {

                Session::flash('message', 'We successfully deleted the user!');
                Session::flash('class', 'alert-success');

                return redirect()->route('admin.users.index');
            }

            Session::flash('message', 'Sorry ,We couldn\'t delete the user!');
            Session::flash('class', 'alert-warning');

            return redirect()->route('admin.users.index');

        }  else {

            /* If the user doesn't have
            * permission we redirect him to the home page
            */

            return redirect('home');

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
        if ( Gate::forUser(Auth::user())->allows('user.view') ) {

            try {

                $user = User::onlyTrashed()->find($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            try {

                $user->restore();
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            if( $user->trashed() ) {

                Session::flash('message', 'We couldn\'t restore the user!');
                Session::flash('class', 'alert-warning');

                return redirect('admin.users.index');
            }

            Session::flash('message', 'We successfully restored the user!');
            Session::flash('class', 'alert-success');

            return redirect()->route('admin.users.index');

        } else {

            /* If the user doesn't have
            * permission we redirect him to the home page
            */

            return redirect('home');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdminSearchUserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(AdminSearchUserRequest $request, $id)
    {
        /*
        *Check if the user has permission to this method
        * 
        */

        if ( Gate::forUser(Auth::user())->allows('user.view') ) {
            try {

                $user = User::where('id','!=',Auth::id())->withTrashed()->findOrFail($id);
    
            } catch(\Exception $e) {
    
                return $e->getMessage();
            }

            return view('admin.users.edit',['user' => $user]);

        } else {

            /* If the user doesn't have
            * permission we redirect him to the home page
            */

            return redirect('home');

        }
    }
}
