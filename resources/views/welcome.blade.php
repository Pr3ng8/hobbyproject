@extends('layouts.main')

@section('content')
<style>

.block-button {
    width: 100%;
    border: 2px solid white;
    border-radius: 2rem;
    padding: 2.5%;
    padding-left: 20%;
    padding-right: 20%;
    cursor: pointer;
}

.block-button {  
  color: #FFFFF8;
  transition: 0.25s;
}

.block-button:hover,
.block-button:focus { 
    border-color: #FCBC80;
    color: #FCBC80;
    text-decoration:none;
}

hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #FFFFF8;
    margin: 1em 0;
    padding: 0; 
}

</style>
<!-- Page Content -->

<div class="container h-100">
    <div class="row justify-content-center">
        <div class="col-8 text-center ">
            <h1 class="display-3 mt-5 text-white">Welcome on the page!</h1>
            <div class="row my-5">
                <div class="col-6">
                    <a class="block-button" href="{{ route('login') }}">Login</a>
                </div>
                <div class="col-6">
                    <a class="block-button" href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
