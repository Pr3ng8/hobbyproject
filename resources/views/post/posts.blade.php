@extends('layouts.main')

@section('content')
<h1 class="display-3 text-left mb-3">Hírek</h1>
<hr>
@foreach($posts as $post)
<div class="row mb-3">
    <div class="col">
        <div class="card shadow-sm p-3 mb-3 bg-white rounded">
            <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->body }}</p>
                <a href="{{ route('post', ['id' => $post->id] ) }}" class="card-link">Read</a>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="container d-flex mx-auto">
    <div class="d-flex mx-auto">{{$posts->links()}}</div>
</div>

@endsection