@extends('layouts.main')

@section('content')
<!-- Title of the page -->
<h1 class="display-3 text-left mb-3">Hírek</h1>
<hr>

@if(Session::has('message'))
<div class="alert {{ Session::get('class')}}" role="alert">
  {{ Session::get('message')}}
</div>
@endif

@foreach($posts as $post)

<div class="row mb-3">
    <div class="col">
        <div class="card shadow-sm p-3 mb-3 bg-white rounded">
            <div class="card-body">

            <!-- The title of the post -->
            <h5 class="card-title mb-3">{{ $post->title }}</h5>
            <!--  -->

            <!-- The time of the post when it was created -->
            <!--<h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($post->created_at)->format('M D o h:m:s') }}</h6>-->
            <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at->format('M D o h:m:s') }}</h6>
            <!--  -->

                <!-- The body of the post goes here -->
                <p class="card-text">{{ $post->body }}</p>
                <!--  -->

                <blockquote class="blockquote m-1">
                    <footer class="blockquote-footer">Posted By {{isset($post->user->first_name )? $post->user->first_name : "No data"}}</footer>
                </blockquote>

                <!-- Link to the full post -->
                <a href="{{ route('post', ['id' => $post->id] ) }}" class="card-link">Read</a>
                <!--  -->
            </div>
        </div>
    </div>
</div>

@endforeach
<!-- Pagination  -->
<div class="container d-flex mx-auto">
    <div class="d-flex mx-auto">{{ $posts->links() }}</div>
</div>
<!--  -->
@endsection