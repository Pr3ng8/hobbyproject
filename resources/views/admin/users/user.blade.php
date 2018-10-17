@extends('layouts.main')

@section('content')
<div class="container p-3 shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">
@if(empty($user) || is_null($user) || !is_object($user))

<div class="d-flex justify-content-center">We couldn't find the user,sorry!</div>

@else

<div class="row">
    <div class="col-3 border-right">
    <figure class="figure">
        <img src="https://via.placeholder.com/350x150" class="figure-img img-fluid rounded" alt="User's profile picture.">
        <figcaption class="figure-caption">User's profile picture.</figcaption>
    </figure>
    </div>
    <div class="col">
        <div class="row">
            <div class="col-12 border-bottom  mb-2">
                <div class="row p-2">
                    <div class="col">
                        <p class="h5">{{ $user->getFullName() }}</p>
                    </div>
                    <div class="col">
                        <form class="float-right" method="GET" action="{{ action('AdminUsersController@edit', ['id' => $user->id]) }}">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-warning px-4">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <p class="font-weight-bold">First Name</p>
                <p class="font-weight-bold">Last Name</p>
                <p class="font-weight-bold">Email</p>
                <p class="font-weight-bold">Birth Date</p>
                <p class="font-weight-bold">User Role</p>
                <p class="font-weight-bold">User Status</p>
                <p class="font-weight-bold">Registreted at</p>
            </div>
            <div class="col-6">
                <p class="font-weight-bold text-primary">{{ $user->first_name }}</p>
                <p class="font-weight-bold text-primary">{{ $user->last_name }}</p>
                <p class="font-weight-bold text-primary">{{ $user->email }}</p>
                <p class="font-weight-bold text-primary">{{ $user->birthdate }}</p>
                <p class="font-weight-bold text-primary">{{ ucfirst($user->getRole()) }}</p>
                <p class="font-weight-bold text-primary">{{ $user->hasPermission() ? "Allowed" : "Not Allowed" }}</p>
                <p class="font-weight-bold text-primary">{{ $user->created_at->format('M D o h:m:s') }}</p>
            </div>
        </div>
    </div>
</div>

@endif

</div>

@endsection