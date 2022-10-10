@extends('layout')

@section('content')
    <form method="POST" action="{{ route('postlogin') }}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            @if ($errors->has('email'))
                <p style="color:red;">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            @if ($errors->has('password'))
                <p style="color:red;">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="checked" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
            @if ($errors->has('checked'))
                <p style="color:red;">Խնդրում ենք դատարկ չթողնել տվյալ դաշտը</p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        @if (\Session::has('message'))
            <p style="color:red;">{{ \Session::get('message') }}</p>
        @endif
    </form>
@endsection
