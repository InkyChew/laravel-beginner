<!--success-->
@if(session('success'))
    <div class="alert alert-success" role="alert">
        <ul>
            @foreach (session('success') as $message)
                @foreach ($message as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
            @endforeach
        </ul>
    </div>
@endif
<!--error-->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif