@extends('layouts.main')

@section('content')
<div class="container shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">
    <h1 class="display-4 text-left mb-3">Edit Boat</h1>
    @if(empty($boat) || is_null($boat) || !is_object($boat))

    <div class="d-flex justify-content-center">We couldn't find the boat,sorry!</div>

    @else

    <form action="{{ action('AdminBoatsController@update', ['id' => $boat->id]) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

        <div class="form-group">
            <label for="name">Name of The Boat:</label>
            <input type="text" id="name" name="name" class="form-control" max="30" value="{{ $boat->name }}" aria-describedby="titleofthepost"  placeholder="Titanic" required/>
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
            <input class="form-control" name="limit" id="limit" type="number" max="20" min="1" value="{{ is_numeric($boat->limit) ? $boat->limit : 0}}" required/>
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

    @endif
</div>
@endsection