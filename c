[1mdiff --git a/app/Http/Controllers/AdminUsersController.php b/app/Http/Controllers/AdminUsersController.php[m
[1mindex 4368c82..68f0b3d 100644[m
[1m--- a/app/Http/Controllers/AdminUsersController.php[m
[1m+++ b/app/Http/Controllers/AdminUsersController.php[m
[36m@@ -22,7 +22,7 @@[m [mclass AdminUsersController extends Controller[m
         *Check if the user has permission to this method[m
         */[m
 [m
[31m-        if ( Gate::forUser(Auth::user())->allows('user.view') ) {[m
[32m+[m[32m        if ( Gate::forUser(Auth::user())->allows('admin-user.view') ) {[m
 [m
             //Check the $request if it caontains any filter[m
             if( $request->get('name') === "all" && $request->get('status') === "all" && $request->get('usersstatus') === "all" || count($request->all()) === 0 ) {[m
[36m@@ -151,7 +151,7 @@[m [mclass AdminUsersController extends Controller[m
         *Check if the user has permission to this method[m
         */[m
 [m
[31m-        if ( Gate::forUser(Auth::user())->allows('user.view') ) {[m
[32m+[m[32m        if ( Gate::forUser(Auth::user())->allows('admin-user.view') ) {[m
 [m
             //Let's try to find the user but we do not want the currenttly authenticated user[m
 [m
[36m@@ -200,7 +200,7 @@[m [mclass AdminUsersController extends Controller[m
         *Check if the user has permission to this method[m
         */[m
 [m
[31m-        if ( Gate::forUser(Auth::user())->allows('user.view') ) {[m
[32m+[m[32m        if ( Gate::forUser(Auth::user())->allows('admin-user.view') ) {[m
 [m
             //Check if the id is numeric[m
             if ( !is_numeric($id) ) {[m
[36m@@ -263,7 +263,7 @@[m [mclass AdminUsersController extends Controller[m
         *Check if the user has permission to this method[m
         */[m
 [m
[31m-        if ( Gate::forUser(Auth::user())->allows('user.update') ) {[m
[32m+[m[32m        if ( Gate::forUser(Auth::user())->allows('admin-user.update') ) {[m
 [m
             //Check if the id is numeric[m
             if ( !is_numeric($id) ) {[m
[36m@@ -351,7 +351,7 @@[m [mclass AdminUsersController extends Controller[m
         /*[m
         *Check if the user has permission to this method[m
         */[m
[31m-        if ( Gate::forUser(Auth::user())->allows('user.delete') ) {[m
[32m+[m[32m        if ( Gate::forUser(Auth::user())->allows('admin-user.delete') ) {[m
 [m
             //Check if the id is numeric[m
             if ( !is_numeric($id) ) {[m
[36m@@ -424,7 +424,7 @@[m [mclass AdminUsersController extends Controller[m
         /*[m
         *Check if the user has permission to this method[m
         */[m
[31m-        if ( Gate::forUser(Auth::user())->allows('user.view') ) {[m
[32m+[m[32m        if ( Gate::forUser(Auth::user())->allows('admin-user.view') ) {[m
 [m
             //Check if the id is numeric[m
             if ( !is_numeric($id) ) {[m
[36m@@ -508,7 +508,7 @@[m [mclass AdminUsersController extends Controller[m
         * [m
         */[m
 [m
[31m-        if ( Gate::forUser(Auth::user())->allows('user.view') ) {[m
[32m+[m[32m        if ( Gate::forUser(Auth::user())->allows('admin-user.view') ) {[m
 [m
             try {[m
 [m
[1mdiff --git a/app/Http/Controllers/UserController.php b/app/Http/Controllers/UserController.php[m
[1mnew file mode 100644[m
[1mindex 0000000..18a82c8[m
[1m--- /dev/null[m
[1m+++ b/app/Http/Controllers/UserController.php[m
[36m@@ -0,0 +1,104 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App\Http\Controllers;[m
[32m+[m
[32m+[m[32muse Session;[m
[32m+[m[32muse Illuminate\Http\Request;[m
[32m+[m[32muse Illuminate\Support\Facades\{Gate,Auth,DB};[m
[32m+[m[32muse App\{User,Role,Comment};[m
[32m+[m[32muse App\Http\Requests\CommentRequest;[m
[32m+[m
[32m+[m[32mclass UserController extends Controller[m
[32m+[m[32m{[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Display a listing of the resource.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @return \Illuminate\Http\Response[m
[32m+[m[32m     */[m
[32m+[m[32m    public function index()[m
[32m+[m[32m    {[m
[32m+[m[32m        /*[m
[32m+[m[32m        *Check if the user has permission to this method[m
[32m+[m[32m        */[m
[32m+[m
[32m+[m[32m        try {[m
[32m+[m
[32m+[m[32m            $user = User::findOrFail(Auth::id());[m
[32m+[m
[32m+[m[32m        } catch ( \Exception $e) {[m
[32m+[m
[32m+[m[32m            return $e->getMessage();[m
[32m+[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m[32m        if ( Gate::forUser(Auth::user())->allows('user.view', $user) ) {[m
[32m+[m
[32m+[m[32m            try {[m
[32m+[m
[32m+[m[32m                $comments = Comment::all()->where('user_id',Auth::id());[m
[32m+[m[41m                [m
[32m+[m[32m            } catch ( \Exception $e) {[m
[32m+[m
[32m+[m[32m                return $e->getMessage();[m
[32m+[m
[32m+[m[32m            }[m
[32m+[m
[32m+[m[32m            return view('user.profile',['user' => $user,'comments' => $comments]);[m
[32m+[m
[32m+[m[32m        } else {[m
[32m+[m
[32m+[m[32m            /*[m
[32m+[m[32m            * If the user doesn't have permission redirect to homepage[m
[32m+[m[32m            */[m
[32m+[m
[32m+[m[32m            return redirect()->route('login');[m
[32m+[m[32m        }[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Store a newly created resource in storage.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @param  \Illuminate\Http\Request  $request[m
[32m+[m[32m     * @return \Illuminate\Http\Response[m
[32m+[m[32m     */[m
[32m+[m[32m    public function store(Request $request)[m
[32m+[m[32m    {[m
[32m+[m[32m        //[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Show the form for editing the specified resource.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @param  int  $id[m
[32m+[m[32m     * @return \Illuminate\Http\Response[m
[32m+[m[32m     */[m
[32m+[m[32m    public function edit($id)[m
[32m+[m[32m    {[m
[32m+[m[32m        try {[m
[32m+[m
[32m+[m[32m            $user = User::findOrFail(Auth::id());[m
[32m+[m
[32m+[m[32m        } catch ( \Exception $e) {[m
[32m+[m
[32m+[m[32m            return $e->getMessage();[m
[32m+[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m[32m        return view('user.edit',['user' => $user]);[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Update the specified resource in storage.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @param  \Illuminate\Http\Request  $request[m
[32m+[m[32m     * @param  int  $id[m
[32m+[m[32m     * @return \Illuminate\Http\Response[m
[32m+[m[32m     */[m
[32m+[m[32m    public function update(Request $request, $id)[m
[32m+[m[32m    {[m
[32m+[m[32m        //[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m}[m
[1mdiff --git a/app/Http/Requests/UserRequest.php b/app/Http/Requests/UserRequest.php[m
[1mindex a9bfb95..75af019 100644[m
[1m--- a/app/Http/Requests/UserRequest.php[m
[1m+++ b/app/Http/Requests/UserRequest.php[m
[36m@@ -28,7 +28,6 @@[m [mclass UserRequest extends FormRequest[m
             'last_name' => 'required|alpha|string|max:20',[m
             'email' => 'required|email|unique:users,email'.$this->id,[m
             'birthdate' => 'required|date_format:"Y-m-d"',[m
[31m-            'password' => 'required|min:6|confirm',[m
         ];[m
     }[m
 [m
[36m@@ -44,7 +43,6 @@[m [mclass UserRequest extends FormRequest[m
             'last_name' => '',[m
             'email' => '',[m
             'birthdate' => '',[m
[31m-            'password' => '',[m
         ];[m
     }[m
 }[m
[1mdiff --git a/app/Policies/UserPolicy.php b/app/Policies/UserPolicy.php[m
[1mnew file mode 100644[m
[1mindex 0000000..21ea14c[m
[1m--- /dev/null[m
[1m+++ b/app/Policies/UserPolicy.php[m
[36m@@ -0,0 +1,46 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App\Policies;[m
[32m+[m
[32m+[m[32muse App\User;[m
[32m+[m[32muse Illuminate\Auth\Access\HandlesAuthorization;[m
[32m+[m[32muse Illuminate\Support\Facades\{Auth};[m
[32m+[m[32mclass UserPolicy[m
[32m+[m[32m{[m
[32m+[m[32m    use HandlesAuthorization;[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Determine whether the user can view the model.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @param  \App\User  $user[m
[32m+[m[32m     * @param  \App\User  $model[m
[32m+[m[32m     * @return mixed[m
[32m+[m[32m     */[m
[32m+[m[32m    public function view(User $user, User $model)[m
[32m+[m[32m    {[m
[32m+[m[32m        return $user->id == $model->id;[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Determine whether the user can edit models.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @param  \App\User  $user[m
[32m+[m[32m     * @return mixed[m
[32m+[m[32m     */[m
[32m+[m[32m    public function edit(User $user)[m
[32m+[m[32m    {[m
[32m+[m[32m        return true;[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * Determine whether the user can update the model.[m
[32m+[m[32m     *[m
[32m+[m[32m     * @param  \App\User  $user[m
[32m+[m[32m     * @param  \App\User  $model[m
[32m+[m[32m     * @return mixed[m
[32m+[m[32m     */[m
[32m+[m[32m    public function update(User $user, User $model)[m
[32m+[m[32m    {[m
[32m+[m[32m        return true;[m
[32m+[m[32m    }[m
[32m+[m[32m}[m
[1mdiff --git a/app/Providers/AuthServiceProvider.php b/app/Providers/AuthServiceProvider.php[m
[1mindex 53a06fb..8e6d4a2 100644[m
[1m--- a/app/Providers/AuthServiceProvider.php[m
[1m+++ b/app/Providers/AuthServiceProvider.php[m
[36m@@ -21,7 +21,10 @@[m [mclass AuthServiceProvider extends ServiceProvider[m
                         'App\Policies\AuthorPostPolicy',[m
                         'App\Policies\AdminPostPolicy'[m
                         ],[m
[31m-        'App\User' => 'App\Policies\AdminUserPolicy',[m
[32m+[m[32m        'App\User' => [[m
[32m+[m[32m                        'App\Policies\AdminUserPolicy',[m
[32m+[m[32m                        'App\Policies\UserPolicy'[m
[32m+[m[32m                        ],[m
         'App\Boat' => 'App\Policies\AdminBoatPolicy',[m
         'App\Comment' => 'App\Policies\CommentPolicy',[m
     ];[m
[36m@@ -35,17 +38,25 @@[m [mclass AuthServiceProvider extends ServiceProvider[m
     {[m
         $this->registerPolicies();[m
 [m
[31m-        Gate::resource('post', 'App\Policies\AuthorPostPolicy');[m
[31m-        Gate::define('post.restore', 'App\Policies\AuthorPostPolicy@restore');[m
[32m+[m[32m        Gate::resource('post', 'App\Policies\AuthorPostPolicy', [[m
[32m+[m[32m            'restore' => 'restore'[m
[32m+[m[32m        ]);[m
 [m
[31m-        Gate::resource('admin-post', 'App\Policies\AdminPostPolicy');[m
[31m-        Gate::define('admin-post.restore', 'App\Policies\AdminPostPolicy@restore');[m
[31m-        Gate::define('admin-post.edit', 'App\Policies\AdminPostPolicy@edit');[m
[32m+[m[32m        Gate::resource('admin-post', 'App\Policies\AdminPostPolicy', [[m
[32m+[m[32m            'restore' => 'restore',[m
[32m+[m[32m            'edit'    => 'edit'[m
[32m+[m[32m        ]);[m
         [m
[31m-        Gate::resource('user', 'App\Policies\AdminUserPolicy');[m
[32m+[m[32m        Gate::resource('admin-user', 'App\Policies\AdminUserPolicy');[m
[32m+[m
         Gate::resource('boat', 'App\Policies\AdminBoatPolicy');[m
         Gate::resource('comment', 'App\Policies\CommentPolicy');[m
 [m
[32m+[m[32m        Gate::define('user.view', 'App\Policies\UserPolicy@view');[m
[32m+[m[32m        Gate::define('user.edit', 'App\Policies\UserPolicy@edit');[m
[32m+[m[32m        Gate::define('user.update', 'App\Policies\UserPolicy@update');[m
[32m+[m
[32m+[m
         Gate::define('admin-menu', function ($user) {[m
             return $user->hasAccess(['administrator']);[m
         });[m
[1mdiff --git a/app/User.php b/app/User.php[m
[1mindex 952c587..93284e4 100644[m
[1m--- a/app/User.php[m
[1m+++ b/app/User.php[m
[36m@@ -44,7 +44,7 @@[m [mclass User extends Authenticatable[m
 [m
     /**[m
      * Check if the user has access to a task[m
[31m-     * @return string[m
[32m+[m[32m     * @return boolean[m
      */[m
     public function hasAccess(Array $array) {[m
 [m
[1mdiff --git a/resources/views/admin/boats/boat.blade.php b/resources/views/admin/boats/boat.blade.php[m
[1mindex ebcd309..6e972e2 100644[m
[1m--- a/resources/views/admin/boats/boat.blade.php[m
[1m+++ b/resources/views/admin/boats/boat.blade.php[m
[36m@@ -2,7 +2,7 @@[m
 [m
 @section('content')[m
 [m
[31m-<div class="container p-3 shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">[m
[32m+[m[32m<div class="container p-3 shadow-sm mb-5 rounded" style="background-color: #FFFFFF;">[m
 [m
     @if(empty($boat) || is_null($boat) || !is_object($boat))[m
 [m
[1mdiff --git a/resources/views/admin/boats/create.blade.php b/resources/views/admin/boats/create.blade.php[m
[1mindex b90a4b0..24ed076 100644[m
[1m--- a/resources/views/admin/boats/create.blade.php[m
[1m+++ b/resources/views/admin/boats/create.blade.php[m
[36m@@ -1,7 +1,7 @@[m
 @extends('layouts.main')[m
 [m
 @section('content')[m
[31m-<div class="container p-3 shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">[m
[32m+[m[32m<div class="container p-3 shadow-sm mb-5 rounded" style="background-color: #FFFFFF;">[m
     <h1 class="display-4 text-left mb-3">Create Boat</h1>[m
 [m
 [m
[1mdiff --git a/resources/views/admin/boats/edit.blade.php b/resources/views/admin/boats/edit.blade.php[m
[1mindex 3445df3..3255688 100644[m
[1m--- a/resources/views/admin/boats/edit.blade.php[m
[1m+++ b/resources/views/admin/boats/edit.blade.php[m
[36m@@ -1,7 +1,7 @@[m
 @extends('layouts.main')[m
 [m
 @section('content')[m
[31m-<div class="container p-3 shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">[m
[32m+[m[32m<div class="container shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">[m
     <h1 class="display-4 text-left mb-3">Edit Boat</h1>[m
     @if(empty($boat) || is_null($boat) || !is_object($boat))[m
 [m
[1mdiff --git a/resources/views/admin/posts/create.blade.php b/resources/views/admin/posts/create.blade.php[m
[1mindex 32f068b..d0e0bf5 100644[m
[1m--- a/resources/views/admin/posts/create.blade.php[m
[1m+++ b/resources/views/admin/posts/create.blade.php[m
[36m@@ -3,7 +3,7 @@[m
 [m
 @section('content')[m
 [m
[31m-<div class="container p-3 rounded" style="background-color: #FFFFFF;">[m
[32m+[m[32m<div class="container shadow-sm p-3 rounded" style="background-color: #FFFFFF;">[m
 <h1 class="display-4 text-left mb-3">Create News</h1>[m
     <form action="{{ action('AdminPostsController@store') }}" method="POST" enctype="multipart/form-data">[m
 [m
[1mdiff --git a/resources/views/admin/posts/edit.blade.php b/resources/views/admin/posts/edit.blade.php[m
[1mindex a147bf7..2d57b05 100644[m
[1m--- a/resources/views/admin/posts/edit.blade.php[m
[1m+++ b/resources/views/admin/posts/edit.blade.php[m
[36m@@ -16,7 +16,7 @@[m
 @section('content')[m
 [m
 [m
[31m-<div class="container p-3 rounded" style="background-color: #FFFFFF;">[m
[32m+[m[32m<div class="container shadow-sm p-3 rounded" style="background-color: #FFFFFF;">[m
 <h1 class="display-4 text-left mb-3">Edit News</h1>[m
     @include('includes.errors')[m
     @include('includes.alert')[m
[1mdiff --git a/resources/views/auth/register.blade.php b/resources/views/auth/register.blade.php[m
[1mindex 623dff1..072830f 100644[m
[1m--- a/resources/views/auth/register.blade.php[m
[1m+++ b/resources/views/auth/register.blade.php[m
[36m@@ -56,11 +56,11 @@[m
       @method('POST')[m
       <div class="form-group">[m
         <label for="first_name">First Name</label>[m
[31m-        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') ?? '' }}" >[m
[32m+[m[32m        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name') ?? '' }}" required>[m
       </div>[m
       <div class="form-group">[m
         <label for="last_name">Last Name</label>[m
[31m-        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="First Name" value="{{ old('last_name') ?? '' }}" >[m
[32m+[m[32m        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="First Name" value="{{ old('last_name') ?? '' }}" required>[m
       </div>[m
       <div class="form-group">[m
         <label for="email">Email</label>[m
[36m@@ -68,15 +68,15 @@[m
       </div>[m
       <div class="form-group">[m
         <label for="birthdate">Date</label>[m
[31m-        <input type="text" name="birthdate" id="birthdate" class="form-control" placeholder="" value="{{ old('birthdate') ?? '' }}" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" >[m
[32m+[m[32m        <input type="text" name="birthdate" id="birthdate" class="form-control" placeholder="" value="{{ old('birthdate') ?? '' }}" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required>[m
       </div>[m
       <div class="form-group">[m
         <label for="password">Password</label>[m
[31m-        <input type="password" name="password" id="password" class="form-control" placeholder="*******" value="{{ old('password') ?? '' }}" >[m
[32m+[m[32m        <input type="password" name="password" id="password" class="form-control" placeholder="*******" value="{{ old('password') ?? '' }}" required>[m
       </div>[m
       <div class="form-group">[m
         <label for="password_confirmation">Password</label>[m
[31m-        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="*******" value="{{ old('password') ?? '' }}" >[m
[32m+[m[32m        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="*******" value="{{ old('password') ?? '' }}" required>[m
       </div>[m
       <div class="form-group">[m
         <button type="submit" class="btnSubmit">Register</button>[m
[1mdiff --git a/resources/views/comment/edit.blade.php b/resources/views/comment/edit.blade.php[m
[1mdeleted file mode 100644[m
[1mindex e69de29..0000000[m
[1mdiff --git a/resources/views/includes/navs/main-nav.blade.php b/resources/views/includes/navs/main-nav.blade.php[m
[1mindex bbd2c59..ea70317 100644[m
[1m--- a/resources/views/includes/navs/main-nav.blade.php[m
[1m+++ b/resources/views/includes/navs/main-nav.blade.php[m
[36m@@ -140,7 +140,7 @@[m
                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">[m
 [m
                     <!-- Clicking on this button user can check his profile and change profile data ... if i start doing it .... -->[m
[31m-                    <a class="dropdown-item" href="#">[m
[32m+[m[32m                    <a class="dropdown-item" href="{{ route('user.index') }}">[m
                         <svg style="width:24px;height:24px" viewBox="0 0 24 24">[m
                             <path fill="black" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />[m
                         </svg>[m
[1mdiff --git a/resources/views/user/edit.blade.php b/resources/views/user/edit.blade.php[m
[1mnew file mode 100644[m
[1mindex 0000000..06a7a9e[m
[1m--- /dev/null[m
[1m+++ b/resources/views/user/edit.blade.php[m
[36m@@ -0,0 +1,201 @@[m
[32m+[m[32m@extends('layouts.main')[m
[32m+[m
[32m+[m[32m@section('content')[m
[32m+[m
[32m+[m[32m<style>[m
[32m+[m[32m.img-circle {[m
[32m+[m[32m    border-radius: 50%;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.left-to-top {[m
[32m+[m[32m    border-top: 3px solid transparent;[m
[32m+[m[32m    border-left: 5px solid transparent;[m
[32m+[m[32m    border-image: linear-gradient(to bottom, #f77062 0%, #fe5196 100%);[m
[32m+[m[32m    border-image-slice: 1;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.col-content {[m
[32m+[m[32m    border-left: 5px solid transparent;[m
[32m+[m[32m    border-image: linear-gradient(to top, #f77062 0%, #fe5196 100%);[m
[32m+[m[32m    border-image-slice: 1;[m
[32m+[m[32m    box-shadow:0 15px 25px rgba(0,0,0,.2);[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.btnSubmit {[m
[32m+[m[32m    width: 30%;[m
[32m+[m[32m    border: 2px solid #4F8C6C;[m
[32m+[m[32m    border-radius: 2rem;[m
[32m+[m[32m    padding: 1.5%;[m
[32m+[m[32m    cursor: pointer;[m
[32m+[m[32m    color: #4F8C6C;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.btnSubmit:hover,[m
[32m+[m[32m.btnSubmit:focus {[m[41m [m
[32m+[m[32m    color: #fff;[m
[32m+[m[32m    text-decoration:none;[m
[32m+[m[32m    background-color: #4F8C6C[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.btnSubmit{[m
[32m+[m[32m    font-weight: 600;[m
[32m+[m[32m    background-color: transparent;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.btnSubmit:hover path,[m
[32m+[m[32m.btnSubmit:focus  path {[m
[32m+[m[32m    fill: #fff;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m</style>[m
[32m+[m
[32m+[m[32m<div class="container rounded p-3 shadow-sm mb-5" style="background-color: #FFFFFF;">[m
[32m+[m[32m    <!-- The user\s profile picture -->[m
[32m+[m[32m    <div class="row mb-4 justify-content-center">[m
[32m+[m[32m        <img src="https://via.placeholder.com/350x350" class="mx-auto img-circle" alt='User\'s profile picture.' >[m
[32m+[m[32m    </div>[m
[32m+[m[32m    <!-- -->[m
[32m+[m
[32m+[m[32m    <div class="row justify-content-center">[m
[32m+[m[32m        <div class="col-lg-11 col-md-10 col-sm-10 left-to-top pl-3">[m
[32m+[m[32m        <h1 class="mb-0 display-4">{{ $user->getFullName() }}</h1>[m
[32m+[m[32m        </div>[m
[32m+[m[32m    </div>[m
[32m+[m
[32m+[m
[32m+[m
[32m+[m[32m    <div class="row my-2 justify-content-center">[m
[32m+[m[32m        <!-- User's personal Data -->[m
[32m+[m[32m        <div class="col-lg-5 my-2 col-md-10 col-sm-10 col-xs-12 col-content p-2">[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-12">[m
[32m+[m[32m                    <p class="lead">Personal Data</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- The First name of the user -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p class="font-weight-bold">First Name</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <div class="col-8">[m
[32m+[m[32m                  <input type="text" value="{{ $user->first_name }}" class="form-control" name="first_name" id="first_name" placeholder="Johnny" required>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m
[32m+[m[32m            <!-- Last Name of the user -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p class="font-weight-bold">Last Name</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <div class="col-8">[m
[32m+[m[32m                    <input type="text" value="{{ $user->last_name }}" class="form-control" name="first_name" id="first_name" placeholder="Cash" required>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m
[32m+[m[32m            <!-- The user's email address -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p class="font-weight-bold">Email</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <div class="col-8">[m
[32m+[m[32m                    <input type="email" value="{{ $user->email }}" class="form-control" name="first_name" id="first_name" placeholder="example@gmail.com" required>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m
[32m+[m[32m            <!-- The birthdate of the user -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p class="font-weight-bold">BirthDate</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <div class="col-8">[m
[32m+[m[32m                    <input type="text" value="{{ $user->birthdate }}" class="form-control" name="birthdate" id="birthdate" placeholder="2000-01-01" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m
[32m+[m[32m            <!-- Save Form -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-12 align-self-end">[m
[32m+[m[32m                    <form action="{{ action('UserController@update', [ 'id' => $user->id ] ) }}" method="POST">[m
[32m+[m[32m                        @csrf[m
[32m+[m[32m                        @method('POST')[m
[32m+[m[32m                        <button type="submit" class="btnSubmit m-2 float-right">[m
[32m+[m[32m                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">[m
[32m+[m[32m                                <path fill="#4F8C6C" d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z" />[m
[32m+[m[32m                            </svg>[m
[32m+[m[32m                            Save[m
[32m+[m[32m                        </button>[m
[32m+[m[32m                    </form>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m[41m            [m
[32m+[m[32m            <!-- Includeing errors -->[m
[32m+[m[32m            @include('includes.errors')[m
[32m+[m[32m            <!-- -->[m
[32m+[m
[32m+[m[32m        </div>[m
[32m+[m[32m        <!-- -->[m
[32m+[m
[32m+[m[32m        <!-- Some extra information about the user -->[m
[32m+[m[32m        <div class="col-lg-5 my-2 col-md-10 col-sm-10 col-xs-12 col-content offset-lg-1 offset-md-0 offset-xs-0 offset-sm-0 p-2">[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-12">[m
[32m+[m[32m                    <p class="lead">Statistics</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m                <!-- Number of reservation that the user made -->[m
[32m+[m[32m                <div class="row">[m
[32m+[m[32m                    <div class="col-6">[m
[32m+[m[32m                        <p class="font-weight-bold">Number of Reservation made</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                    <div class="col-4">[m
[32m+[m[32m                        <p>{{ $user->reservations->count() == 0 ? "No Reservation Made..." : $user->reservations->count() }}</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <!-- -->[m
[32m+[m
[32m+[m[32m                <!-- Number of the comments that the user made-->[m
[32m+[m[32m                <div class="row">[m
[32m+[m[32m                    <div class="col-6">[m
[32m+[m[32m                        <p class="font-weight-bold">Number of Comments</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                    <div class="col-4">[m
[32m+[m[32m                        <p>{{ $user->comments->count() == 0 ? "No Thoughts Shared..." : $user->comments->count() }}</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <!-- -->[m
[32m+[m[32m                @can('post.create')[m
[32m+[m[32m                <!-- If the user is author we show how much post the user made -->[m
[32m+[m[32m                <div class="row">[m
[32m+[m[32m                    <div class="col-6">[m
[32m+[m[32m                        <p class="font-weight-bold">Posts Created</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                    <div class="col-4">[m
[32m+[m[32m                        <p>{{ $user->posts->count() == 0 ? "No Post Created..." : $user->posts->count() }}</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <!-- -->[m
[32m+[m[32m                @endcan[m
[32m+[m[32m                <!-- The role what the user has -->[m
[32m+[m[32m                <div class="row">[m
[32m+[m[32m                    <div class="col-6">[m
[32m+[m[32m                        <p class="font-weight-bold">Role</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                    <div class="col-4">[m
[32m+[m[32m                        <p>{{ empty($user->getRole()) ?  "No Role" : $user->getRole()  }}</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <!-- -->[m
[32m+[m
[32m+[m[32m        </div>[m
[32m+[m[32m        <!-- -->[m
[32m+[m[32m    </div>[m
[32m+[m
[32m+[m
[32m+[m[32m</div>[m
[32m+[m
[32m+[m[32m@endsection[m
\ No newline at end of file[m
[1mdiff --git a/resources/views/user/profile.blade.php b/resources/views/user/profile.blade.php[m
[1mnew file mode 100644[m
[1mindex 0000000..6118ebb[m
[1m--- /dev/null[m
[1m+++ b/resources/views/user/profile.blade.php[m
[36m@@ -0,0 +1,258 @@[m
[32m+[m[32m@extends('layouts.main')[m
[32m+[m
[32m+[m[32m@section('content')[m
[32m+[m
[32m+[m[32m<style>[m
[32m+[m[32m.img-circle {[m
[32m+[m[32m    border-radius: 50%;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.left-to-top {[m
[32m+[m[32m    border-top: 3px solid transparent;[m
[32m+[m[32m    border-left: 5px solid transparent;[m
[32m+[m[32m    border-image: linear-gradient(to bottom, #f77062 0%, #fe5196 100%);[m
[32m+[m[32m    border-image-slice: 1;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.col-content {[m
[32m+[m[32m    border-left: 5px solid transparent;[m
[32m+[m[32m    border-image: linear-gradient(to top, #f77062 0%, #fe5196 100%);[m
[32m+[m[32m    border-image-slice: 1;[m
[32m+[m[32m    box-shadow:0 15px 25px rgba(0,0,0,.2);[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.btnSubmit {[m
[32m+[m[32m    width: 30%;[m
[32m+[m[32m    border: 2px solid #FCBC80;[m
[32m+[m[32m    border-radius: 2rem;[m
[32m+[m[32m    padding: 1.5%;[m
[32m+[m[32m    cursor: pointer;[m
[32m+[m[32m    color: #FCBC80;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.btnSubmit:hover,[m
[32m+[m[32m.btnSubmit:focus {[m[41m [m
[32m+[m[32m    color: #fff;[m
[32m+[m[32m    text-decoration:none;[m
[32m+[m[32m    background-color: #FCBC80[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.btnSubmit{[m
[32m+[m[32m    font-weight: 600;[m
[32m+[m[32m    background-color: transparent;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m.btnSubmit:hover path,[m
[32m+[m[32m.btnSubmit:focus  path {[m
[32m+[m[32m    fill: #fff;[m
[32m+[m[32m}[m
[32m+[m
[32m+[m[32m</style>[m
[32m+[m
[32m+[m[32m<div class="container rounded p-3 shadow-sm mb-5" style="background-color: #FFFFFF;">[m
[32m+[m[32m    <!-- The user\s profile picture -->[m
[32m+[m[32m    <div class="row mb-4 justify-content-center">[m
[32m+[m[32m        <img src="https://via.placeholder.com/350x350" class="mx-auto img-circle" alt='User\'s profile picture.' >[m
[32m+[m[32m    </div>[m
[32m+[m[32m    <!-- -->[m
[32m+[m
[32m+[m[32m    <div class="row justify-content-center">[m
[32m+[m[32m        <div class="col-lg-11 col-md-10 col-sm-10 left-to-top pl-3">[m
[32m+[m[32m        <h1 class="mb-0 display-4">{{ $user->getFullName() }}</h1>[m
[32m+[m[32m        </div>[m
[32m+[m[32m    </div>[m
[32m+[m
[32m+[m
[32m+[m
[32m+[m[32m    <div class="row my-2 justify-content-center">[m
[32m+[m[32m        <!-- User's personal Data -->[m
[32m+[m[32m        <div class="col-lg-5 my-2 col-md-10 col-sm-10 col-xs-12 col-content p-2">[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-12">[m
[32m+[m[32m                    <p class="lead">Personal Data</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- The First name of the user -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p class="font-weight-bold">First Name</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p>{{ $user->first_name }}</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m
[32m+[m[32m            <!-- Last Name of the user -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p class="font-weight-bold">Last Name</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p>{{ $user->last_name }}</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m
[32m+[m[32m            <!-- The user's email address -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p class="font-weight-bold">Email</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p>{{ $user->email }}</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m
[32m+[m[32m            <!-- The birthdate of the user -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p class="font-weight-bold">BirthDate</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <div class="col-4">[m
[32m+[m[32m                    <p>{{ $user->birthdate }}</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m            <!-- -->[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-12 align-self-end">[m
[32m+[m[32m                    <form action="{{ action('UserController@edit', ['id' => $user->id] ) }}" method="POST">[m
[32m+[m[32m                        @csrf[m
[32m+[m[32m                        @method('GET')[m
[32m+[m[32m                        <button type="submit" class="btnSubmit m-2 float-right">[m
[32m+[m[32m                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">[m
[32m+[m[32m                                <path fill="#FCBC80" d="M21.7,13.35L20.7,14.35L18.65,12.3L19.65,11.3C19.86,11.09 20.21,11.09 20.42,11.3L21.7,12.58C21.91,12.79 21.91,13.14 21.7,13.35M12,18.94L18.06,12.88L20.11,14.93L14.06,21H12V18.94M12,14C7.58,14 4,15.79 4,18V20H10V18.11L14,14.11C13.34,14.03 12.67,14 12,14M12,4A4,4 0 0,0 8,8A4,4 0 0,0 12,12A4,4 0 0,0 16,8A4,4 0 0,0 12,4Z" />[m
[32m+[m[32m                            </svg>[m
[32m+[m[32m                            Edit[m
[32m+[m[32m                        </button>[m
[32m+[m[32m                    </form>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m        </div>[m
[32m+[m[32m        <!-- -->[m
[32m+[m
[32m+[m[32m        <!-- Some extra information about the user -->[m
[32m+[m[32m        <div class="col-lg-5 my-2 col-md-10 col-sm-10 col-xs-12 col-content offset-lg-1 offset-md-0 offset-xs-0 offset-sm-0 p-2">[m
[32m+[m[32m            <div class="row">[m
[32m+[m[32m                <div class="col-12">[m
[32m+[m[32m                    <p class="lead">Statistics</p>[m
[32m+[m[32m                </div>[m
[32m+[m[32m            </div>[m
[32m+[m[32m                <!-- Number of reservation that the user made -->[m
[32m+[m[32m                <div class="row">[m
[32m+[m[32m                    <div class="col-6">[m
[32m+[m[32m                        <p class="font-weight-bold">Number of Reservation made</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                    <div class="col-4">[m
[32m+[m[32m                        <p>{{ $user->reservations->count() == 0 ? "No Reservation Made..." : $user->reservations->count() }}</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <!-- -->[m
[32m+[m
[32m+[m[32m                <!-- Number of the comments that the user made-->[m
[32m+[m[32m                <div class="row">[m
[32m+[m[32m                    <div class="col-6">[m
[32m+[m[32m                        <p class="font-weight-bold">Number of Comments</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                    <div class="col-4">[m
[32m+[m[32m                        <p>{{ $user->comments->count() == 0 ? "No Thoughts Shared..." : $user->comments->count() }}</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <!-- -->[m
[32m+[m[32m                @can('post.create')[m
[32m+[m[32m                <!-- If the user is author we show how much post the user made -->[m
[32m+[m[32m                <div class="row">[m
[32m+[m[32m                    <div class="col-6">[m
[32m+[m[32m                        <p class="font-weight-bold">Posts Created</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                    <div class="col-4">[m
[32m+[m[32m                        <p>{{ $user->posts->count() == 0 ? "No Post Created..." : $user->posts->count() }}</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <!-- -->[m
[32m+[m[32m                @endcan[m
[32m+[m[32m                <!-- The role what the user has -->[m
[32m+[m[32m                <div class="row">[m
[32m+[m[32m                    <div class="col-6">[m
[32m+[m[32m                        <p class="font-weight-bold">Role</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                    <div class="col-4">[m
[32m+[m[32m                        <p>{{ empty($user->getRole()) ?  "No Role" : $user->getRole()  }}</p>[m
[32m+[m[32m                    </div>[m
[32m+[m[32m                </div>[m
[32m+[m[32m                <!-- -->[m
[32m+[m
[32m+[m[32m        </div>[m
[32m+[m[32m        <!-- -->[m
[32m+[m[32m    </div>[m
[32m+[m
[32m+[m
[32m+[m[32m</div>[m
[32m+[m
[32m+[m[32m<div class="container rounded p-3 shadow-sm mb-5" style="background-color: #FFFFFF;">[m
[32m+[m[32m@if(empty($comments) || is_null($comments) || !isset($comments) || count($comments) < 0)[m
[32m+[m[32m    <div class="row justify-content-center">[m
[32m+[m[32m        <div class="col-lg-11 col-md-10 col-sm-10 left-to-top pl-3">[m
[32m+[m[32m            <h1 class="mb-0 display-4">No Comments</h1>[m
[32m+[m[32m        </div>[m
[32m+[m[32m    </div>[m
[32m+[m[32m@else[m
[32m+[m[32m    <div class="row justify-content-center mb-2">[m
[32m+[m[32m        <div class="col-lg-11 col-md-10 col-sm-10 left-to-top pl-3">[m
[32m+[m[32m            <h1 class="mb-0 display-4">Comments</h1>[m
[32m+[m[32m        </div>[m
[32m+[m[32m    </div>[m
[32m+[m[32m    @include('includes.alert')[m
[32m+[m[32m    <div class="row justify-content-center">[m
[32m+[m[32m        <div class="col-lg-11 col-md-10 col-sm-10">[m
[32m+[m[32m            <table class="table table-hover table-responsive-md table-sm">[m
[32m+[m[32m                <caption>Your Comments</caption>[m
[32m+[m[32m                <thead>[m
[32m+[m[32m                    <tr>[m
[32m+[m[32m                        <th scope="col">#</th>[m
[32m+[m[32m                        <th scope="col">Post Title</th>[m
[32m+[m[32m                        <th scope="col">Comment</th>[m
[32m+[m[32m                        <th scope="col">Created at</th>[m
[32m+[m[32m                        <th scope="col">Check</th>[m
[32m+[m[32m                        <th scope="col">Delete</th>[m
[32m+[m[32m                    </tr>[m
[32m+[m[32m                </thead>[m
[32m+[m[32m                <tbody>[m
[32m+[m
[32m+[m[32m                @foreach($comments as $comment)[m
[32m+[m[32m                    <tr>[m
[32m+[m[32m                        <th scope="row">{{ $comment->id }}</th>[m
[32m+[m[32m                        <td>{{ $comment->post->title }}</a></td>[m
[32m+[m[32m                        <td>{{ strlen($comment->body) >= 15 ? substr($comment->body, 0, 15) . " ... "  : $comment->body}}</td>[m
[32m+[m[32m                        <td>{{ $comment->created_at }}</td>[m
[32m+[m[32m                        <td>[m
[32m+[m[32m                            <a class="" href="{{ route('post', ['id' => $comment->post->id] ) }}" alt="Check user profile">[m
[32m+[m[32m                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">[m
[32m+[m[32m                                    <path fill="grey" d="M20,12V16C20,17.11 19.11,18 18,18H13.9L10.2,21.71C10,21.89 9.76,22 9.5,22H9A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V6C2,4.89 2.9,4 4,4H9.5C8.95,4.67 8.5,5.42 8.14,6.25L7.85,7L8.14,7.75C9.43,10.94 12.5,13 16,13C17.44,13 18.8,12.63 20,12M16,6C16.56,6 17,6.44 17,7C17,7.56 16.56,8 16,8C15.44,8 15,7.56 15,7C15,6.44 15.44,6 16,6M16,3C18.73,3 21.06,4.66 22,7C21.06,9.34 18.73,11 16,11C13.27,11 10.94,9.34 10,7C10.94,4.66 13.27,3 16,3M16,4.5A2.5,2.5 0 0,0 13.5,7A2.5,2.5 0 0,0 16,9.5A2.5,2.5 0 0,0 18.5,7A2.5,2.5 0 0,0 16,4.5" />[m
[32m+[m[32m                                </svg>[m
[32m+[m[32m                            </a>[m
[32m+[m[32m                        </td>[m
[32m+[m[32m                        <td>[m
[32m+[m[32m                            <form method="POST" action="{{ action('CommentsController@destroy', ['id' => $comment->id]) }}">[m
[32m+[m[32m                                @csrf[m
[32m+[m[32m                                @method('DELETE')[m
[32m+[m[32m                                <a type="submit" alt="Delete">[m
[32m+[m[32m                                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">[m
[32m+[m[32m                                        <path fill="grey" d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19Z" />[m
[32m+[m[32m                                    </svg>[m
[32m+[m[32m                                </a>[m
[32m+[m[32m                            </form>[m
[32m+[m[32m                        </td>[m
[32m+[m[32m                    </tr>[m
[32m+[m[32m                @endforeach[m
[32m+[m
[32m+[m[32m                </tbody>[m
[32m+[m[32m            </table>[m
[32m+[m[32m        </div>[m
[32m+[m[32m    </div>[m
[32m+[m
[32m+[m[32m@endif[m
[32m+[m[32m</div>[m
[32m+[m
[32m+[m[32m@endsection[m
\ No newline at end of file[m
[1mdiff --git a/routes/web.php b/routes/web.php[m
[1mindex a23ac80..2da9b7e 100644[m
[1m--- a/routes/web.php[m
[1m+++ b/routes/web.php[m
[36m@@ -35,6 +35,15 @@[m [mRoute::group(['middleware' => ['auth']], function () {[m
 [m
     Route::resource('/comments', 'CommentsController');[m
 [m
[32m+[m[32m    Route::resource('user', 'UserController',[m
[32m+[m[32m    [[m
[32m+[m[32m        'except' => [[m
[32m+[m[32m            'show',[m
[32m+[m[32m            'destroy',[m
[32m+[m[32m            'create',[m
[32m+[m[32m            ][m
[32m+[m[32m    ]);[m
[32m+[m
     //Route for only authenticated admin users[m
     Route::group(['middleware' => ['auth','admin']], function () {[m
         //Author namespace[m
