@extends('layouts.main')

@section('content')
<style>
img {
    height: 50px;
    width: 100px;
}
</style>
<div class="container-fluid shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">
<!-- Title of the page -->
<h1 class="display-3 text-left mb-3">Handel Posts</h1>
<hr>
<form class="mb-4" method="GET" action="{{ action('AdminPostsController@index') }}">

  <div class="form-row">

    <div class="col">
        <label for="postsstatus">Posts Status</label>
        <select name="postsstatus" class="form-control" id="postsstatus">
            <option value="all" selected>All</option>
            <option value="active">Active Posts</option>
            <option value="trashed">Deleted Posts</option>
        </select>
    </div>
    <div class="col align-self-end">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </div>
  
</form>

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
<div class="table-responsive">
    <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Title</th>
            <!--    <th scope="col">Text</th> -->
                    <th scope="col">Created At</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete\Restore</th>
                </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)

                <tr>
                    <!-- The id of the post -->
                    <th scope="row">{{ $post->id }}</th>

                    <!-- The photo for the post -->
                    <td>
                    <img src="{{ empty($post->photos['file']) ? 'https://via.placeholder.com/100x50' : URL::asset($post->photos['file']) }}" alt="Card image cap">
                    </td>

                    <!-- The title of the post -->
                    <td>{{ $post->title }}</td>


                    <!-- The body of the post goes here -->
                    <!-- <td>{{ $post->body }}</td> -->
                    
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

                    @if( $post->trashed() )

                        <form method="POST" action="{{ action('AdminPostsController@restore', ['id' => $post->id]) }}">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-success">Restore</button>
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
</div>

<!-- Pagination  -->
<div class="container d-flex mx-auto">
    <div class="d-flex mx-auto">{{ $posts->links() }}</div>
</div>
<!--  -->

@endif

</div>
@endsection