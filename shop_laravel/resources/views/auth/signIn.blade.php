<!--inheritance master.blade.php-->
@extends('layout.master') 

@section('title', $title)

@section('content')
       <div class="container">
              <h1>{{ $title }}</h1>

              @include('components.socialButtons')
              @include('components.validationErrorMessage')

              <form action="/user/auth/sign-in" method="post">
                     <label>
                            Email:
                            <input type="text"
                                   name="email"
                                   placeholder="Email"
                            >
                     </label>

                     <label>
                            Password:
                            <input type="password"
                                   name="password"
                                   placeholder="Password"
                            >
                     </label>
                     
                     <button type="submit">login</button>

                     {!! csrf_field() !!}
              </form>
       </div>
@endsection    