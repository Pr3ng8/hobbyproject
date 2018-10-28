

<div class="row p-2">
  <div class="col-md-8">
    <!-- Form section with post method to send the comment to the server side -->
    <div class="media">
      <img class="mr-3" src="https://via.placeholder.com/64x64" alt="Generic placeholder image">
      <div class="media-body">
        <form class="p-2 mt-3" action="{{ action('CommentsController@store') }}" method="POST">
          @csrf
          @method('POST')
          <div class="form-group">
            <!-- Post id -->
            <input type="hidden" name="post_id" value="{{$post->id}}">
            <!-- Textarea for the user input -->
            <textarea class="form-control" name="body" placeholder="Join the discussion..." required></textarea>
          </div>
          <button class="btn btn-info" type="submit">Submit</button>
        </form>
      </div>
      <!--  -->
    </div>
  </div>
  <div class="col-md-4">
    <!-- Display message from server side -->
    @include('includes.alert')
    <!--  -->
  </div>
</div>

