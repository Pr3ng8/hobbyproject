@extends('layouts.main')

@section('content')
<div class="container shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">
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
                </div>
            </div>
            <div class="col-6">
            <form action="{{ action('AdminUsersController@update', ['id' => $user->id])}}" method="POST">
                <div class="form-group">
                    <label class="font-weight-bold" for="first_name">First Name</label>
                    <p class="font-weight-bold text-primary">{{ $user->first_name }}</p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="last_name">Last Name</label>
                    <p class="font-weight-bold text-primary">{{ $user->last_name }}</p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="email">Emai</label>
                    <p class="font-weight-bold text-primary">{{ $user->email }}</p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="birthdate">Birth Date</label>
                    <p class="font-weight-bold text-primary">{{ $user->birthdate }}</p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="birthdate">Registrated at</label>
                    <p class="font-weight-bold text-primary">{{ $user->created_at->format('M D o h:m:s') }}</p>
                </div>
                @if(empty($roles) || is_null($roles) || !is_object($roles))
                <p class="font-weight-bold text-primary">Sorry, something went wrong!</p>
                @else
                <div class="form-group">
                    <label class="font-weight-bold" for="role_id">User Role</label>
                    <select name="role_id" class="form-control form-control-sm font-weight-bold text-primary">
                        @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->getRole() === $role->name ? 'selected' : ''}} >{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label class="font-weight-bold" for="status">User Status</label>
                    <select name="status" class="form-control form-control-sm font-weight-bold text-primary">
                            @if( $user->hasPermission() === 1)
                                <option select="selected" value="1">Allowed</option>
                                <option value="0">Not Allowed</option>
                            @else
                                <option value="1">Allowed</option>
                                <option select="selected" value="0">Not Allowed</option>
                            @endif
                    </select>
                </div>
                
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success px-4 float-right">Save</button>
                </form>
            </div>
            <div class="col-6">
                @include('includes.errors')
            </div>
        </div>
    </div>
</div>

@endif

</div>

@endsection