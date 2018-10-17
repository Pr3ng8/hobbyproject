@extends('layouts.main')

@section('content')
<div class="container-fluid p-3 rounded" style="background-color: #FFFFFF;">
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Welcome {{ Auth::user()->getFullName()}}!</h1>
            <p class="lead">Good to see you here!!</p>
        </div>
    </div>
</div>
@endsection
