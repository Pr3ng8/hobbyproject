@extends('layouts.main')

@section('content')

<div class="container-fluid shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">
<!-- Title of the page -->
<h1 class="display-3 text-left mb-3">Handel Users</h1>
<hr>

<form class="mb-4" method="GET" action="{{ action('AdminUsersController@index') }}">

  <div class="form-row">
    <div class="col">
        <label for="usersrolelistmode">User Role</label>
        <select name="name" class="form-control" id="usersrolelistmode">
            @if(!isset($roles) || is_null($roles) || empty($roles))
                <option value="all" selected>All</option>
            @else
                <option value="all" selected>All</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            @endif

        </select>
    </div>
    <div class="col">
        <label for="userstatuslistmode">Reservation Status</label>
        <select name="status" class="form-control" id="userstatuslistmode">
            <option value="all" selected>All</option>
            <option value="1">Allowed</option>
            <option value="0">Not Allowed</option>
        </select>
    </div>
    <div class="col">
        <label for="userstatuslistmode">User Status</label>
        <select name="usersstatus" class="form-control" id="userstatuslistmode">
            <option value="all" selected>All</option>
            <option value="active">Active Users</option>
            <option value="trashed">Deleted Users</option>
        </select>
    </div>
    <div class="col align-self-end">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </div>
</form>

@if(empty($users) || is_null($users) || !is_iterable($users) || sizeof($users) === 0)

<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <p>No Users </p>
    </div>
</div>

@else

@include('includes.alert')

    <table class="table table-hover table-responsive-md">
        <caption>List of users</caption>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">User Role</th>
                <th scope="col">Permission</th>
                <th scope="col">Check</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
    <tbody>

  @foreach($users as $user)
    <tr>
        <th scope="row">{{ $user->id }}</th>
            <td><a href="{{ route('admin.user.show', ['id' => $user->id] )}}">{{ $user->getFullName() }}</a></td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->getRole() }}</td>
            <td>{{ $user->hasPermission() ? "Allowed" : "Disallowed" }}</td>
            <td>
                <form action="{{ action('AdminUsersController@update', ['id' => $user->id])}}" method="POST">
                    @csrf
                    @method('GET')
                    <button type="submit" class="btn btn-warning">Check</button>
                </form>
            </td>
            <td>
            @if( $user->trashed() )

            <form method="POST" action="{{ action('AdminUsersController@restore', ['id' => $user->id]) }}">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-success">Restore</button>
            </form>

            @else

            <form method="POST" action="{{ action('AdminUsersController@destroy', ['id' => $user->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

            @endif
        </td>
    </tr>
    @endforeach

  </tbody>
</table>

<!-- Pagination  -->
<div class="container d-flex mx-auto">
    <div class="d-flex mx-auto">{{ $users->appends([
    'name' => Request::get('name') ?? 'all',
    'status' => Request::get('status') ?? 'all',
    'usersstatus' => Request::get('usersstatus') ?? 'all'
    ])->links() }}</div>
</div>
<!--  -->

@endif

</div>

@endsection