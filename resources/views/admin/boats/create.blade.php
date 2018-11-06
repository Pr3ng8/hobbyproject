@extends('layouts.main')

@section('content')
<div class="container p-3 shadow-sm mb-5 rounded" style="background-color: #FFFFFF;">
    <h1 class="display-4 text-left mb-3">Create Boat</h1>


    <form action="{{ action('AdminBoatsController@store') }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('POST')

        <div class="form-group">
            <label for="name">Name of The Boat:</label>
            <input type="text" id="name" name="name" class="form-control" max="30"  aria-describedby="titleofthepost"  placeholder="Titanic" required/>
            @if ( $errors->has('name') )
                @foreach( $errors->get('name') as $name_error )
                <div class="alert alert-danger" role="alert">
                    {{ $name_error }}
                </div>
                @endforeach
            @endif
        </div>

        <div class="form-group">
            <label for="limit">Capacity of the Boat:</label>
            <input class="form-control" name="limit" id="limit" type="number" max="20" min="1"  required/>
            @if ( $errors->has('limit') )
                @foreach( $errors->get('limit') as $body_error )
                <div class="alert alert-danger" role="alert">
                    {{ $body_error }}
                </div>
                @endforeach
            @endif
        </div>

        <div class="form-group">
            <label for="file">Photo for the boat:</label>
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
            <button type="submit" class="btn btn-success px-4 float-right">Save</button>
        </div>
    </form>

</div>
@endsection