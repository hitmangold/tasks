@extends('layout')

@section('content')
    <form action="{{ route('authors.store') }}" method="POST">
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
                    <input type="text" name="name" class="form-control" placeholder="Հեղինակի անունը">
                </div>
                <div class="col-md-6">
                    <input type="text" name="surname" class="form-control" placeholder="Հեղինակի ազգանունը">
                </div>
                <div class="col-md-6" style="margin-top: 15px;">
                    <select class="js-example-basic-multiple" name="books[]" multiple="multiple" style="height: 40px; width: 100%;" @if(isset($show)) disabled @endif>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">{{ $book->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-12">
                    <input type="submit" value="Ստեղծել Հեղինակին" style="background: #4bb1b1; color: white; height: 40px; margin-top: 15px; font-weight: 500; width: 250px; border-radius: 8px; outline: none!important; border: none; cursor:pointer;">
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
