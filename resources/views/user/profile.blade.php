@extends('layouts.main')

@section('content')
<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
<style>
p {
    font-family: 'Cabin', sans-serif;
    color:black;
}
.img-circle {
    border-radius: 50%;
}

#triangle-topleft {
    width: 0;
    height: 0;
    border-top: 100px solid grey;
    border-right: 100px solid transparent;
    opacity: 0.6;
}
.left-to-top {
    border-top: 3px solid transparent;
    border-left: 3px solid transparent;
    border-image: linear-gradient(to bottom, #f77062 0%, #fe5196 100%);
    border-image-slice: 1;
}

.col-content {
    border-top: 5px solid transparent;
    border-image: linear-gradient(to right, #f77062 0%, #fe5196 100%);
    border-image-slice: 1;
    box-shadow:0 15px 25px rgba(0,0,0,.2);
}


</style>

<div class="container rounded p-3 shadow-sm mb-5" style="background-color: #FFFFFF;">
    <!-- The user\s profile picture -->
    <div class="row mb-4 justify-content-center">
        <img src="https://via.placeholder.com/350x350" class="mx-auto img-circle" alt='User\'s profile picture.' >
    </div>
    <!-- -->

    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-10 col-sm-10 left-to-top pl-3">
        <h1 class="mb-0 display-4">Varga Bence</h1>
        </div>
    </div>



    <div class="row my-2 justify-content-center">
        <!-- User's personal Data -->
        <div class="col-lg-5 my-2 col-md-10 col-sm-10 col-xs-12 col-content p-2">
            <!-- The First name of the user -->
            <div class="row">
                <div class="col-4">
                    <p class="font-weight-bold">First Name</p>
                </div>
                <div class="col-4">
                    <p>Cash</p>
                </div>
            </div>
            <!-- -->

            <!-- Last Name of the user -->
            <div class="row">
                <div class="col-4">
                    <p class="font-weight-bold">Last Name</p>
                </div>
                <div class="col-4">
                    <p>Adémö</p>
                </div>
            </div>
            <!-- -->

            <!-- The user's email address -->
            <div class="row">
                <div class="col-4">
                    <p class="font-weight-bold">Email</p>
                </div>
                <div class="col-4">
                    <p>Example@gmail.com</p>
                </div>
            </div>
            <!-- -->

            <!-- The birthdate of the user -->
            <div class="row">
                <div class="col-4">
                    <p class="font-weight-bold">BirthDate</p>
                </div>
                <div class="col-4">
                    <p>1996.11.01</p>
                </div>
            </div>
            <!-- -->

        </div>
        <!-- -->

        <!-- Some extra information about the user -->
        <div class="col-lg-5 my-2 col-md-10 col-sm-10 col-xs-12 col-content offset-lg-1 offset-md-0 offset-xs-0 offset-sm-0 p-2">
                <!-- Number of reservation that the user made -->
                <div class="row">
                    <div class="col-6">
                        <p class="font-weight-bold">Number of Reservation made</p>
                    </div>
                    <div class="col-4">
                        <p>34</p>
                    </div>
                </div>
                <!-- -->

                <!-- Number of the comments that the user made-->
                <div class="row">
                    <div class="col-6">
                        <p class="font-weight-bold">Number of Comments</p>
                    </div>
                    <div class="col-4">
                        <p>134</p>
                    </div>
                </div>
                <!-- -->

                <!-- If the user is author we show how much post the user made -->
                <div class="row">
                    <div class="col-6">
                        <p class="font-weight-bold">Posts Created</p>
                    </div>
                    <div class="col-4">
                        <p>11</p>
                    </div>
                </div>
                <!-- -->

                <!-- The role what the user has -->
                <div class="row">
                    <div class="col-6">
                        <p class="font-weight-bold">Role</p>
                    </div>
                    <div class="col-4">
                        <p>Author</p>
                    </div>
                </div>
                <!-- -->
        </div>
        <!-- -->
    </div>


</div>

<div class="container rounded p-3 shadow-sm mb-5" style="background-color: #FFFFFF;">
@if(empty($comments) || is_null($comments) || !isset($comments) || count($comments) < 0)
    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-10 col-sm-10 left-to-top pl-3">
            <h1 class="mb-0 display-4">No Comments</h1>
        </div>
    </div>
@else
    <div class="row justify-content-center mb-2">
        <div class="col-lg-11 col-md-10 col-sm-10 left-to-top pl-3">
            <h1 class="mb-0 display-4">Comments</h1>
        </div>
    </div>
    @include('includes.alert')
    <div class="row justify-content-center">
        <div class="col-lg-11 col-md-10 col-sm-10">
            <table class="table table-hover table-responsive-md table-sm">
                <caption>Your Comments</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Post Title</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Check</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                @foreach($comments as $comment)
                    <tr>
                        <th scope="row">{{ $comment->id }}</th>
                        <td>{{ $comment->post->title }}</a></td>
                        <td>{{ strlen($comment->body) >= 15 ? substr($comment->body, 0, 15) . " ... "  : $comment->body}}</td>
                        <td>{{ $comment->created_at }}</td>
                        <td>
                            <a class="" href="{{ route('post', ['id' => $comment->post->id] ) }}" alt="Check user profile">
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="grey" d="M20,12V16C20,17.11 19.11,18 18,18H13.9L10.2,21.71C10,21.89 9.76,22 9.5,22H9A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V6C2,4.89 2.9,4 4,4H9.5C8.95,4.67 8.5,5.42 8.14,6.25L7.85,7L8.14,7.75C9.43,10.94 12.5,13 16,13C17.44,13 18.8,12.63 20,12M16,6C16.56,6 17,6.44 17,7C17,7.56 16.56,8 16,8C15.44,8 15,7.56 15,7C15,6.44 15.44,6 16,6M16,3C18.73,3 21.06,4.66 22,7C21.06,9.34 18.73,11 16,11C13.27,11 10.94,9.34 10,7C10.94,4.66 13.27,3 16,3M16,4.5A2.5,2.5 0 0,0 13.5,7A2.5,2.5 0 0,0 16,9.5A2.5,2.5 0 0,0 18.5,7A2.5,2.5 0 0,0 16,4.5" />
                                </svg>
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ action('CommentsController@destroy', ['id' => $comment->id]) }}">
                                @csrf
                                @method('DELETE')
                                <a type="submit" alt="Delete">
                                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="grey" d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19Z" />
                                    </svg>
                                </a>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endif
</div>

@endsection