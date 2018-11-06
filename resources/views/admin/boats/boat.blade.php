@extends('layouts.main')

@section('content')

<div class="container p-3 shadow-sm mb-5 rounded" style="background-color: #FFFFFF;">

    @if(empty($boat) || is_null($boat) || !is_object($boat))

    <div class="d-flex justify-content-center">We couldn't find the boat,sorry!</div>

    @else

    <div class="row">
        <div class="col-3 border-right">
        <figure class="figure">
            <img src="https://via.placeholder.com/350x150" class="figure-img img-fluid rounded img-responsive" alt="Picture of the Boat.">
            <figcaption class="figure-caption">Picture of the Boat.</figcaption>
        </figure>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-12 border-bottom  mb-2">
                    <div class="row p-2">
                        <div class="col">
                            <p class="h5 font-weight-light">{{ $boat->name }}</p>
                        </div>
                        <div class="col">
                            <form class="float-right" method="GET" action="{{ action('AdminBoatsController@edit', ['id' => $boat->id]) }}">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-warning px-4">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <p class="font-weight-bold">Boat Name</p>
                    <p class="font-weight-bold">Boat Capacity</p>
                    <p class="font-weight-bold">Created at</p>
                    <p class="font-weight-bold">Updated at</p>
                </div>
                <div class="col-6">
                    <p class="font-weight-bold text-primary">{{ $boat->name }}</p>
                    <p class="font-weight-bold text-primary">{{ $boat->limit }}</p>
                    <p class="font-weight-bold text-primary">{{ $boat->email }}</p>
                    <p class="font-weight-bold text-primary">{{ $boat->created_at->format('M D o h:m:s') }}</p>
                    <p class="font-weight-bold text-primary">{{ $boat->updated_at->format('M D o h:m:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    @endif

</div>

@endsection