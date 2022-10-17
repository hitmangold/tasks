@extends('layout')

@section('content')
    @if(!isset($books))
    <form action="{{ route('add_book') }}" method="POST">
        @else
            <form action="{{ route('update_books') }}" method="POST">
                @endif
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
                    <input type="text" @if(isset($books)) value="{{ $books->title }}" @endif name="title" class="form-control" placeholder="Գրքի անվանումը">
                </div>
                <div class="col-md-6">
                    <input type="text" @if(isset($books)) value="{{ $books->price }}" @endif name="price" class="form-control" placeholder="Գրքի գինը">
                </div>
                <div class="col-md-6" style="margin-top: 15px;">
                    <select class="js-example-basic-multiple" name="authors[]" multiple="multiple" style="height: 40px; width: 100%;">
                        @if(isset($books))
                            @foreach($authors as $author)
                                {{ $count = 0 }}
                                @foreach($books->authors as $author_book)
                                    @if($author->id == $author_book->id)
                                        {{ $count = 1 }}
                                        <option selected="selected" value="{{ $author->id }}">{{ $author->name }} {{ $author->surname }}</option>
                                    @endif
                                @endforeach
                                @if($count == 0)
                                    <option value="{{ $author->id }}">{{ $author->name }} {{ $author->surname }}</option>
                                @endif
                            @endforeach
                        @else
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }} {{ $author->surname }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-12">
                    @if(!isset($books))
                        <input type="submit" value="Ստեղծել գիրքը" style="background: #4bb1b1; color: white; height: 40px; margin-top: 15px; font-weight: 500; width: 250px; border-radius: 8px; outline: none!important; border: none; cursor:pointer;">
                    @else
                        <input type="hidden" value="{{ $books->id }}" name="edit_id">
                        <input type="submit" value="Պահպանել գիրքը" style="background: #4bb1b1; color: white; height: 40px; margin-top: 15px; font-weight: 500; width: 250px; border-radius: 8px; outline: none!important; border: none; cursor:pointer;">
                    @endif
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
