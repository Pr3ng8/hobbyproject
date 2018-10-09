@extends('layouts.main')

@section('content')

<div class="container p-3 rounded" style="background-color: #FFFFFF;">

@if(empty($users) || is_null($users) || !is_iterable($users) || sizeof($users) === 0)

<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <p>No Users </p>
    </div>
</div>

@else

@if ( Session::has('message') )

<div class="alert {{Session::get('class')}} alert-dismissible fade show" role="alert">
  <strong>{{Session::get('message')}}</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">User Role</th>
                <th scope="col">Permission</th>
            </tr>
        </thead>
    <tbody>

  @foreach($users as $user)
    <tr>
        <th scope="row">{{ $user->id }}</th>
        <td>{{ $user->getFullName() }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->hasAccess() }}</td>
        <td>{{ $user->hasPermission() ? "Allowed" : "Disallowed" }}</td>
        <td>
            <form method="GET" action="{{ action('AdminUsersController@edit', ['id' => $user->id]) }}">
                @csrf
                @method('GET')
                <button type="submit" class="btn btn-warning">Edit</button>
            </form>
        </td>
        <td>
        @if( Request::url() === "http://hobbyproject.localhost/admin/index/trashed" )

        <form method="POST" action="{{ action('AdminUsersController@restore', ['id' => $user->id]) }}">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-danger">Restore</button>
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
@endif

</div>

@endsection