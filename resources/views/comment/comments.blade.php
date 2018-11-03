@can('comment.view')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
$( document ).ready(function(){

  // Adding click event listener to the edit button
  $( "ul" ).on( "click",'li .editbutton', function() {

      //First we check if there is any active editing by searching for textarea among the comments
      let existsTextArea = $('ul li .media-body').has('textarea');

      // Checking it by the length, if it's greater than 0 it means user clicked already to edit button from the comments.
      if ( existsTextArea.length ) {

        //If the user already clicked to one edit button from another comment we want to do back the editing with the cancelButton function
        existsTextArea.each(cancelButton);

        //Than we let the user edit the comment what he has clicked on after the others
        $(this).each(editButton);

      } else {

        //If the user didn't begin editing any comment before we just simply let him edit the comment by calling the editButton function
        $(this).each(editButton);

      }

  });

  // Adding click event listener to the cancel button
  $( "ul" ).on( "click",'li .cancelbutton', cancelButton);

  // Adding click event listener to the update button
  $( "ul" ).on( "click",'li .updatebutton', updateButton);


  /*
  * We are collecting the data that we wnat to send to the server side.
  */
  function updateButton() {
        //Creating an empty obj
        let hiddenInputValue = [];

        //Let's find the the media-body which contains the forms and the comment
        let mediaBody = $(this).closest('.media-body');

        //We are trying to get the edited comment from textarea
        let content = mediaBody.find('textarea').val();
        
        //Get the required data from the updateForm's hidden inputs and assign it to hiddenInputValue
        $(this).closest('.updateForm').find('input').each(function () {

          hiddenInputValue[$(this).attr("name")] = $(this).val();

        });

        //Then assign the content of the textarea to the variable we are sending to the server side
        hiddenInputValue["body"] = content.length > 0 ? content : "NULL";

        //Callign function to send data to server side
        sendDataToEdit(hiddenInputValue);
  }

  /*
  * In this function we are creating an edit field by removing the p tag from the media-body
  * which contained the comment we want to edit. Before we delete the p tag we get the text inside it
  * then assign it to a hidden input field inside cancelForm in case we change our minds.
  * After all we insert the textarea after the h5 tag with the value of the p tag we deleted.
  */
  function editButton () {

    //Let's find the the media-body which contains the forms and the comment
    let mediaBody = $(this).closest('.media-body');

    //Let's hide the editForm form from user
    let editForm = mediaBody.find('.editForm').attr("hidden",true);

    //In this media-body lets find the comment and get the text from it
    let content = mediaBody.find('p[name="body"]').text();

    //Lets find the hidden input where we wnat to put the text as backup
    let backUpText = mediaBody.find('.cancelForm input[type=hidden]');

    //Assign the value of the content to the hidden input field in the cancelForm
    backUpText.val(content);

    //Let's remove the p tag which conatins the comment in the media-body
    mediaBody.find('p[name="body"]').remove();

    //Remove the hidden attribute from the updateForm and cancelForm
    mediaBody.find('.updateForm').removeAttr("hidden");
    mediaBody.find('.cancelForm').removeAttr("hidden");

    //Create a textfield and assign the value of the comment what we have got from p tag as content
    let textArea = $('<textarea class="form-control" required></textarea>').val(content); 

    //Find the media-body h5 tag and assign it ti h5Tag var
    let h5Tag = mediaBody.find('h5');

    //Let's insert the textarea we have created before and insert it after the h5Tag
    textArea.insertAfter(h5Tag);

  }
  
  /*
  * In this function we remove the textarea what we have inserted in 
  * with the editButton function.After that we get the original comment form
  * editForm nad creat p tag and add the text to the p tag and isert it into back.
  *
  */
  function cancelButton () {

    //First find the comment we were editing
    let mediaBody = $(this).closest('.media-body');

    //Remove the textarea from that media-body where we are canceling the editing
    mediaBody.find('textarea').remove();

    //Secondly find this medai-body cancelForm that has the original text in hidden inpput
    let content = mediaBody.find('.cancelForm input[type=hidden]').val();

    // We need to hide the cancelForm and the updateForm
    mediaBody.find('.cancelForm').attr("hidden",true);
    mediaBody.find('.updateForm').attr("hidden",true);

    //Create a p Tag and add the value of the original text
    let pTag = $('<p name="body"></p>').text(content);

    //Find the h5 tag so we can isnert after the p tag
    let h5Tag = mediaBody.find('h5');

    //Let's put back the p tag where it was originally inside the media-body after the h5 tag
    pTag.insertAfter(h5Tag);

    //We want to find the editForm and show it
    mediaBody.find('.editForm').attr("hidden",false);

  }

  /*
  * In this function we are sending the eddited comment we would like to update
  */
  function sendDataToEdit (data) {
    
  //ajax function for sending data
  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //Url wehere we want to send the data
    url: "{{ URL::asset('comments') }}/" + data['id'],
    //Method of the sending
    method: "PUT",
    //the data we want to send to server side
    data: data,
  }).done(function(data) {
    console.log(data);
  });

  }

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

          <!-- Editing the comment -->
        <div class="col-md-1">
          <form class="editForm"  method="POST">
            @csrf
            @method('GET')
            <input type="hidden" name="id" value="{{ $comment->id }}" />
            <button type="button" class="btn btn-link editbutton" alt="edit button">Edit</button>
          </form>
        </div>
        <!--  -->

      <!-- Deleting the comment -->
      <div class="col-md-1">
        <form action="{{ action('CommentsController@destroy', ['id' => $comment->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-link" alt="edit button">Delete</button>
        </form>
      </div>
      <!--  -->

        <!-- Updating the comment -->
        <div class="col-md-1">
          <form class="updateForm"  method="POST" hidden>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $comment->id }}" readonly/>
            <button type="button" class="btn btn-link updatebutton" alt="edit button">Update</button>
          </form>
        </div>
        <!--  -->

        <!-- Cancel the editing -->
        <div class="col-md-1">
          <form class="cancelForm" method="POST" hidden>
            <input type="hidden" />
            <button type="button" class="btn btn-link cancelbutton" alt="cancel button">Cancel</button>
          </form>
        </div>
        <!--  -->

      </div>
      @endif
      <!-- -->
    </div>

  </li>

@endforeach

</ul>

@endif

@endcan