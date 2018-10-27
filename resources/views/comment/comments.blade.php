@can('comment.view')

@if(empty($post->comments) || !isset($post->comments) || is_null($post->comments))

@else

@foreach($post->comments as $comment)
<ul class="list-unstyled">

  <li class="media my-4">
    <img class="mr-3" src="{{ $comment->user->photos ? : 'https://via.placeholder.com/64x64' }}" alt="Generic placeholder image">
    <div class="media-body">
      <h5 class="mt-0 mb-1">{{ $comment->user->getFullName() }}</h5>
      <p>{{ $comment->body }}</p>
    </div>

  </li>

</ul>

@endforeach

@endif

@endcan