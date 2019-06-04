<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- Font -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <title>@yield('title') - Shop Laravel</title>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Shop-Laravel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            @if(session()->has('user_id'))              
              @if(session()->get('type') == ('A'))
                <li class="nav-item"><a class="nav-link" href="/merchandise/create">create item</a></li>
                <li class="nav-item"><a class="nav-link" href="/merchandise/manage">manage item</a></li>
              @elseif(session()->get('type') == ('G'))
                <li class="nav-item"><a class="nav-link" href="/transaction">transaction</a></li>
              @endif
              <li class="nav-item"><a class="nav-link" href="/user/auth/sign-out">logout</a></li>
            @else
              <li class="nav-item"><a class="nav-link" href="/user/auth/sign-up">signup</a></li>
              <li class="nav-item"><a class="nav-link" href="/user/auth/sign-in">signin</a></li>
            @endif
          </ul>
        </div>  
    </header>
    
    <div class="container">
        @yield('content')
    </div>
    
    <footer>
        <div class="text-center center-block">
              <a href="https://www.facebook.com/bootsnipp"><i class="fab fa-facebook-square fa-2x"></i></a>
	            <a href="https://twitter.com/bootsnipp"><i class="fab fa-twitter-square fa-2x"></i></a>
	            <a href="https://plus.google.com/+Bootsnipp-page"><i class="fab fa-google-plus-square fa-2x"></i></a>
	            <a href="mailto:bootsnipp@gmail.com"><i class="fa fa-envelope-square fa-2x"></i></a>
        </div>
        <div class="text-center py-3">© 2019 Copyright:
          <a href="https://shop_laravel.local"> shop_laravel</a>
        </div>
    </footer>
    
  </body>
</html>