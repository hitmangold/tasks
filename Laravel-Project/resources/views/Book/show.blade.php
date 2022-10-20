@extends('layout')

@section('content')
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
                    <input type="text" readonly value="{{ $book->title }}" name="title" class="form-control" placeholder="Գրքի անվանումը">
                </div>
                <div class="col-md-6">
                    <input type="text" readonly value="{{ $book->price }}" name="price" class="form-control" placeholder="Գրքի գինը">
                </div>
                <div class="col-md-6" style="margin-top: 15px;">
                    <select class="js-example-basic-multiple" name="authors[]" multiple="multiple" style="height: 40px; width: 100%;" disabled>
                        @foreach($authors as $author)
                            {{ $count = 0 }}
                            @foreach($book->authors as $author_book)
                                @if($author->id == $author_book->id)
                                    {{ $count = 1 }}
                                    <option selected="selected" value="{{ $author->id }}">{{ $author->name }} {{ $author->surname }}</option>
                                @endif
                            @endforeach
                            @if($count == 0)
                                <option value="{{ $author->id }}">{{ $author->name }} {{ $author->surname }}</option>
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
