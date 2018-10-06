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
        <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>
  <style>
  html {
      height: 100%;
  }
    body {
        background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
        height: 100%;
        margin: 0;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    .navbar {
        background-color: #4FB99F;
    }
  </style>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-2">
        <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
        @guest
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Kezdőlap</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('posts') }}">Hírek</a>
            </li>
        </ul>
        </div>
        @endguest
        @auth
        <div calss="form-inline">
        <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->first_name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" id="logoutbutton" href="{{ route('logout') }}">{{ __('Logout') }}
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
        </script>
        @endauth
    </nav>
    <div class="container-fluid">
        @yield('content')
    </div>

  </body>
</html>
</html>