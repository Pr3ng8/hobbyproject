<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.8.94/css/materialdesignicons.min.css">
  </head>
  <style>
  html {
      height: 100%;
  }
    body {
        background-image: linear-gradient(to top, #f77062 0%, #fe5196 100%);
        height: 100%;
        margin: 0;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    .navbar {
        background-color: #fd5392;
    }

    /* Dropdown menu background color*/

    .btn-blue {
        background-color: #f77062;  
    }
    .form-inline > .dropdown a{
        text-decoration: none;
    }

.btn-blue:hover, .btn-blue:focus, .btn-blue:active, .btn-blue.active, .open .dropdown-toggle.btn-blue {
    background-color: #D46054;
 }
  </style>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-2">
        @auth
            <a class="navbar-brand" href="{{ url('/home') }}">{{ config('app.name', 'Laravel') }}</a>
        @endauth
        @guest
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
        @endguest
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endguest
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                <svg style="width:24px;height:24px;" viewBox="0 0 24 24">
                    <path fill="white" d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z" />
                </svg>
                Kezdőlap
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('posts') }}">Hírek</a>
            </li>
            @can('author-menu')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.posts.create') }}">Create Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.posts.index') }}">Handle Post</a>
            </li>
            @endcan
            @can('admin-menu')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">Handle Users</a>
            </li>
            @endcan
        @endauth
        </ul>
        </div>
        @auth
        <div calss="form-inline">
            <div class="dropdown">
                <a class="btn dropdown-toggle btn-blue text-white" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="white" d="M7.5,15C8.63,15 9.82,15.26 11.09,15.77C12.35,16.29 13,16.95 13,17.77V20H2V17.77C2,16.95 2.65,16.29 3.91,15.77C5.18,15.26 6.38,15 7.5,15M13,13H22V15H13V13M13,9H22V11H13V9M13,5H22V7H13V5M7.5,8A2.5,2.5 0 0,1 10,10.5A2.5,2.5 0 0,1 7.5,13A2.5,2.5 0 0,1 5,10.5A2.5,2.5 0 0,1 7.5,8Z" />
                </svg>
                    {{ Auth::user()->first_name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="black" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
                    </svg>
                    Profile
                    </a>
                    <a class="dropdown-item" id="logoutbutton" href="{{ route('logout') }}">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="black" d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13" />
                    </svg>
                    {{ __('Logout') }}
                    </a>
                    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                        @method('POST')
                    </form>
                    
                </div>
            </div>
        </div>
        <script>
            document.getElementById('logoutbutton').addEventListener("click", function (event) {
                event.preventDefault();
                document.getElementById('logoutform').submit();
            });

            // Get all link with class="nav-item"
            var links = document.querySelectorAll(".nav-item");

            // Loop through the links and add the active class to the current/clicked a tag
            for (var i = 0; i < links.length; i++) {
                links[i].addEventListener("click", function() {
                    var current = document.getElementsByClassName("active");

                    // If there's no active class
                    if (current.length > 0) { 
                        current[0].className = current[0].className.replace(" active", "");
                    }

                    // Add the active class to the current/clicked a tag
                    this.className += " active";
                });
            }
        </script>
        @endauth
    </nav>
    <div class="container-fluid">
        @yield('content')
    </div>

  </body>
</html>
</html>