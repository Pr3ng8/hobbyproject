@extends('layouts.main')

@section('content')
<div class="container" style="background-color: #FFFFFF;">
<!-- Title of the page -->
<h1 class="display-3 text-left mb-3">Handel Posts</h1>
<hr>
<nav class="nav">
    <a class="nav-link">
        <form method="GET" action="{{ action('AdminPostsController@index', ['listmode' => 'active']) }}">
            <button type="submit" class="btn btn-success btn-sm">Aktiv Posztok</button>
        </form>
    </a>
    <a class="nav-link">
        <form method="GET" action="{{ action('AdminPostsController@index', ['listmode' => 'trashed']) }}">
            <button type="submit" class="btn btn-danger btn-sm">Törölt Posztok</button>
        </form>
    </a>
</nav>

@if(empty($posts) || is_null($posts) || !is_iterable($posts) || sizeof($posts) === 0)

<div class="row justify-content-md-center">
    <div class="col-md-auto">
        <p>Nincs Poszt</p>
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
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Text</th>
                <th scope="col">Created At</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)

            <tr>
                <th scope="row">{{ $post->id }}</th>
                <!-- The title of the post -->
                <td>{{ $post->title }}</td>

                <!-- The body of the post goes here -->
                <!-- <td>{{ $post->body }}</td> -->
                <td></td>
                <!-- The time of the post when it was created -->
                <td>{{ $post->created_at->format('M D o h:m:s') }}</td>


                <td>
                    <form method="GET" action="{{ action('AdminPostsController@edit', ['id' => $post->id]) }}">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-warning">Edit</button>
                    </form>
                </td>
                <td>
                @if( Request::url() === "http://hobbyproject.localhost/admin/index/trashed" )

                    <form method="POST" action="{{ action('AdminPostsController@restore', ['id' => $post->id]) }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-danger">Restore</button>
                    </form>

                @else
                    <form method="POST" action="{{ action('AdminPostsController@destroy', ['id' => $post->id]) }}">
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
    <div class="d-flex mx-auto">{{ $posts->links() }}</div>
</div>
<!--  -->

@endif

</div>
@endsection