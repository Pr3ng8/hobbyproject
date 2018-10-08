@extends('layouts.main')


@section('content')

<div class="container p-3 rounded" style="background-color: #FFFFFF;">
<h1 class="display-4 text-left mb-3">Create News</h1>
    <form action="{{ action('AdminPostsController@store') }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('POST')

        <div class="form-group">
            <label for="title">Title of the Post:</label>
            <input type="text" name="title"value="" class="form-control" aria-describedby="titleofthepost"  placeholder="Breaking News">
            @if ( $errors->has('title') )
                @foreach( $errors->get('title') as $title_error )
                <div class="alert alert-danger" role="alert">
                    {{ $title_error }}
                </div>
                @endforeach
            @endif
        </div>

        <div class="form-group">
            <label for="body">Content of the Post:</label>
            <textarea class="form-control" name="body" id="body" rows="4"  placeholder="So, In this article...."></textarea>
            @if ( $errors->has('body') )
                @foreach( $errors->get('body') as $body_error )
                <div class="alert alert-danger" role="alert">
                    {{ $body_error }}
                </div>
                @endforeach
            @endif
        </div>

        <div class="form-group">
            <label for="file">Photo for the post:</label>
            <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
            @if ( $errors->has('file') )
                @foreach( $errors->get('file') as $file_error )
                <div class="alert alert-danger" role="alert">
                    {{ $file_error }}
                </div>
                @endforeach
            @endif
        </div>

        <div class="d-flex flex-row-reverse">
            <button type="submit" class="btn btn-success px-4 float-right">Create</button>
        </div>
    </form>

</div>


@endsection