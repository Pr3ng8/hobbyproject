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
      <div class="row">

        <div class="col-md-1">
          <!-- Editing the comment -->
          <form action="{{ action('CommentsController@edit', ['id' => $comment->id]) }}" method="POST">
            @csrf
            @method('GET')
            <button type="submit" class="btn btn-link" alt="edit button">Edit</button>
          </form>
          <!--  -->
        </div>

        <div class="col-md-1">
          <!-- Deleting the comment -->
          <form action="{{ action('CommentsController@destroy', ['id' => $comment->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link" alt="edit button">Delete</button>
          </form>
          <!--  -->
        </div>

      </div>
      @endif
      <!-- -->
    </div>

  </li>

@endforeach

</ul>

@endif

@endcan