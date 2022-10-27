@extends('layout')

@section('content')
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        @if(session()->has('message'))
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    {{ session()->get('message') }}
                </div>
            </div>
        @endif
    <div class="col-md-12">
        <div class="row">
                <div class="col-md-6">
                    <input type="text"  name="title" class="form-control" placeholder="Գրքի անվանումը">
                </div>
                <div class="col-md-6">
                    <input type="text" name="price" class="form-control" placeholder="Գրքի գինը">
                </div>
                @if(auth('web')->user()->role == 2)
                <div class="col-md-6" style="margin-top: 15px;">
                    <select class="js-example-basic-multiple" name="authors[]" multiple="multiple" style="height: 40px; width: 100%;" >
                        @foreach($users as $user)
                            <option value="{{ $user->author->id }}">{{ $user->author->name }} {{ $user->author->surname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"></div>
                @endif
                <div class="col-md-12">
                    <input type="submit" value="Ստեղծել գիրքը" style="background: #4bb1b1; color: white; height: 40px; margin-top: 15px; font-weight: 500; width: 250px; border-radius: 8px; outline: none!important; border: none; cursor:pointer;">
                </div>
                <div class="col-md-12" style="margin-top: 10px;">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
        </div>
    </div>
    </form>
    <script>
        $(document).ready(function(){
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection