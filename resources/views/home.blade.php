@extends('layouts.main')

@section('content')
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto text-white">

                <h1 class="display-4">Welcome {{ Auth::user()->getFullName()}}!</h1>
                <p class="lead">Good to see you here!!</p>
                @include('includes.errors')
            
        </div>
    </div>
</div>
@endsection
