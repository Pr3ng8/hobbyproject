@extends('layouts.main')

@section('content')
<style>
img {
    height: 150px;
    width: 350px;
}
</style>
<div class="container p-3 rounded">
<!-- Title of the page -->
<h1 class="display-3 text-left text-white mb-3">News</h1>
<hr>

@if(Session::has('message'))
<div class="alert {{ Session::get('class')}}" role="alert">
  {{ Session::get('message')}}
</div>
@endif

@foreach($items->chunk(3) as $posts)
<div class="card-deck mb-2">
    @foreach($posts as $post)
        <div class="card" style="max-width: 25rem;">
            <img class="card-img-top" src="{{ empty($post->photos['file']) ? 'https://via.placeholder.com/1151x250' : $post->photos['file'] }}" alt="Card image cap">
            <div class="card-body">

                <!-- The title of the post -->
                <h5 class="card-title">{{ $post->title }}</h5>
                <!--  -->

                <!-- The body of the post goes here -->
                <p class="card-text">{{ substr( $post->body, 0, 60) }}{{ strlen($post->body) > 60 ? "..." : "" }}</p>
                <!--  -->

                <blockquote class="blockquote m-1">
                    <footer class="blockquote-footer">Posted By {{isset($post->user->first_name )? $post->user->first_name : "Unknown"}}</footer>
                </blockquote>

                <!-- The time of the post when it was created -->
                <p class="card-text"><small class="text-muted">{{ $post->created_at->format('M D o h:m:s') }}</small></p>

                <!-- Link to the full post -->
                <a href="{{ route('post', ['id' => $post->id] ) }}" class="card-link">Read</a>
                <!--  -->
            </div>
        </div>
    @endforeach
    </div>
@endforeach

<!-- Pagination  -->
<div class="container d-flex mx-auto">
    <div class="d-flex mx-auto">{{ $items->links() }}</div>
</div>
<!--  -->
</div>
@endsection