@can('comment.view')
<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>

<script>
$( document ).ready(function(){

  $( "ul" ).on( "click",'li .editbutton', function() {

    $(this).parents('.editform').css("visibility", "hidden");

    let mediaBody = $(this).closest('.media-body');

    let content = mediaBody.find('p[name="body"]').text();
    
    mediaBody.find('p[name="body"]').detach();

    $(this).closest('.row').find('.updateform').css("visibility", "visible");

    let textArea = $('<textarea class="form-control" required></textarea>').val(content); 

    textArea.insertAfter(mediaBody.find('h5'));
  });



});
</script>
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
      <p name="body">{{ $comment->body }}</p>

      <!-- Check if the user created the comment and allowed to edit or delete the comment -->
      @can('comment.delete',$comment)
      <div class="row">

        <div class="col-md-1">
          <!-- Editing the comment -->
          <form class="editform"  method="POST">
            @csrf
            @method('GET')
            <input type="hidden" name="id" value="{{ $comment->id }}" />
            <button type="button" class="btn btn-link editbutton" alt="edit button">Edit</button>
          </form>
        </div>

        <div class="col-md-1">
          <form style="visibility:hidden;" class="updateform"  method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $comment->id }}" />
            <button type="button" class="btn btn-link updatebutton" alt="edit button">Update</button>
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