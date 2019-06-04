<!--inheritance master.blade.php-->
@extends('layout.master') 

@section('title', $title)

@section('content')
       <div class="container">
           <h1>{{ $title }}</h1>
           
           @include('components.validationErrorMessage') <!--show error msg-->

           <form action="/user/auth/sign-up" method="post"> <!--send form-data to route-->
              @include('components.socialButtons')
              <label>
                     Nickname:
                     <input type="text"
                            name="nickname"
                            placeholder="Nickname"
                            value="{{ old('nickname')}}"
                     >
              </label>

              <label>
                     Email:
                     <input type="text"
                            name="email"
                            placeholder="Email"
                            value="{{ old('email')}}"
                     >
              </label>

              <label>
                     Password:
                     <input type="password"
                            name="password"
                            placeholder="Password"
                     >
              </label>

              <label>
                     ConfirmPassword:
                     <input type="password"
                            name="password_confirmation"
                            placeholder="ConfirmPassword"
                     >
              </label>

              <label>
                     Type:
                     <select name="type">
                            <option value="G">GeneralMember</option>
                            <option value="A">Administrator</option>
                     </select>
              </label>

              <!--自動產生csrf_token-隱藏欄位-->
              {!! csrf_field() !!}
              
              <button type="submit">regist</button>
           </form>
       </div>
    
@endsection    