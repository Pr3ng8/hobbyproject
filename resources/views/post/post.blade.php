@extends('layouts.main')

@section('content')


<!--  <div class="card text-center">
  <div class="card-body">
  
    <h4 class="card-title">{{ $post->title }}</h4>
    <p class="card-text">{{ $post->body }}</p>
  </div>
</div> -->
<style>
  hr {
    margin-top: 0;
  }
</style>

<!-- Contaier thats holds the post contetn -->
<div class="container p-3" style="background-color: #FFFFFF;">

@if(isset($post) && !empty($post) && !is_null($post))
<!-- The title of the post -->
  <div class="row">
    <div class="col">
      <h1 class="display-3">{{ $post->title }}</h1>
      <div class="lead">Created By {{ $post->user->getFullName() }}</div>
    </div>
  </div>
  <hr>

  <!-- The time of the post when it was created -->
  <div class="row">
    <div class="col">
      <p>Posted on {{ $post->created_at->format('M D o h:m:s') }}</p>
    </div>
  </div>
  <hr>

  <!-- The picture for the post goes here -->
  <div class="row">
    <div class="col">
        <img src="{{ empty($post->photos['file']) ? 'https://via.placeholder.com/1151x250' : URL::asset($post->photos['file']) }}" class="img-fluid mb-3" alt="Responsive image">
    </div>
  </div>
  <hr>

<!-- The body of the post goes here -->
  <div class="row">
    <div class="col">
    <p>{{ $post->body }}</p>
    </div>
  </div>
  <div class="container bg-info rounded">
    <p class="lead text-white">Comments</p>
  </div>
<!-- We can create comment in this section -->
@include('comment.create')
@include('comment.comments')
  @else

  <div class="row">
    <div class="col">
      <h1 class="display-3">No Post Founded</h1>
      <div class="lead">We are sorry we couldn't find the post you were looking for!</div>
    </div>
  </div>

@endif
</div>

@endsection