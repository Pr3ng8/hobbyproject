@extends('layouts.main')

@section('content')
<div class="container shadow-sm p-3 mb-5 rounded" style="background-color: #FFFFFF;">
    <!-- Title of the page -->
    <h1 class="display-3 text-left mb-3">Handel Boats</h1>
    <hr>

    @if(empty($boats) || is_null($boats) || !is_object($boats))

    <div class="d-flex justify-content-center">We couldn't find the boats,sorry!</div>

    @else

    @include('includes.alert')
    <div class="table-responsive-md">
        <table style="border-top: 0px;" class="table table-hover table-sm ">
            <caption>List of Boats</caption>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Boat Name</th>
                    <th scope="col">Boat Capacity</th>
                    <th scope="col">Check</th>
                    <th scope="col">Delete\Restore</th>
                </tr>
            </thead>
        <tbody>

        @foreach($boats as $boat)
            <tr>
                <th scope="row">{{ $boat->id }}</th>
                    <td><a href="{{ route('admin.boats.show', ['id' => $boat->id] )}}">{{ $boat->name }}</a></td>
                    <td>{{ $boat->limit }}</td>
                    <td>
                        <form action="{{ action('AdminBoatsController@show', ['id' => $boat->id])}}" method="POST">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-warning btn-sm">Check</button>
                        </form>
                    </td>
                    <td>

                    @if( $boat->trashed() )

                    <form method="POST" action="{{ action('AdminBoatsController@restore', ['id' => $boat->id]) }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-success btn-sm">Restore</button>
                    </form>

                    @else

                    <form method="POST" action="{{ action('AdminBoatsController@destroy', ['id' => $boat->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>

                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
        </table>
    </div>

    <!-- Pagination  -->
    <div class="container d-flex mx-auto">
        <div class="d-flex mx-auto">{{ $boats->appends([
        'status' => Request::get('status') ?? 'all',
        ])->links() }}</div>
    </div>
    <!--  -->

    @endif
</div>

@endsection