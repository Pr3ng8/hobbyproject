@can('comment.view')

@if(empty($post->comments) || !isset($post->comments) || is_null($post->comments) || !is_object($post->comments) || count($post->comments) <= 0)

  <div class="row justify-content-md-center">
   <div class="col-md-4">
    <p class="lead">Be the first wo comment on this post!</p>
   </div>
  </div>


@else
<ul class="list-unstyled">

@foreach($post->comments as $comment)

  <li class="media my-4">
    <img class="mr-3" src="{{ $comment->user->photos ? : 'https://via.placeholder.com/64x64' }}" alt="Generic placeholder image">
    <div class="media-body">
      <h5 class="mt-0 mb-1">{{ $comment->user->getFullName() }}</h5>
      <p>{{ $comment->body }}</p>

      <!-- Check if the user created the comment and allowed to edit or delete the comment -->
      @can('comment.delete',$comment)
        <a href="#" class="card-link">Edit</a>
        <a href="#" class="card-link">Delete</a>
      @endif
      <!-- -->
    </div>

  </li>

@endforeach

</ul>

@endif

@endcan