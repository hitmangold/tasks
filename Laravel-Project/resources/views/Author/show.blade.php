@extends('layout')

@section('content')
        @csrf
        @method('PUT')
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
                    <input type="text" value="{{ $author->name }}" readonly name="name" class="form-control" placeholder="Հեղինակի անունը">
                </div>
                <div class="col-md-6">
                    <input type="text" readonly value="{{ $author->surname }}" name="surname" class="form-control" placeholder="Հեղինակի ազգանունը">
                </div>
                <div class="col-md-6" style="margin-top: 15px;">
                    <select class="js-example-basic-multiple" name="books[]" multiple="multiple" style="height: 40px; width: 100%;" disabled>
                        @foreach($books as $book)
                            {{ $count = 0 }}
                            @foreach($author->books as $author_book)
                                @if($book->id == $author_book->id)
                                    {{ $count = 1 }}
                                    <option selected="selected" value="{{ $book->id }}">{{ $book->title }}</option>
                                @endif
                            @endforeach
                            @if($count == 0)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-12" style="margin-top: 10px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="color: red;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function(){
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
